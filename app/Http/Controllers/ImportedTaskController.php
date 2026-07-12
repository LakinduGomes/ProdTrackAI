<?php

namespace App\Http\Controllers;

use App\Models\ImportedTask;
use App\Models\ImportedTaskSession;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ImportedTaskController extends Controller
{
    /**
     * Column header synonyms used for auto-detection.
     */
    private array $columnSynonyms = [
        'task_name'       => ['task name', 'task', 'title', 'task title', 'name', 'job name', 'work item', 'activity'],
        'task_id'         => ['task id', 'task no', 'task number'],
        'task_type'       => ['task type', 'category', 'type'],
        'assigned_to'     => ['assigned to', 'assignee', 'employee', 'owner', 'resource', 'assignee id', 'assignee name'],
        'priority'        => ['priority'],
        'estimated_hours' => ['estimated hours', 'est hours', 'planned hours', 'estimate'],
        'actual_hours'    => ['actual hours', 'hours spent', 'logged hours'],
        'start_date'      => ['start date', 'started on', 'start', 'created date', 'created on'],
        'due_date'        => ['due date', 'deadline', 'end date', 'due'],
        'completed_date'  => ['completed date', 'completion date', 'finished on', 'completed on'],
        'status'          => ['status', 'task status'],
        'complexity'      => ['complexity'],
        'story_points'    => ['story points', 'story point'],
        'assignee_experience' => ['assignee experience', 'experience level', 'experience'],
        'work_mode'       => ['work mode', 'mode of work'],
        'tasks_assigned_count' => ['tasks assigned count', 'assigned count', 'workload'],
    ];

    public function index()
    {
        $sessions = ImportedTaskSession::withCount('tasks')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('business.import.index', compact('sessions'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->store('imports', 'local');

        $session = ImportedTaskSession::create([
            'user_id'           => Auth::id(),
            'original_filename' => $file->getClientOriginalName(),
            'status'            => 'processing',
        ]);

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, false);

            if (count($data) < 2) {
                throw new \Exception('The file has no data rows.');
            }

            $header = array_map(fn ($h) => strtolower(trim((string) $h)), array_shift($data));
            $map = $this->detectColumns($header);

            if ($map['task_name'] === null && $map['task_id'] === null && $map['task_type'] === null) {
                throw new \Exception(
                    'Could not identify a task name/ID/type column. Headers found: ' . implode(', ', $header)
                );
            }

            $session->update(['column_mapping' => $map, 'total_rows' => count($data)]);

            $rows = [];
            $failed = 0;
            $rowNumber = 1;

            foreach ($data as $row) {
                $rowNumber++;
                $taskName = $this->resolveTaskName($row, $map, $rowNumber);

                if ($taskName === null) {
                    $failed++;
                    continue;
                }

                $rows[] = [
                    'session_id'            => $session->id,
                    'task_name'             => $taskName,
                    'assigned_to'           => $this->col($row, $map, 'assigned_to'),
                    'priority'              => $this->normalizePriority($this->col($row, $map, 'priority')),
                    'complexity'            => $this->col($row, $map, 'complexity'),
                    'estimated_hours'       => $this->toFloat($this->col($row, $map, 'estimated_hours')),
                    'actual_hours'          => $this->toFloat($this->col($row, $map, 'actual_hours')),
                    'story_points'          => $this->toFloat($this->col($row, $map, 'story_points')),
                    'assignee_experience'   => $this->col($row, $map, 'assignee_experience'),
                    'work_mode'             => $this->col($row, $map, 'work_mode'),
                    'tasks_assigned_count'  => $this->toFloat($this->col($row, $map, 'tasks_assigned_count')),
                    'start_date'            => $this->parseDate($this->col($row, $map, 'start_date')),
                    'due_date'              => $this->parseDate($this->col($row, $map, 'due_date')),
                    'completed_date'        => $this->parseDate($this->col($row, $map, 'completed_date')),
                    'status'                => $this->col($row, $map, 'status'),
                    'raw_data'              => json_encode($row),
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ];
            }

            foreach (array_chunk($rows, 500) as $chunk) {
                ImportedTask::insert($chunk);
            }

            $importedTasks = ImportedTask::where('session_id', $session->id)->get();

            $featureImportance = $this->runPredictions($importedTasks);

            $session->update([
                'processed_rows' => $importedTasks->count(),
                'failed_rows'    => $failed,
                'status'         => 'completed',
                'column_mapping' => array_merge($map, ['feature_importance' => $featureImportance]),
            ]);

            Storage::disk('local')->delete($path);

            return redirect()->route('import.analysis', $session->id)
                ->with('success', "Imported {$importedTasks->count()} tasks. {$failed} rows skipped.");

        } catch (\Throwable $e) {
            $session->update([
                'status'    => 'failed',
                'error_log' => $e->getMessage(),
            ]);
            Storage::disk('local')->delete($path);

            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function analysis($id)
    {
        $session = ImportedTaskSession::findOrFail($id);
        $tasks = ImportedTask::where('session_id', $id)->get();

        $totalTasks = $tasks->count();
        $classified = $tasks->whereNotNull('delay_probability');

        $avgDelayProbability = $classified->count() ? round($classified->avg('delay_probability'), 1) : 0;
        $onTimeCount = $tasks->where('predicted_label', 'on-time')->count();
        $delayedCount = $tasks->where('predicted_label', 'delayed')->count();

        $buckets = [
            'Low'      => 0,
            'Moderate' => 0,
            'Elevated' => 0,
            'High'     => 0,
            'Critical' => 0,
        ];

        foreach ($classified as $t) {
            $bucket = $t->delay_risk_bucket ?: $this->classifyBucket((float) $t->delay_probability);
            if (isset($buckets[$bucket])) {
                $buckets[$bucket]++;
            }
        }

        $priorityCounts = [
            'high'   => $tasks->where('priority', 'high')->count(),
            'medium' => $tasks->where('priority', 'medium')->count(),
            'low'    => $tasks->where('priority', 'low')->count(),
        ];

        $riskiestTasks = $classified->sortByDesc('delay_probability')->take(10)->values();

        $users = User::orderBy('first_name')->get(['id', 'first_name', 'last_name']);

        foreach ($riskiestTasks as $t) {
            $t->suggested_user_id = $this->suggestAssigneeId($t->assigned_to, $users);
        }

        $featureImportance = $session->column_mapping['feature_importance'] ?? null;

        if (empty($featureImportance)) {
            $featureImportance = [
                'Estimated Hours'    => 28,
                'Priority'           => 24,
                'Assignee Workload'  => 19,
                'Days to Deadline'   => 17,
                'Task Status'        => 12,
            ];
        }

        return view('business.import.analysis', compact(
            'session',
            'totalTasks',
            'avgDelayProbability',
            'onTimeCount',
            'delayedCount',
            'buckets',
            'priorityCounts',
            'riskiestTasks',
            'featureImportance',
            'users'
        ));
    }

    public function convert(Request $request, $id)
    {
        $importedTask = ImportedTask::findOrFail($id);

        if ($importedTask->converted_task_id) {
            return back()->with('error', 'This task has already been added to the Task Board.');
        }

        $request->validate([
            'assigned_user_id' => 'required|exists:users,id',
            'priority'         => 'nullable|in:low,medium,high',
            'deadline'         => 'nullable|date',
        ]);

        $task = Task::create([
            'title'             => $importedTask->task_name,
            'description'       => $this->buildTaskDescription($importedTask),
            'assigned_user_id'  => $request->assigned_user_id,
            'status'            => 'pending',
            'priority'          => $request->priority ?: ($importedTask->priority ?? 'medium'),
            'deadline'          => $request->deadline ?: optional($importedTask->due_date)->format('Y-m-d'),
        ]);

        $importedTask->update(['converted_task_id' => $task->id]);

        return back()->with('success', "\"{$task->title}\" was added to the Task Board.");
    }

    public function destroy($id)
    {
        $session = ImportedTaskSession::findOrFail($id);
        $session->delete(); // cascades to imported_tasks via FK

        return redirect()->route('import.index')->with('success', 'Import session deleted.');
    }

    /**
     * Send the imported tasks to the Flask ML API for batch delay prediction
     * and write the predictions back onto each ImportedTask row.
     *
     * Matches prodtrack-ml/app.py's /predict-batch contract exactly:
     * request  -> {"tasks": [{task_id, priority, complexity, assignee_experience,
     *              work_mode, estimated_hours, story_points, tasks_assigned_count,
     *              hours_ratio, created_at, deadline}, ...]}
     * response -> {"predictions": [{task_id, delay_probability (0-1),
     *              predicted_outcome: 'delayed'|'on_time', risk_level}, ...]}
     */
    private function runPredictions($tasks): array
    {
        $baseUrl = rtrim(config('services.ml_api.url', 'http://127.0.0.1:5001'), '/');

        $payload = $tasks->map(function ($t) {
            $estimated = $t->estimated_hours ?? 4;
            $actual = $t->actual_hours;
            $hoursRatio = ($actual && $estimated) ? round($actual / $estimated, 2) : 1.0;

            return [
                'task_id'              => $t->id,
                'priority'             => ucfirst($t->priority ?? 'medium'),
                'complexity'           => $t->complexity ?? 'Medium',
                'assignee_experience'  => $t->assignee_experience ?? 'Intermediate',
                'work_mode'            => $t->work_mode ?? 'On-site',
                'estimated_hours'      => $estimated,
                'story_points'         => $t->story_points ?? 5,
                'tasks_assigned_count' => $t->tasks_assigned_count ?? 5,
                'hours_ratio'          => $hoursRatio,
                'created_at'           => optional($t->start_date)->format('Y-m-d'),
                'deadline'             => optional($t->due_date)->format('Y-m-d'),
            ];
        })->values()->all();

        try {
            $response = Http::timeout(60)->post($baseUrl . '/predict-batch', [
                'tasks' => $payload,
            ]);

            if ($response->successful()) {
                $body = $response->json();
                $predictions = $body['predictions'] ?? [];

                \Log::info('Flask predict-batch response', ['count' => count($predictions)]);

                foreach ($predictions as $pred) {
                    if (!isset($pred['task_id'])) {
                        continue;
                    }

                    $probability = isset($pred['delay_probability'])
                        ? round(((float) $pred['delay_probability']) * 100, 2)
                        : null;

                    $label = ($pred['predicted_outcome'] ?? null) === 'on_time' ? 'on-time' : 'delayed';

                    ImportedTask::where('id', $pred['task_id'])->update([
                        'delay_probability' => $probability,
                        'predicted_label'   => $probability !== null ? $label : null,
                        'delay_risk_bucket' => $probability !== null ? $this->classifyBucket($probability) : null,
                    ]);
                }
            } else {
                \Log::error('Flask predict-batch returned non-2xx', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            \Log::error('Flask predict-batch call failed: ' . $e->getMessage());
        }

        return $this->fetchFeatureImportance($baseUrl);
    }

    /**
     * /predict-batch doesn't return feature importance — pull it from
     * /metrics instead. Falls back to an empty array (analysis() has its
     * own static fallback) if /metrics doesn't expose it.
     */
    private function fetchFeatureImportance(string $baseUrl): array
    {
        try {
            $response = Http::timeout(15)->get($baseUrl . '/metrics');

            if ($response->successful()) {
                $metrics = $response->json('metrics') ?? [];

                if (!empty($metrics['feature_importance'])) {
                    return $metrics['feature_importance'];
                }
            }
        } catch (\Throwable $e) {
            \Log::error('Flask /metrics call failed: ' . $e->getMessage());
        }

        return [];
    }

    private function detectColumns(array $header): array
    {
        $map = array_fill_keys(array_keys($this->columnSynonyms), null);

        $normalized = array_map(function ($label) {
            return trim(str_replace(['_', '-', '.'], ' ', strtolower($label)));
        }, $header);

        // Pass 1: exact match only. Safest — resolves "task id" vs "task type"
        // vs a generic "task"/"title" column without any ambiguity.
        foreach ($normalized as $index => $label) {
            if ($label === '') {
                continue;
            }
            foreach ($this->columnSynonyms as $field => $aliases) {
                if ($map[$field] !== null) {
                    continue;
                }
                if (in_array($label, $aliases, true)) {
                    $map[$field] = $index;
                }
            }
        }

        // Pass 2: substring match, but only using multi-word aliases. Single
        // generic words (e.g. "task", "name", "type") are deliberately
        // excluded here so they can't false-match inside longer headers
        // like "task type" or "assignee id" that belong to a different field.
        foreach ($normalized as $index => $label) {
            if ($label === '') {
                continue;
            }
            foreach ($this->columnSynonyms as $field => $aliases) {
                if ($map[$field] !== null) {
                    continue;
                }
                foreach ($aliases as $alias) {
                    if (str_word_count($alias) < 2) {
                        continue;
                    }
                    if (str_contains($label, $alias)) {
                        $map[$field] = $index;
                        break;
                    }
                }
            }
        }

        return $map;
    }

    private function col(array $row, array $map, string $field): ?string
    {
        if ($map[$field] === null) {
            return null;
        }

        $value = trim((string) ($row[$map[$field]] ?? ''));

        return $value === '' ? null : $value;
    }

    /**
     * Resolve a task name from whatever the sheet actually has:
     * a dedicated name column if present, otherwise a fallback built
     * from task_id + task_type (e.g. "Task #1042 - Data Entry").
     * Returns null only if nothing usable was found for this row.
     */
    private function resolveTaskName(array $row, array $map, int $rowNumber): ?string
    {
        $direct = $this->col($row, $map, 'task_name');
        if ($direct !== null) {
            return $direct;
        }

        $parts = [];

        $taskId = $this->col($row, $map, 'task_id');
        if ($taskId !== null) {
            $parts[] = "Task #{$taskId}";
        }

        $taskType = $this->col($row, $map, 'task_type');
        if ($taskType !== null) {
            $parts[] = $taskType;
        }

        if (!empty($parts)) {
            return implode(' - ', $parts);
        }

        return null;
    }

    private function normalizePriority(?string $value): string
    {
        $value = strtolower((string) $value);

        return match (true) {
            str_contains($value, 'high') => 'high',
            str_contains($value, 'low')  => 'low',
            default                      => 'medium',
        };
    }

    private function toFloat(?string $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return is_numeric($value) ? (float) $value : null;
    }

    private function parseDate(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            try {
                return ExcelDate::excelToDateTimeObject((float) $value)->format('Y-m-d');
            } catch (\Throwable $e) {
                return null;
            }
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function classifyBucket(float $probability): string
    {
        return match (true) {
            $probability < 20 => 'Low',
            $probability < 40 => 'Moderate',
            $probability < 60 => 'Elevated',
            $probability < 80 => 'High',
            default            => 'Critical',
        };
    }

    /**
     * Best-effort match of the imported "assigned_to" text against real
     * users by full name. Returns null (no guess) if nothing matches —
     * the person picking the assignee always confirms via the dropdown.
     */
    private function suggestAssigneeId(?string $name, $users): ?int
    {
        if (!$name) {
            return null;
        }

        $name = strtolower(trim($name));

        $match = $users->first(function ($u) use ($name) {
            return strtolower(trim($u->first_name . ' ' . $u->last_name)) === $name;
        });

        return $match?->id;
    }

    private function buildTaskDescription(ImportedTask $t): string
    {
        $lines = [
            "Imported from: {$t->session->original_filename}",
        ];

        if ($t->delay_probability !== null) {
            $lines[] = "Predicted delay risk: {$t->delay_probability}% ({$t->delay_risk_bucket})";
        }

        if ($t->assigned_to) {
            $lines[] = "Assignee in source file: {$t->assigned_to}";
        }

        if ($t->estimated_hours) {
            $lines[] = "Estimated hours: {$t->estimated_hours}";
        }

        return implode("\n", $lines);
    }
}
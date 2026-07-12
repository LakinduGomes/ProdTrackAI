<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    private string $flaskUrl = 'http://127.0.0.1:5001';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function predictions()
    {
        $user       = Auth::user();
        $isReadOnly = in_array($user->level, [3, 4, 5, 6]);

        $predictions = Prediction::with(['task', 'task.assignedUser'])
            ->orderByDesc('delay_probability')
            ->get();

        $tasks = Task::orderBy('title')->get();

        $highRisk   = $predictions->where('delay_probability', '>=', 0.7)->count();
        $mediumRisk = $predictions->whereBetween('delay_probability', [0.4, 0.699])->count();
        $lowRisk    = $predictions->where('delay_probability', '<', 0.4)->count();
        $delayed    = $predictions->where('predicted_outcome', 'delayed')->count();
        $onTime     = $predictions->where('predicted_outcome', 'on_time')->count();

        return view('business.ai.predictions', compact(
            'predictions', 'tasks', 'highRisk', 'mediumRisk', 'lowRisk', 'delayed', 'onTime', 'isReadOnly'
        ));
    }

    public function model()
    {
        $user       = Auth::user();
        $isReadOnly = in_array($user->level, [3, 4, 5, 6]);

        $totalTasks     = Task::count();
        $predictedTasks = Prediction::count();

        $accuracy = $predictedTasks > 0
            ? round((Prediction::where('predicted_outcome', 'on_time')->count() / $predictedTasks) * 100)
            : 0;

        $buckets = [
            '0-20%'   => Prediction::where('delay_probability', '<', 0.2)->count(),
            '20-40%'  => Prediction::whereBetween('delay_probability', [0.2, 0.39])->count(),
            '40-60%'  => Prediction::whereBetween('delay_probability', [0.4, 0.59])->count(),
            '60-80%'  => Prediction::whereBetween('delay_probability', [0.6, 0.79])->count(),
            '80-100%' => Prediction::where('delay_probability', '>=', 0.8)->count(),
        ];

        $featureImportance = [
            'Days Allocated'  => 20,
            'Workload'        => 15,
            'Story Points'    => 15,
            'Estimated Hours' => 12,
            'Hours Ratio'     => 10,
            'Priority'        => 8,
            'Complexity'      => 8,
            'Experience'      => 7,
            'Work Mode'       => 5,
        ];

        $flaskMetrics = null;
        try {
            $response = Http::timeout(5)->get("{$this->flaskUrl}/metrics");
            if ($response->successful()) {
                $data         = $response->json();
                $flaskMetrics = $data['metrics'] ?? null;
                if (!empty($flaskMetrics['feature_importance'])) {
                    $fi     = $flaskMetrics['feature_importance'];
                    $total  = array_sum($fi);
                    $labels = [
                        'priority_enc'         => 'Priority',
                        'complexity_enc'       => 'Complexity',
                        'experience_enc'       => 'Experience',
                        'work_mode_enc'        => 'Work Mode',
                        'estimated_hours'      => 'Estimated Hours',
                        'story_points'         => 'Story Points',
                        'tasks_assigned_count' => 'Workload',
                        'days_allocated'       => 'Days Allocated',
                        'hours_ratio'          => 'Hours Ratio',
                    ];
                    $featureImportance = [];
                    foreach ($fi as $key => $val) {
                        $featureImportance[$labels[$key] ?? $key] = round(($val / $total) * 100);
                    }
                }
            }
        } catch (\Exception $e) {
            // Flask not running — use static values
        }

        return view('business.ai.model', compact(
            'totalTasks', 'predictedTasks', 'accuracy',
            'buckets', 'featureImportance', 'flaskMetrics', 'isReadOnly'
        ));
    }

    public function runPrediction(Request $request)
    {
        $request->validate(['task_id' => 'required|exists:tasks,id']);

        $task = Task::with('assignedUser')->findOrFail($request->task_id);

        $activeTasks = Task::where('assigned_user_id', $task->assigned_user_id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->count();

        try {
            $response = Http::timeout(10)->post("{$this->flaskUrl}/predict", [
                'task_id'              => $task->id,
                'priority'             => ucfirst($task->priority),
                'deadline'             => $task->deadline,
                'created_at'           => $task->created_at->toDateString(),
                'estimated_hours'      => 4,
                'story_points'         => 5,
                'tasks_assigned_count' => $activeTasks,
                'hours_ratio'          => 1.0,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                Prediction::updateOrCreate(
                    ['task_id' => $task->id],
                    [
                        'delay_probability' => $data['delay_probability'],
                        'predicted_outcome' => $data['predicted_outcome'],
                    ]
                );

                return redirect()->back()->with('success', "Prediction: {$data['predicted_outcome']} ({$data['delay_probability']} probability)");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ML API unavailable. Make sure Flask is running: python3 app.py');
        }

        return redirect()->back()->with('error', 'Prediction failed.');
    }

    public function runAllPredictions()
    {
        $tasks = Task::all();

        $payload = $tasks->map(function ($task) {
            $activeTasks = Task::where('assigned_user_id', $task->assigned_user_id)
                ->whereIn('status', ['pending', 'in_progress'])
                ->count();

            return [
                'task_id'              => $task->id,
                'priority'             => ucfirst($task->priority),
                'deadline'             => $task->deadline,
                'created_at'           => $task->created_at->toDateString(),
                'estimated_hours'      => 4,
                'story_points'         => 5,
                'tasks_assigned_count' => $activeTasks,
                'hours_ratio'          => 1.0,
            ];
        })->toArray();

        try {
            $response = Http::timeout(30)->post("{$this->flaskUrl}/predict-batch", [
                'tasks' => $payload,
            ]);

            if ($response->successful()) {
                $predictions = $response->json()['predictions'] ?? [];

                foreach ($predictions as $p) {
                    Prediction::updateOrCreate(
                        ['task_id' => $p['task_id']],
                        [
                            'delay_probability' => $p['delay_probability'],
                            'predicted_outcome' => $p['predicted_outcome'],
                        ]
                    );
                }

                return redirect()->back()->with('success', count($predictions) . ' tasks predicted successfully.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ML API unavailable. Make sure Flask is running: python3 app.py');
        }

        return redirect()->back()->with('error', 'Batch prediction failed.');
    }
}
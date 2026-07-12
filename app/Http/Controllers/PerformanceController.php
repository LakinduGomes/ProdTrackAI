<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Prediction;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function workload()
    {
        $employees = User::where('level', 2)
            ->withCount([
                'tasks as total_tasks',
                'tasks as completed_tasks'  => fn($q) => $q->where('status', 'completed'),
                'tasks as inprogress_tasks' => fn($q) => $q->where('status', 'in_progress'),
                'tasks as overdue_tasks'    => fn($q) => $q->where('status', 'overdue'),
                'tasks as pending_tasks'    => fn($q) => $q->where('status', 'pending'),
            ])
            ->get();

        $totalTasks    = Task::count();
        $totalEmployees = $employees->count();
        $avgTasks      = $totalEmployees > 0 ? round($totalTasks / $totalEmployees, 1) : 0;
        $overloaded    = $employees->filter(fn($e) => $e->total_tasks > $avgTasks * 1.5)->count();

        return view('business.performance.workload', compact(
            'employees', 'totalTasks', 'totalEmployees', 'avgTasks', 'overloaded'
        ));
    }

    public function reports()
    {
        $totalTasks      = Task::count();
        $completedTasks  = Task::where('status', 'completed')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $overdueTasks    = Task::where('status', 'overdue')->count();
        $pendingTasks    = Task::where('status', 'pending')->count();

        $completionRate  = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        $overdueRate     = $totalTasks > 0 ? round(($overdueTasks / $totalTasks) * 100) : 0;

        // Tasks per priority
        $byPriority = Task::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority');

        // Tasks per employee
        $byEmployee = User::where('level', 2)
            ->withCount('tasks')
            ->orderByDesc('tasks_count')
            ->get();

        // Completion trend last 30 days
        $trend = Task::where('status', 'completed')
            ->where('updated_at', '>=', now()->subDays(29))
            ->selectRaw('DATE(updated_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('count', 'day');

        $trendLabels = [];
        $trendCounts = [];
        for ($i = 29; $i >= 0; $i--) {
            $date          = now()->subDays($i)->toDateString();
            $trendLabels[] = now()->subDays($i)->format('M d');
            $trendCounts[] = $trend[$date] ?? 0;
        }

        return view('business.performance.reports', compact(
            'totalTasks', 'completedTasks', 'inProgressTasks', 'overdueTasks', 'pendingTasks',
            'completionRate', 'overdueRate', 'byPriority', 'byEmployee', 'trendLabels', 'trendCounts'
        ));
    }

    public function analytics()
    {
        // Weekly task completion last 8 weeks
        $weeklyData = [];
        $weeklyLabels = [];
        for ($i = 7; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek();
            $end   = now()->subWeeks($i)->endOfWeek();
            $weeklyLabels[] = 'W' . $start->weekOfYear;
            $weeklyData[]   = Task::where('status', 'completed')
                ->whereBetween('updated_at', [$start, $end])
                ->count();
        }

        // Status distribution
        $statusCounts = [
            'completed'  => Task::where('status', 'completed')->count(),
            'in_progress'=> Task::where('status', 'in_progress')->count(),
            'overdue'    => Task::where('status', 'overdue')->count(),
            'pending'    => Task::where('status', 'pending')->count(),
        ];

        // Priority distribution
        $priorityCounts = Task::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority');

        // Top performers (most completed tasks)
        $topPerformers = User::where('level', 2)
            ->withCount(['tasks as completed_tasks' => fn($q) => $q->where('status', 'completed')])
            ->orderByDesc('completed_tasks')
            ->take(5)
            ->get();

        return view('business.performance.analytics', compact(
            'weeklyLabels', 'weeklyData', 'statusCounts', 'priorityCounts', 'topPerformers'
        ));
    }
}
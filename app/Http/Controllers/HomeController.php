<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Notification;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user      = Auth::user();
        $id        = $user->id;
        $level     = $user->level;

        $isAdmin    = $level == 999;
        $isManager  = $level == 1;
        $isEmployee = $level == 2;
        $isReadOnly = in_array($level, [3, 4, 5, 6]);

        // ── Task query scope ─────────────────────────────────────────────────
        // Admin + Manager + ReadOnly → all tasks
        // Employee → only their own tasks
        $taskQuery = $isEmployee
            ? Task::where('assigned_user_id', $id)
            : Task::query();

        $totalTasks      = (clone $taskQuery)->count();
        $completedTasks  = (clone $taskQuery)->where('status', 'completed')->count();
        $inProgressTasks = (clone $taskQuery)->where('status', 'in_progress')->count();
        $overdueTasks    = (clone $taskQuery)->where('status', 'overdue')->count();

        // ── Prediction query scope ───────────────────────────────────────────
        // Employee → no predictions shown
        $highRiskTasks     = 0;
        $onTimeTasks       = 0;
        $delayedTasks      = 0;
        $recentPredictions = collect();

        if (!$isEmployee) {
            $predQuery         = Prediction::with('task');
            $highRiskTasks     = (clone $predQuery)->where('delay_probability', '>=', 0.7)->count();
            $onTimeTasks       = (clone $predQuery)->where('predicted_outcome', 'on_time')->count();
            $delayedTasks      = (clone $predQuery)->where('predicted_outcome', 'delayed')->count();
            $recentPredictions = (clone $predQuery)->orderByDesc('delay_probability')->take(5)->get();
        }

        // ── Workload data ────────────────────────────────────────────────────
        // Only Admin, Manager, ReadOnly see workload
        $workloadData = collect();
        if (!$isEmployee) {
            $workloadData = User::where('level', 2)
                ->withCount(['tasks as active_tasks' => fn($q) => $q->whereIn('status', ['in_progress', 'overdue'])])
                ->take(6)
                ->get();
        }

        // ── Completion trend – last 7 days ───────────────────────────────────
        $completionTrend = (clone $taskQuery)
            ->where('status', 'completed')
            ->where('updated_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(updated_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('count', 'day');

        $trendLabels = [];
        $trendCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date          = now()->subDays($i)->toDateString();
            $trendLabels[] = now()->subDays($i)->format('M d');
            $trendCounts[] = $completionTrend[$date] ?? 0;
        }

        // ── Notifications ─────────────────────────────────────────────────────
        $notifications = Notification::where('user_id', $id)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', $id)->where('is_read', false)->count();

        return view('business.home', compact(
            'user',
            'isAdmin',
            'isManager',
            'isEmployee',
            'isReadOnly',
            'totalTasks',
            'completedTasks',
            'inProgressTasks',
            'overdueTasks',
            'highRiskTasks',
            'onTimeTasks',
            'delayedTasks',
            'recentPredictions',
            'workloadData',
            'trendLabels',
            'trendCounts',
            'notifications',
            'unreadCount'
        ));
    }

    public function getNotifications(Request $request)
    {
        $page   = $request->get('page', 1);
        $offset = ($page - 1) * 10;

        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->skip($offset)->take(10)->get();

        $total   = Notification::where('user_id', Auth::id())->count();
        $hasMore = $total > ($offset + 10);

        return response()->json(['notifications' => $notifications, 'hasMore' => $hasMore, 'currentPage' => $page]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', Auth::id())->first();
        if ($notification) {
            $notification->update(['is_read' => true]);
            return redirect($notification->link);
        }
        return redirect()->back();
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())->where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function removeNotification($id)
    {
        $deleted = Notification::where('id', $id)->where('user_id', Auth::id())->delete();
        return response()->json(['success' => (bool) $deleted]);
    }

    public function clearAllNotifications()
    {
        Notification::where('user_id', Auth::id())->delete();
        return response()->json(['success' => true]);
    }
}
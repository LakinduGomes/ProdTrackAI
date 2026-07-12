<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Task;
use App\Models\User;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ── Auto-assign: find employee with least active tasks ────────────────────
    private function getAutoAssignUser(): ?User
    {
        return User::where('level', 2)
            ->where('status', 1)
            ->withCount(['tasks as active_tasks' => fn($q) => $q->whereIn('status', ['pending', 'in_progress'])])
            ->orderBy('active_tasks', 'asc')
            ->first();
    }

    // ── Manager/Admin: all tasks ──────────────────────────────────────────────
    public function index()
    {
        $tasks     = Task::with(['assignedUser', 'prediction'])->orderByDesc('created_at')->get();
        $employees = User::where('level', 2)->where('status', 1)
            ->withCount(['tasks as active_tasks' => fn($q) => $q->whereIn('status', ['pending', 'in_progress'])])
            ->orderBy('active_tasks', 'asc')
            ->get();

        // Auto-assign suggestion
        $suggestedUser = $this->getAutoAssignUser();

        $totalTasks      = $tasks->count();
        $completedTasks  = $tasks->where('status', 'completed')->count();
        $inProgressTasks = $tasks->where('status', 'in_progress')->count();
        $overdueTasks    = $tasks->where('status', 'overdue')->count();
        $pendingTasks    = $tasks->where('status', 'pending')->count();

        $isReadOnly = !in_array(Auth::user()->level, [999, 1, 3, 4, 5, 6]);

        return view('business.tasks.index', compact(
            'tasks',
            'employees',
            'suggestedUser',
            'totalTasks',
            'completedTasks',
            'inProgressTasks',
            'overdueTasks',
            'pendingTasks',
            'isReadOnly'
        ));
    }

    // ── Employee: only their own tasks ────────────────────────────────────────
    public function myTasks()
    {
        $id    = Auth::id();
        $tasks = Task::with('prediction')->where('assigned_user_id', $id)->orderByDesc('created_at')->get();

        $totalTasks      = $tasks->count();
        $completedTasks  = $tasks->where('status', 'completed')->count();
        $inProgressTasks = $tasks->where('status', 'in_progress')->count();
        $overdueTasks    = $tasks->where('status', 'overdue')->count();
        $pendingTasks    = $tasks->where('status', 'pending')->count();

        return view('business.tasks.my', compact(
            'tasks',
            'totalTasks',
            'completedTasks',
            'inProgressTasks',
            'overdueTasks',
            'pendingTasks'
        ));
    }

    // ── API: get auto-assign suggestion ───────────────────────────────────────
    public function getAutoAssignSuggestion()
    {
        $user = $this->getAutoAssignUser();
        if ($user) {
            return response()->json([
                'success'      => true,
                'user_id'      => $user->id,
                'name'         => $user->first_name . ' ' . $user->last_name,
                'active_tasks' => $user->active_tasks,
            ]);
        }
        return response()->json(['success' => false, 'message' => 'No employees available.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'assigned_user_id' => 'required|exists:users,id',
            'priority'         => 'required|in:low,medium,high',
            'deadline'         => 'required|date',
            'status'           => 'required|in:pending,in_progress,completed,overdue',
        ]);

        $task = Task::create($request->only(
            'title',
            'description',
            'assigned_user_id',
            'priority',
            'deadline',
            'status'
        ));

        $assignedUser = User::find($request->assigned_user_id);

        AuditLog::log(
            'CREATE',
            'Tasks',
            "Task '{$task->title}' created and assigned to {$assignedUser?->first_name} {$assignedUser?->last_name}",
            [],
            $task->toArray()
        );

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'assigned_user_id' => 'required|exists:users,id',
            'priority'         => 'required|in:low,medium,high',
            'deadline'         => 'required|date',
            'status'           => 'required|in:pending,in_progress,completed,overdue',
        ]);

        $task     = Task::findOrFail($id);
        $oldData  = $task->toArray();

        $task->update($request->only(
            'title',
            'description',
            'assigned_user_id',
            'priority',
            'deadline',
            'status'
        ));

        AuditLog::log(
            'UPDATE',
            'Tasks',
            "Task '{$task->title}' updated",
            $oldData,
            $task->fresh()->toArray()
        );

        return redirect()->back()->with('success', 'Task updated.');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        AuditLog::log(
            'DELETE',
            'Tasks',
            "Task '{$task->title}' deleted",
            $task->toArray(),
            []
        );

        $task->delete();

        return redirect()->back()->with('success', 'Task deleted.');
    }

    // ── Employee updates their own task status ────────────────────────────────
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,in_progress,completed,overdue']);

        $task    = Task::where('id', $id)->where('assigned_user_id', Auth::id())->firstOrFail();
        $oldStatus = $task->status;

        $task->update(['status' => $request->status]);

        AuditLog::log(
            'STATUS_CHANGE',
            'Tasks',
            "Task '{$task->title}' status changed from '{$oldStatus}' to '{$request->status}'",
            ['status' => $oldStatus],
            ['status' => $request->status]
        );

        return redirect()->back()->with('success', 'Status updated.');
    }
}

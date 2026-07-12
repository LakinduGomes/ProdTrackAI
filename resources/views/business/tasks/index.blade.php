@extends('layouts.business')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --accent: #6366f1;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --surface: #fff;
            --bg: #f8fafc;
            --muted: #64748b;
            --border: rgba(0, 0, 0, 0.06);
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        body,
        .content-wrapper {
            background: var(--bg) !important;
            font-family: 'DM Sans', sans-serif;
        }

        .pt-page {
            padding: 1.5rem;
        }

        .pt-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .pt-sub {
            color: var(--muted);
            font-size: .82rem;
            margin-top: 2px;
        }

        .kpi-row {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .kpi {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1rem 1.2rem;
            box-shadow: var(--shadow);
        }

        .kpi-val {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #0f172a;
        }

        .kpi-lbl {
            font-size: .7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--muted);
        }

        .card-pt {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 1.25rem;
            box-shadow: var(--shadow);
        }

        .btn-pt {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .5rem 1.1rem;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
        }

        .btn-pt:hover {
            background: #4f46e5;
            color: #fff;
        }

        .badge-status {
            font-size: .65rem;
            font-weight: 700;
            padding: .25rem .65rem;
            border-radius: 8px;
            text-transform: uppercase;
        }

        .badge-status.completed {
            background: #dcfce7;
            color: #16a34a;
        }

        .badge-status.in_progress {
            background: #e0e7ff;
            color: #4338ca;
        }

        .badge-status.overdue {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-status.pending {
            background: #fef9c3;
            color: #b45309;
        }

        .badge-pri {
            font-size: .62rem;
            font-weight: 700;
            padding: .2rem .55rem;
            border-radius: 6px;
        }

        .badge-pri.high {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-pri.medium {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-pri.low {
            background: #dcfce7;
            color: #16a34a;
        }

        .pt-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 .4rem;
        }

        .pt-table thead th {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--muted);
            padding: .4rem .9rem;
            border: none;
        }

        .pt-table tbody tr {
            background: #f8fafc;
            transition: .2s;
        }

        .pt-table tbody tr:hover {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
        }

        .pt-table tbody td {
            padding: .75rem .9rem;
            font-size: .82rem;
            color: #0f172a;
            border: none;
        }

        .pt-table tbody td:first-child {
            border-radius: 10px 0 0 10px;
        }

        .pt-table tbody td:last-child {
            border-radius: 0 10px 10px 0;
        }

        .modal-content {
            border-radius: 18px;
            border: none;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            font-size: .85rem;
            border: 1px solid #e2e8f0;
        }

        .form-label {
            font-size: .78rem;
            font-weight: 600;
            color: #374151;
        }

        .auto-assign-box {
            background: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 10px;
            padding: .65rem 1rem;
            font-size: .8rem;
            color: #15803d;
            margin-bottom: 1rem;
            display: none;
        }

        .workload-pill {
            font-size: .65rem;
            font-weight: 600;
            padding: .15rem .5rem;
            border-radius: 6px;
            background: #e0e7ff;
            color: #4338ca;
            margin-left: 4px;
        }
    </style>

    <div class="pt-page">
        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <div class="pt-title"><i class="fas fa-layer-group me-2 text-primary"></i>Task Board</div>
                <div class="pt-sub">Manage and monitor all tasks across your team</div>
            </div>
            @if (!$isReadOnly)
                <button class="btn-pt" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                    <i class="fas fa-plus me-1"></i> New Task
                </button>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-3 mb-3" style="font-size:.83rem;">{{ session('success') }}</div>
        @endif

        {{-- KPIs --}}
        <div class="kpi-row">
            <div class="kpi">
                <div class="kpi-val">{{ $totalTasks }}</div>
                <div class="kpi-lbl">Total</div>
            </div>
            <div class="kpi" style="border-left:3px solid #10b981">
                <div class="kpi-val" style="color:#10b981">{{ $completedTasks }}</div>
                <div class="kpi-lbl">Completed</div>
            </div>
            <div class="kpi" style="border-left:3px solid #6366f1">
                <div class="kpi-val" style="color:#6366f1">{{ $inProgressTasks }}</div>
                <div class="kpi-lbl">In Progress</div>
            </div>
            <div class="kpi" style="border-left:3px solid #ef4444">
                <div class="kpi-val" style="color:#ef4444">{{ $overdueTasks }}</div>
                <div class="kpi-lbl">Overdue</div>
            </div>
            <div class="kpi" style="border-left:3px solid #f59e0b">
                <div class="kpi-val" style="color:#f59e0b">{{ $pendingTasks }}</div>
                <div class="kpi-lbl">Pending</div>
            </div>
        </div>

        {{-- Filter bar --}}
        <div class="card-pt mb-3">
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <select class="form-select form-select-sm" style="width:auto;" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="overdue">Overdue</option>
                </select>
                <select class="form-select form-select-sm" style="width:auto;" id="filterPriority">
                    <option value="">All Priority</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
                <input type="text" class="form-control form-control-sm" style="width:200px;" id="searchTask"
                    placeholder="Search tasks...">
            </div>
        </div>

        {{-- Tasks Table --}}
        <div class="card-pt">
            <div style="overflow-x:auto;">
                <table class="pt-table" id="tasksTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Assigned To</th>
                            <th>Priority</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>AI Risk</th>
                            @if (!$isReadOnly)
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr data-status="{{ $task->status }}" data-priority="{{ $task->priority }}">
                                <td style="color:var(--muted);font-size:.75rem;">#{{ $task->id }}</td>
                                <td>
                                    <div style="font-weight:600;">{{ $task->title }}</div>
                                    <div style="font-size:.72rem;color:var(--muted);">
                                        {{ Str::limit($task->description, 40) }}</div>
                                </td>
                                <td>
                                    {{ $task->assignedUser->first_name ?? '—' }}
                                    {{ $task->assignedUser->last_name ?? '' }}
                                    @if ($task->assignedUser)
                                        @php
                                            $activeCount = $task->assignedUser
                                                ->tasks()
                                                ->whereIn('status', ['pending', 'in_progress'])
                                                ->count();
                                        @endphp
                                        <span class="workload-pill">{{ $activeCount }} active</span>
                                    @endif
                                </td>
                                <td><span class="badge-pri {{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}
                                    @if (\Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'completed')
                                        <div style="font-size:.68rem;color:var(--danger);">
                                            {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</div>
                                    @endif
                                </td>
                                <td><span
                                        class="badge-status {{ $task->status }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                                </td>
                                <td>
                                    @if ($task->prediction)
                                        @php $pct = round($task->prediction->delay_probability * 100); @endphp
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:40px;background:#e2e8f0;border-radius:999px;height:5px;">
                                                <div
                                                    style="width:{{ $pct }}%;height:100%;border-radius:999px;background:{{ $pct >= 70 ? '#ef4444' : ($pct >= 40 ? '#f59e0b' : '#10b981') }};">
                                                </div>
                                            </div>
                                            <span
                                                style="font-size:.72rem;font-weight:700;color:{{ $pct >= 70 ? '#ef4444' : ($pct >= 40 ? '#d97706' : '#16a34a') }};">{{ $pct }}%</span>
                                        </div>
                                    @else
                                        <span style="font-size:.72rem;color:var(--muted);">No data</span>
                                    @endif
                                </td>
                                @if (!$isReadOnly)
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-light border"
                                                onclick="editTask({{ $task->id }},'{{ addslashes($task->title) }}','{{ addslashes($task->description) }}',{{ $task->assigned_user_id }},'{{ $task->priority }}','{{ $task->deadline }}','{{ $task->status }}')">
                                                <i class="fas fa-edit" style="font-size:11px;"></i>
                                            </button>
                                            <form method="POST" action="{{ route('business.tasks.destroy', $task->id) }}"
                                                onsubmit="return confirm('Delete this task?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-light border text-danger"><i
                                                        class="fas fa-trash" style="font-size:11px;"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4" style="color:var(--muted);">No tasks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Create Task Modal --}}
    @if (!$isReadOnly)
        <div class="modal fade" id="createTaskModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-2">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title" style="font-family:'Syne',sans-serif;font-weight:800;">New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('business.tasks.store') }}">
                        @csrf
                        <div class="modal-body">

                            {{-- Auto-assign suggestion box --}}
                            <div class="auto-assign-box" id="autoAssignBox">
                                <i class="fas fa-magic me-2"></i>
                                <span id="autoAssignText"></span>
                                <button type="button" class="btn btn-sm ms-2"
                                    style="background:#16a34a;color:#fff;border-radius:6px;font-size:.72rem;padding:.2rem .6rem;"
                                    onclick="applyAutoAssign()">Apply</button>
                            </div>

                            <div class="mb-3"><label class="form-label">Title</label><input name="title"
                                    class="form-control" required></div>
                            <div class="mb-3"><label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-flex justify-content-between">
                                    <span>Assign To</span>
                                    <button type="button" class="btn btn-sm"
                                        style="background:#e0e7ff;color:#4338ca;border-radius:6px;font-size:.72rem;padding:.2rem .7rem;border:none;"
                                        onclick="triggerAutoAssign()">
                                        <i class="fas fa-magic me-1"></i>Auto-Assign
                                    </button>
                                </label>
                                <select name="assigned_user_id" id="assigned_user_id" class="form-select" required>
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $emp)
                                        <option value="{{ $emp->id }}"
                                            {{ $suggestedUser && $suggestedUser->id == $emp->id ? 'data-suggested=1' : '' }}>
                                            {{ $emp->first_name }} {{ $emp->last_name }} ({{ $emp->active_tasks }}
                                            active)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label">Priority</label>
                                    <select name="priority" class="form-select" required>
                                        <option value="low">Low</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="pending" selected>Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="overdue">Overdue</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3"><label class="form-label">Deadline</label><input type="date"
                                    name="deadline" class="form-control" required></div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-pt">Create Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Task Modal --}}
        <div class="modal fade" id="editTaskModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-2">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title" style="font-family:'Syne',sans-serif;font-weight:800;">Edit Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" id="editTaskForm">
                        @csrf @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3"><label class="form-label">Title</label><input name="title"
                                    id="edit_title" class="form-control" required></div>
                            <div class="mb-3"><label class="form-label">Description</label>
                                <textarea name="description" id="edit_description" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Assign To</label>
                                <select name="assigned_user_id" id="edit_assigned" class="form-select" required>
                                    @foreach ($employees as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }}
                                            ({{ $emp->active_tasks }} active)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label">Priority</label>
                                    <select name="priority" id="edit_priority" class="form-select">
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" id="edit_status" class="form-select">
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="overdue">Overdue</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3"><label class="form-label">Deadline</label><input type="date"
                                    name="deadline" id="edit_deadline" class="form-control" required></div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-pt">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        var suggestedUserId = {{ $suggestedUser ? $suggestedUser->id : 'null' }};
        var suggestedUserName = "{{ $suggestedUser ? $suggestedUser->first_name . ' ' . $suggestedUser->last_name : '' }}";
        var suggestedUserTasks = {{ $suggestedUser ? $suggestedUser->active_tasks : 0 }};

        function triggerAutoAssign() {
            if (suggestedUserId) {
                document.getElementById('autoAssignText').textContent =
                    `Suggested: ${suggestedUserName} (${suggestedUserTasks} active tasks — least loaded)`;
                document.getElementById('autoAssignBox').style.display = 'block';
            } else {
                alert('No employees available for auto-assign.');
            }
        }

        function applyAutoAssign() {
            if (suggestedUserId) {
                document.getElementById('assigned_user_id').value = suggestedUserId;
                document.getElementById('autoAssignBox').style.display = 'none';
            }
        }

        function editTask(id, title, desc, assigned, priority, deadline, status) {
            document.getElementById('editTaskForm').action = `/tasks/${id}`;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_description').value = desc;
            document.getElementById('edit_assigned').value = assigned;
            document.getElementById('edit_priority').value = priority;
            document.getElementById('edit_deadline').value = deadline;
            document.getElementById('edit_status').value = status;
            new bootstrap.Modal(document.getElementById('editTaskModal')).show();
        }

        document.getElementById('filterStatus').addEventListener('change', filterTasks);
        document.getElementById('filterPriority').addEventListener('change', filterTasks);
        document.getElementById('searchTask').addEventListener('input', filterTasks);

        function filterTasks() {
            const status = document.getElementById('filterStatus').value;
            const priority = document.getElementById('filterPriority').value;
            const search = document.getElementById('searchTask').value.toLowerCase();
            document.querySelectorAll('#tasksTable tbody tr').forEach(row => {
                const matchStatus = !status || row.dataset.status === status;
                const matchPriority = !priority || row.dataset.priority === priority;
                const matchSearch = !search || row.innerText.toLowerCase().includes(search);
                row.style.display = matchStatus && matchPriority && matchSearch ? '' : 'none';
            });
        }
    </script>
@endsection

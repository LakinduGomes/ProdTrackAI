@extends('layouts.business')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --accent: #818CF8;
            --accent-strong: #6366F1;
            --accent-dim: rgba(129, 140, 248, 0.14);
            --success: #34D399;
            --success-bg: rgba(52, 211, 153, 0.14);
            --warning: #FBBF24;
            --warning-bg: rgba(251, 191, 36, 0.14);
            --danger: #F87171;
            --danger-bg: rgba(248, 113, 113, 0.14);
            --bg: #0A0D14;
            --surface: #12161F;
            --surface-2: #171C27;
            --surface-3: #1D2330;
            --text: #E7E9EE;
            --muted: #8891A5;
            --border: rgba(255, 255, 255, 0.07);
            --border-strong: rgba(255, 255, 255, 0.14);
            --shadow: 0 1px 2px rgba(0, 0, 0, 0.3), 0 8px 24px rgba(0, 0, 0, 0.35);
            --mono: 'JetBrains Mono', monospace;
            --display: 'Manrope', sans-serif;
            --body: 'Inter', sans-serif;
        }

        html {
            background: var(--bg) !important;
            color-scheme: dark;
        }

        .pt-table,
        .pt-table thead,
        .pt-table tbody,
        .pt-table tr,
        .pt-table th,
        .pt-table td {
            background-color: transparent !important;
        }

        .pt-table tbody tr {
            background-color: var(--surface-2) !important;
        }

        .pt-table tbody tr:hover {
            background-color: var(--surface-3) !important;
        }

        .pt-table tbody td:first-child,
        .pt-table tbody td:last-child {
            background-color: transparent !important;
        }

        body,
        .content-wrapper {
            background: var(--bg) !important;
            font-family: var(--body);
            color: var(--text);
        }

        ::selection {
            background: var(--accent-dim);
            color: var(--text);
        }

        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--surface);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--surface-3);
            border-radius: 8px;
            border: 2px solid var(--surface);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--border-strong);
        }

        * {
            scrollbar-color: var(--surface-3) var(--surface);
        }

        .modal-backdrop.show {
            opacity: 0.6;
        }

        .pt-page {
            padding: 1.5rem;
        }

        .pt-title {
            font-family: var(--display);
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text);
            margin: 0;
            letter-spacing: -.01em;
        }

        .pt-title i {
            color: var(--accent);
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
            position: relative;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.1rem 1.2rem;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .kpi::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--kpi-glow, var(--accent));
            box-shadow: 0 0 12px var(--kpi-glow, var(--accent));
        }

        .kpi-val {
            font-family: var(--display);
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--text);
        }

        .kpi-lbl {
            font-size: .68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-top: 2px;
        }

        .card-pt {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 1.25rem;
            box-shadow: var(--shadow);
        }

        .btn-pt {
            background: var(--accent-strong);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .55rem 1.15rem;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
            box-shadow: 0 0 0 1px rgba(129, 140, 248, 0.3), 0 4px 14px rgba(99, 102, 241, 0.25);
        }

        .btn-pt:hover {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 0 0 1px rgba(129, 140, 248, 0.5), 0 6px 18px rgba(99, 102, 241, 0.35);
        }

        .badge-status {
            font-size: .65rem;
            font-weight: 700;
            padding: .28rem .65rem;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: .03em;
            border: 1px solid transparent;
        }

        .badge-status.completed {
            background: var(--success-bg);
            color: var(--success);
            border-color: rgba(52, 211, 153, 0.25);
        }

        .badge-status.in_progress {
            background: var(--accent-dim);
            color: var(--accent);
            border-color: rgba(129, 140, 248, 0.25);
        }

        .badge-status.overdue {
            background: var(--danger-bg);
            color: var(--danger);
            border-color: rgba(248, 113, 113, 0.25);
        }

        .badge-status.pending {
            background: var(--warning-bg);
            color: var(--warning);
            border-color: rgba(251, 191, 36, 0.25);
        }

        .badge-pri {
            font-size: .62rem;
            font-weight: 700;
            padding: .2rem .55rem;
            border-radius: 6px;
            white-space: nowrap;
        }

        .badge-pri.high {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .badge-pri.medium {
            background: var(--warning-bg);
            color: var(--warning);
        }

        .badge-pri.low {
            background: var(--success-bg);
            color: var(--success);
        }

        .pt-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 .4rem;
            background: transparent;
        }

        .pt-table thead th {
            font-size: .66rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
            padding: .4rem .9rem;
            border: none;
            background: transparent;
        }

        .pt-table tbody tr {
            background: var(--surface-2);
            transition: .2s;
        }

        .pt-table tbody tr:hover {
            background: var(--surface-3);
            box-shadow: 0 0 0 1px var(--border-strong);
        }

        .pt-table tbody td {
            padding: .75rem .9rem;
            font-size: .82rem;
            color: var(--text);
            border: none;
            vertical-align: middle;
        }

        .pt-table tbody td:first-child {
            border-radius: 10px 0 0 10px;
            color: var(--muted);
            font-family: var(--mono);
            font-size: .74rem;
        }

        .pt-table tbody td:last-child {
            border-radius: 0 10px 10px 0;
        }

        .task-desc {
            font-size: .72rem;
            color: var(--muted);
        }

        .task-source {
            font-size: .68rem;
            color: var(--muted);
            opacity: .75;
        }

        .deadline-overdue {
            font-size: .68rem;
            color: var(--danger);
            font-family: var(--mono);
        }

        .assignee-cell {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .35rem;
            row-gap: .3rem;
        }

        .assignee-name {
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
        }

        .modal-content {
            border-radius: 18px;
            border: 1px solid var(--border-strong);
            background: var(--surface);
            color: var(--text);
        }

        .modal-title {
            color: var(--text);
        }

        .btn-close {
            filter: invert(1) grayscale(1) brightness(1.6);
        }

        .form-control,
        .form-select,
        input,
        select,
        textarea {
            border-radius: 10px;
            font-size: .85rem;
            border: 1px solid var(--border-strong);
            background: var(--surface-2) !important;
            color: var(--text) !important;
        }

        .form-control:focus,
        .form-select:focus,
        input:focus,
        select:focus,
        textarea:focus {
            background: var(--surface-2) !important;
            color: var(--text) !important;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim);
        }

        .form-control::placeholder,
        input::placeholder,
        textarea::placeholder {
            color: var(--muted) !important;
            opacity: 1;
        }

        .form-select option,
        select option {
            background: var(--surface-2);
            color: var(--text);
        }

        .form-label {
            font-size: .78rem;
            font-weight: 600;
            color: var(--muted);
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1) brightness(1.6);
            cursor: pointer;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: var(--text) !important;
            -webkit-box-shadow: 0 0 0 1000px var(--surface-2) inset !important;
            caret-color: var(--text);
        }

        .btn-light.border {
            background: var(--surface-2);
            border-color: var(--border-strong) !important;
            color: var(--text);
        }

        .btn-light.border:hover {
            background: var(--surface-3);
            color: var(--text);
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid rgba(52, 211, 153, 0.25);
        }

        .auto-assign-box {
            background: var(--success-bg);
            border: 1px solid rgba(52, 211, 153, 0.3);
            border-radius: 10px;
            padding: .65rem 1rem;
            font-size: .8rem;
            color: var(--success);
            margin-bottom: 1rem;
            display: none;
        }

        .workload-pill {
            font-size: .62rem;
            font-weight: 600;
            padding: .15rem .5rem;
            border-radius: 6px;
            background: var(--accent-dim);
            color: var(--accent);
            white-space: nowrap;
        }

        .risk-cell {
            display: flex;
            align-items: center;
            gap: .55rem;
        }

        .risk-ring {
            --pct: 0;
            --ring-color: var(--success);
            width: 34px;
            height: 34px;
            border-radius: 50%;
            position: relative;
            background: conic-gradient(var(--ring-color) calc(var(--pct) * 1%), rgba(255, 255, 255, 0.08) 0);
            flex-shrink: 0;
        }

        .risk-ring::before {
            content: '';
            position: absolute;
            inset: 3px;
            border-radius: 50%;
            background: var(--surface-2);
        }

        .risk-ring-val {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--mono);
            font-size: .58rem;
            font-weight: 700;
            color: var(--ring-color);
        }

        .risk-lbl {
            font-size: .68rem;
            color: var(--muted);
            font-family: var(--mono);
            white-space: nowrap;
        }

        .no-data-lbl {
            font-size: .72rem;
            color: var(--muted);
        }
    </style>

    <div class="pt-page">
        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <div class="pt-title"><i class="fas fa-layer-group me-2"></i>Task Board</div>
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

        <div class="kpi-row">
            <div class="kpi">
                <div class="kpi-val">{{ $totalTasks }}</div>
                <div class="kpi-lbl">Total</div>
            </div>
            <div class="kpi" style="--kpi-glow:#34D399">
                <div class="kpi-val" style="color:#34D399">{{ $completedTasks }}</div>
                <div class="kpi-lbl">Completed</div>
            </div>
            <div class="kpi" style="--kpi-glow:#818CF8">
                <div class="kpi-val" style="color:#818CF8">{{ $inProgressTasks }}</div>
                <div class="kpi-lbl">In Progress</div>
            </div>
            <div class="kpi" style="--kpi-glow:#F87171">
                <div class="kpi-val" style="color:#F87171">{{ $overdueTasks }}</div>
                <div class="kpi-lbl">Overdue</div>
            </div>
            <div class="kpi" style="--kpi-glow:#FBBF24">
                <div class="kpi-val" style="color:#FBBF24">{{ $pendingTasks }}</div>
                <div class="kpi-lbl">Pending</div>
            </div>
        </div>

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
                                <td>#{{ $task->id }}</td>
                                <td>
                                    <div style="font-weight:600;">{{ $task->title }}</div>
                                    <div class="task-desc">{{ Str::limit($task->description, 40) }}</div>
                                </td>
                                <td>
                                    <div class="assignee-cell">
                                        <span class="assignee-name">
                                            {{ $task->assignedUser->first_name ?? '—' }}
                                            {{ $task->assignedUser->last_name ?? '' }}
                                        </span>
                                        @if ($task->assignedUser)
                                            @php
                                                $activeCount = $task->assignedUser
                                                    ->tasks()
                                                    ->whereIn('status', ['pending', 'in_progress'])
                                                    ->count();
                                            @endphp
                                            <span class="workload-pill">{{ $activeCount }} active</span>
                                        @endif
                                    </div>
                                </td>
                                <td><span class="badge-pri {{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}
                                    @if (\Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'completed')
                                        <div class="deadline-overdue">
                                            {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</div>
                                    @endif
                                </td>
                                <td><span
                                        class="badge-status {{ $task->status }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                                </td>
                                <td>
                                    @if ($task->prediction)
                                        @php
                                            $pct = round($task->prediction->delay_probability * 100);
                                            $ringColor = $pct >= 70 ? '#F87171' : ($pct >= 40 ? '#FBBF24' : '#34D399');
                                        @endphp
                                        <div class="risk-cell">
                                            <div class="risk-ring" style="--pct:{{ $pct }};--ring-color:{{ $ringColor }}">
                                                <div class="risk-ring-val">{{ $pct }}</div>
                                            </div>
                                            <span class="risk-lbl">{{ $pct }}% delay risk</span>
                                        </div>
                                    @else
                                        <span class="no-data-lbl">No data</span>
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

    @if (!$isReadOnly)
        <div class="modal fade" id="createTaskModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-2">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title" style="font-family:var(--display);font-weight:800;">New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('business.tasks.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="auto-assign-box" id="autoAssignBox">
                                <i class="fas fa-magic me-2"></i>
                                <span id="autoAssignText"></span>
                                <button type="button" class="btn btn-sm ms-2"
                                    style="background:#34D399;color:#0A0D14;border-radius:6px;font-size:.72rem;padding:.2rem .6rem;font-weight:700;"
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
                                        style="background:var(--accent-dim);color:var(--accent);border-radius:6px;font-size:.72rem;padding:.2rem .7rem;border:none;"
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

        <div class="modal fade" id="editTaskModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-2">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title" style="font-family:var(--display);font-weight:800;">Edit Task</h5>
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
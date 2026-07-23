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
            color: var(--accent) !important;
        }

        .pt-sub {
            color: var(--muted);
            font-size: .82rem;
            margin-top: 2px;
        }

        .kpi-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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
            font-size: 1.6rem;
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

        .task-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.1rem 1.25rem;
            margin-bottom: .75rem;
            transition: .2s;
            box-shadow: var(--shadow);
        }

        .task-card:hover {
            transform: translateY(-2px);
            border-color: var(--border-strong);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .4);
        }

        .task-name {
            font-weight: 700;
            font-size: .9rem;
            color: var(--text);
        }

        .task-desc {
            font-size: .8rem;
            color: var(--muted);
            margin-bottom: .6rem;
        }

        .task-meta {
            font-size: .75rem;
            color: var(--muted);
        }

        .task-meta strong {
            color: var(--text);
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

        .alert-success {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid rgba(52, 211, 153, 0.25);
        }

        .alert-overdue {
            background: var(--danger-bg) !important;
            border: 1px solid rgba(248, 113, 113, 0.3) !important;
            border-radius: 14px;
            padding: .85rem 1.1rem;
            font-size: .82rem;
            color: var(--text);
        }

        .alert-overdue i {
            color: var(--danger);
        }

        .alert-overdue strong {
            color: var(--danger);
        }

        .form-select,
        .form-select-sm,
        select {
            border-radius: 8px;
            font-size: .78rem;
            border: 1px solid var(--border-strong) !important;
            background: var(--surface-2) !important;
            color: var(--text) !important;
        }

        .form-select:focus,
        select:focus {
            background: var(--surface-2) !important;
            color: var(--text) !important;
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px var(--accent-dim);
        }

        .form-select option,
        select option {
            background: var(--surface-2);
            color: var(--text);
        }
    </style>

    <div class="pt-page">
        <div class="mb-4">
            <div class="pt-title"><i class="fas fa-tasks me-2"></i>My Tasks</div>
            <div class="pt-sub">Your assigned tasks and their current status</div>
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
        </div>

        @if ($overdueTasks > 0)
            <div class="alert alert-overdue d-flex align-items-center gap-2 mb-4">
                <i class="fas fa-exclamation-triangle"></i>
                <span>You have <strong>{{ $overdueTasks }} overdue task{{ $overdueTasks > 1 ? 's' : '' }}</strong>. Please update
                    your progress.</span>
            </div>
        @endif

        @forelse($tasks as $task)
            <div class="task-card">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <span class="task-name">{{ $task->title }}</span>
                            <span class="badge-pri {{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                            <span
                                class="badge-status {{ $task->status }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                        </div>
                        <div class="task-desc">{{ $task->description }}</div>
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <span class="task-meta"><i class="far fa-calendar me-1"></i>Due:
                                <strong
                                    style="color:{{ \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status != 'completed' ? '#F87171' : 'var(--text)' }}">{{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}</strong></span>
                            @if ($task->prediction)
                                @php $pct = round($task->prediction->delay_probability * 100); @endphp
                                <span class="task-meta">AI Risk:
                                    <span
                                        style="font-weight:700;color:{{ $pct >= 70 ? '#F87171' : ($pct >= 40 ? '#FBBF24' : '#34D399') }}">{{ $pct }}%</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('business.tasks.updateStatus', $task->id) }}"
                        class="d-flex align-items-center gap-2">
                        @csrf
                        <select name="status" class="form-select form-select-sm" style="width:140px;"
                            onchange="this.form.submit()">
                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress
                            </option>
                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </form>
                </div>
            </div>
        @empty
            <div class="card-pt text-center py-5">
                <i class="fas fa-inbox fa-2x mb-2" style="color:var(--muted);"></i>
                <div style="color:var(--muted);font-size:.85rem;">No tasks assigned to you yet.</div>
            </div>
        @endforelse
    </div>
@endsection
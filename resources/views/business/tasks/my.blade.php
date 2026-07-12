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
            grid-template-columns: repeat(4, 1fr);
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
            box-shadow: 0 8px 20px rgba(0, 0, 0, .07);
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

        .risk-bar-bg {
            background: #e2e8f0;
            border-radius: 999px;
            height: 5px;
            width: 60px;
        }

        .form-select-sm {
            border-radius: 8px;
            font-size: .78rem;
            border: 1px solid #e2e8f0;
        }
    </style>

    <div class="pt-page">
        <div class="mb-4">
            <div class="pt-title"><i class="fas fa-tasks me-2 text-primary"></i>My Tasks</div>
            <div class="pt-sub">Your assigned tasks and their current status</div>
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
        </div>

        @if ($overdueTasks > 0)
            <div class="alert d-flex align-items-center gap-2 mb-4"
                style="background:#fee2e2;border:1px solid #fca5a5;border-radius:14px;padding:.85rem 1.1rem;font-size:.82rem;">
                <i class="fas fa-exclamation-triangle text-danger"></i>
                <span>You have <strong>{{ $overdueTasks }} overdue task{{ $overdueTasks > 1 ? 's' : '' }}</strong>. Please update
                    your progress.</span>
            </div>
        @endif

        {{-- Task Cards --}}
        @forelse($tasks as $task)
            <div class="task-card">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <span style="font-weight:700;font-size:.9rem;color:#0f172a;">{{ $task->title }}</span>
                            <span class="badge-pri {{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                            <span
                                class="badge-status {{ $task->status }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                        </div>
                        <div style="font-size:.8rem;color:var(--muted);margin-bottom:.6rem;">{{ $task->description }}</div>
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <span style="font-size:.75rem;color:var(--muted);"><i class="far fa-calendar me-1"></i>Due:
                                <strong
                                    style="color:{{ \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status != 'completed' ? '#ef4444' : '#0f172a' }}">{{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}</strong></span>
                            @if ($task->prediction)
                                @php $pct = round($task->prediction->delay_probability * 100); @endphp
                                <span style="font-size:.75rem;color:var(--muted);">AI Risk:
                                    <span
                                        style="font-weight:700;color:{{ $pct >= 70 ? '#ef4444' : ($pct >= 40 ? '#d97706' : '#16a34a') }}">{{ $pct }}%</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Status update --}}
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

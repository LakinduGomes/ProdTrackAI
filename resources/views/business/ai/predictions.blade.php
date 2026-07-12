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

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: .95rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1rem;
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

        .badge-out {
            font-size: .65rem;
            font-weight: 700;
            padding: .25rem .65rem;
            border-radius: 8px;
        }

        .badge-out.delayed {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-out.on_time {
            background: #dcfce7;
            color: #16a34a;
        }
    </style>

    <div class="pt-page">
        <div class="mb-4">
            <div class="pt-title"><i class="fas fa-robot me-2 text-danger"></i>Risk Predictions</div>
            <div class="pt-sub">AI-powered delay probability for all tasks</div>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-3 mb-3" style="font-size:.83rem;">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger rounded-3 mb-3" style="font-size:.83rem;">{{ session('error') }}</div>
        @endif

        <div class="kpi-row">
            <div class="kpi">
                <div class="kpi-val">{{ $predictions->count() }}</div>
                <div class="kpi-lbl">Predicted</div>
            </div>
            <div class="kpi" style="border-left:3px solid #ef4444">
                <div class="kpi-val" style="color:#ef4444">{{ $highRisk }}</div>
                <div class="kpi-lbl">High Risk ≥70%</div>
            </div>
            <div class="kpi" style="border-left:3px solid #f59e0b">
                <div class="kpi-val" style="color:#f59e0b">{{ $mediumRisk }}</div>
                <div class="kpi-lbl">Medium 40-69%</div>
            </div>
            <div class="kpi" style="border-left:3px solid #10b981">
                <div class="kpi-val" style="color:#10b981">{{ $lowRisk }}</div>
                <div class="kpi-lbl">Low &lt;40%</div>
            </div>
            <div class="kpi">
                <div class="kpi-val">{{ $delayed }}</div>
                <div class="kpi-lbl">Predicted Delayed</div>
            </div>
        </div>

        <div class="card-pt">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div class="card-title m-0">All Task Predictions</div>
                @if (!$isReadOnly)
                    <div class="d-flex gap-2 align-items-center flex-wrap">
                        {{-- Single task prediction --}}
                        <form method="POST" action="{{ route('business.ai.runPrediction') }}" class="d-flex gap-2 align-items-center">
                            @csrf
                            <select name="task_id" class="form-select form-select-sm"
                                style="width:200px;border-radius:8px;font-size:.8rem;border:1px solid #e2e8f0;" required>
                                <option value="">Select task to predict</option>
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm"
                                style="background:#6366f1;color:#fff;border:none;border-radius:8px;padding:.4rem .9rem;font-size:.8rem;font-weight:600;">
                                <i class="fas fa-sync me-1"></i>Run Prediction
                            </button>
                        </form>

                        {{-- Run all tasks --}}
                        <form method="POST" action="{{ route('business.ai.runAll') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm"
                                style="background:#10b981;color:#fff;border:none;border-radius:8px;padding:.4rem .9rem;font-size:.8rem;font-weight:600;">
                                <i class="fas fa-bolt me-1"></i>Run All
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            <div style="overflow-x:auto;">
                <table class="pt-table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Assigned To</th>
                            <th>Deadline</th>
                            <th>Priority</th>
                            <th>Delay Probability</th>
                            <th>Outcome</th>
                            <th>Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($predictions as $p)
                            @php $pct = round($p->delay_probability * 100); @endphp
                            <tr>
                                <td style="font-weight:600;">{{ $p->task->title ?? 'N/A' }}</td>
                                <td>{{ $p->task->assignedUser->first_name ?? '—' }}
                                    {{ $p->task->assignedUser->last_name ?? '' }}</td>
                                <td>{{ $p->task->deadline ? \Carbon\Carbon::parse($p->task->deadline)->format('M d, Y') : '—' }}
                                </td>
                                <td>
                                    @if ($p->task)
                                        <span
                                            style="font-size:.65rem;font-weight:700;padding:.2rem .55rem;border-radius:6px;background:{{ $p->task->priority == 'high' ? '#fee2e2' : ($p->task->priority == 'medium' ? '#fef3c7' : '#dcfce7') }};color:{{ $p->task->priority == 'high' ? '#dc2626' : ($p->task->priority == 'medium' ? '#d97706' : '#16a34a') }};">{{ ucfirst($p->task->priority) }}</span>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:60px;background:#e2e8f0;border-radius:999px;height:6px;">
                                            <div
                                                style="width:{{ $pct }}%;height:100%;border-radius:999px;background:{{ $pct >= 70 ? '#ef4444' : ($pct >= 40 ? '#f59e0b' : '#10b981') }};">
                                            </div>
                                        </div>
                                        <span
                                            style="font-size:.78rem;font-weight:700;color:{{ $pct >= 70 ? '#ef4444' : ($pct >= 40 ? '#d97706' : '#16a34a') }};">{{ $pct }}%</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge-out {{ $p->predicted_outcome }}">{{ ucfirst(str_replace('_', ' ', $p->predicted_outcome)) }}</span>
                                </td>
                                <td style="color:var(--muted);font-size:.75rem;">{{ $p->updated_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4" style="color:var(--muted);">No predictions
                                    available. Run your ML model first.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

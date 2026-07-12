{{-- ═══════════════════════════════════════════════════════
     FILE: resources/views/business/performance/workload.blade.php
═══════════════════════════════════════════════════════ --}}
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
            margin-bottom: 1rem;
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: .95rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1rem;
        }

        .emp-card {
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1rem 1.2rem;
            margin-bottom: .75rem;
        }

        .bar-bg {
            background: #e2e8f0;
            border-radius: 999px;
            height: 8px;
            margin-top: .4rem;
        }

        .bar-fill {
            height: 100%;
            border-radius: 999px;
            transition: width .8s ease;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: .85rem;
            flex-shrink: 0;
        }
    </style>
    <div class="pt-page">
        <div class="mb-4">
            <div class="pt-title"><i class="fas fa-balance-scale me-2 text-primary"></i>Workload Distribution</div>
            <div class="pt-sub">Monitor task load across your team</div>
        </div>
        <div class="kpi-row">
            <div class="kpi">
                <div class="kpi-val">{{ $totalTasks }}</div>
                <div class="kpi-lbl">Total Tasks</div>
            </div>
            <div class="kpi">
                <div class="kpi-val">{{ $totalEmployees }}</div>
                <div class="kpi-lbl">Employees</div>
            </div>
            <div class="kpi">
                <div class="kpi-val">{{ $avgTasks }}</div>
                <div class="kpi-lbl">Avg Tasks/Person</div>
            </div>
            <div class="kpi" style="border-left:3px solid var(--danger)">
                <div class="kpi-val" style="color:var(--danger)">{{ $overloaded }}</div>
                <div class="kpi-lbl">Overloaded</div>
            </div>
        </div>
        <div class="card-pt">
            <div class="card-title"><i class="fas fa-users me-2 text-primary"></i>Employee Load</div>
            @forelse($employees as $emp)
                @php
                    $max = $employees->max('total_tasks') ?: 1;
                    $pct = round(($emp->total_tasks / $max) * 100);
                @endphp
                <div class="emp-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">{{ strtoupper(substr($emp->first_name, 0, 1)) }}</div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="font-weight:600;font-size:.85rem;">{{ $emp->first_name }}
                                    {{ $emp->last_name }}</span>
                                <div class="d-flex gap-2" style="font-size:.72rem;">
                                    <span
                                        style="background:#dcfce7;color:#16a34a;padding:.15rem .5rem;border-radius:6px;font-weight:600;">{{ $emp->completed_tasks }}
                                        done</span>
                                    <span
                                        style="background:#e0e7ff;color:#4338ca;padding:.15rem .5rem;border-radius:6px;font-weight:600;">{{ $emp->inprogress_tasks }}
                                        active</span>
                                    <span
                                        style="background:#fee2e2;color:#dc2626;padding:.15rem .5rem;border-radius:6px;font-weight:600;">{{ $emp->overdue_tasks }}
                                        overdue</span>
                                    <span
                                        style="background:#f1f5f9;color:var(--muted);padding:.15rem .5rem;border-radius:6px;font-weight:600;">{{ $emp->total_tasks }}
                                        total</span>
                                </div>
                            </div>
                            <div class="bar-bg">
                                <div class="bar-fill"
                                    style="width:{{ $pct }}%;background:{{ $emp->overdue_tasks > 0 ? '#ef4444' : '#6366f1' }};">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center py-4" style="color:var(--muted);">No employees found.</p>
            @endforelse
        </div>
    </div>
@endsection

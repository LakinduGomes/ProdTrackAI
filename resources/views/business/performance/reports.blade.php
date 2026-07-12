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

        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .rate-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            font-family: 'Syne', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
        }

        .chart-box {
            position: relative;
            width: 100%;
            height: 260px;
        }

        .chart-box.chart-box-sm {
            height: 220px;
        }
    </style>

    <div class="pt-page">
        <div class="mb-4">
            <div class="pt-title"><i class="fas fa-chart-bar me-2 text-primary"></i>Productivity Reports</div>
            <div class="pt-sub">30-day summary of task performance across the team</div>
        </div>

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

        <div class="charts-grid">
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-chart-line me-2 text-primary"></i>Completion Trend (30 Days)</div>
                <div class="chart-box">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Performance Rates</div>
                <div class="d-flex flex-column gap-3 align-items-center pt-2">
                    <div class="text-center">
                        <div class="rate-circle mb-1" style="background:#dcfce7;color:#16a34a;border:4px solid #10b981;">
                            {{ $completionRate }}%</div>
                        <div style="font-size:.75rem;font-weight:600;color:var(--muted);">Completion Rate</div>
                    </div>
                    <div class="text-center">
                        <div class="rate-circle mb-1" style="background:#fee2e2;color:#dc2626;border:4px solid #ef4444;">
                            {{ $overdueRate }}%</div>
                        <div style="font-size:.75rem;font-weight:600;color:var(--muted);">Overdue Rate</div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-flag me-2 text-primary"></i>Tasks by Priority</div>
                <div class="chart-box chart-box-sm">
                    <canvas id="priorityChart"></canvas>
                </div>
            </div>
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-user-check me-2 text-primary"></i>Tasks per Employee</div>
                @foreach ($byEmployee as $emp)
                    @php $max = $byEmployee->max('tasks_count') ?: 1; @endphp
                    <div class="mb-2">
                        <div class="d-flex justify-content-between" style="font-size:.78rem;margin-bottom:3px;">
                            <span style="font-weight:600;">{{ $emp->first_name }}</span>
                            <span style="color:var(--muted);">{{ $emp->tasks_count }}</span>
                        </div>
                        <div style="background:#e2e8f0;border-radius:999px;height:6px;">
                            <div
                                style="width:{{ round(($emp->tasks_count / $max) * 100) }}%;height:100%;border-radius:999px;background:var(--accent);">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'DM Sans', sans-serif";
        Chart.defaults.color = '#64748b';

        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($trendLabels) !!},
                datasets: [{
                    data: {!! json_encode($trendCounts) !!},
                    fill: true,
                    backgroundColor: 'rgba(99,102,241,0.06)',
                    borderColor: '#6366f1',
                    borderWidth: 2,
                    pointRadius: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 9
                            },
                            maxTicksLimit: 10
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('priorityChart'), {
            type: 'doughnut',
            data: {
                labels: ['High', 'Medium', 'Low'],
                datasets: [{
                    data: [{{ $byPriority['high'] ?? 0 }}, {{ $byPriority['medium'] ?? 0 }},
                        {{ $byPriority['low'] ?? 0 }}
                    ],
                    backgroundColor: ['#ef4444', '#f59e0b', '#10b981'],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 12,
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
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

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: .78rem;
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
            <div class="pt-title"><i class="fas fa-chart-area me-2 text-primary"></i>Analytics Overview</div>
            <div class="pt-sub">Weekly trends, status distribution and top performers</div>
        </div>

        <div class="charts-grid">
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-chart-bar me-2 text-primary"></i>Weekly Task Completions (Last 8
                    Weeks)</div>
                <div class="chart-box">
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-chart-pie me-2 text-primary"></i>Status Distribution</div>
                <div class="chart-box">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-flag me-2 text-primary"></i>Priority Breakdown</div>
                <div class="chart-box chart-box-sm">
                    <canvas id="priorityChart"></canvas>
                </div>
            </div>
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-trophy me-2" style="color:#f59e0b;"></i>Top Performers</div>
                @foreach ($topPerformers as $i => $emp)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div
                            style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:{{ $i == 0 ? '#f59e0b' : ($i == 1 ? '#94a3b8' : '#cd7c2f') }};width:20px;text-align:center;">
                            {{ $i + 1 }}</div>
                        <div class="avatar">{{ strtoupper(substr($emp->first_name, 0, 1)) }}</div>
                        <div class="flex-grow-1">
                            <div style="font-weight:600;font-size:.83rem;">{{ $emp->first_name }} {{ $emp->last_name }}
                            </div>
                            <div style="font-size:.72rem;color:var(--muted);">{{ $emp->completed_tasks }} tasks completed
                            </div>
                        </div>
                        <span
                            style="background:#dcfce7;color:#16a34a;font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:8px;">{{ $emp->completed_tasks }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'DM Sans', sans-serif";
        Chart.defaults.color = '#64748b';

        new Chart(document.getElementById('weeklyChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($weeklyLabels) !!},
                datasets: [{
                    label: 'Completed',
                    data: {!! json_encode($weeklyData) !!},
                    backgroundColor: 'rgba(99,102,241,0.15)',
                    borderColor: '#6366f1',
                    borderWidth: 2,
                    borderRadius: 6
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
                            color: 'rgba(0,0,0,0.03)'
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
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: {
                labels: ['Completed', 'In Progress', 'Overdue', 'Pending'],
                datasets: [{
                    data: [{{ $statusCounts['completed'] }}, {{ $statusCounts['in_progress'] }},
                        {{ $statusCounts['overdue'] }}, {{ $statusCounts['pending'] }}
                    ],
                    backgroundColor: ['#10b981', '#6366f1', '#ef4444', '#f59e0b'],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 10,
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('priorityChart'), {
            type: 'bar',
            data: {
                labels: ['High', 'Medium', 'Low'],
                datasets: [{
                    data: [{{ $priorityCounts['high'] ?? 0 }}, {{ $priorityCounts['medium'] ?? 0 }},
                        {{ $priorityCounts['low'] ?? 0 }}
                    ],
                    backgroundColor: ['#ef4444', '#f59e0b', '#10b981'],
                    borderRadius: 8,
                    borderSkipped: false
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
                            color: 'rgba(0,0,0,0.03)'
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
                        }
                    }
                }
            }
        });
    </script>
@endsection
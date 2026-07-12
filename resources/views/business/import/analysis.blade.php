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

        .chart-box {
            position: relative;
            width: 100%;
            height: 260px;
        }

        .chart-box.chart-box-sm {
            height: 220px;
        }

        table.risk-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .8rem;
        }

        table.risk-table th {
            text-align: left;
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--muted);
            font-weight: 700;
            padding: .55rem .5rem;
            border-bottom: 1px solid var(--border);
        }

        table.risk-table td {
            padding: .6rem .5rem;
            border-bottom: 1px solid var(--border);
        }

        .risk-pill {
            font-size: .68rem;
            font-weight: 700;
            padding: .22rem .55rem;
            border-radius: 8px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .82rem;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            margin-bottom: 1rem;
        }

        .back-link:hover {
            color: #0f172a;
        }

        .convert-btn {
            background: #eef2ff;
            color: #4338ca;
            border: none;
            font-size: .75rem;
            font-weight: 700;
            padding: .35rem .75rem;
            border-radius: 8px;
            cursor: pointer;
        }

        .convert-btn:hover {
            background: #e0e7ff;
        }
    </style>

    <div class="pt-page">
        <a href="{{ route('import.index') }}" class="back-link"><i class="fas fa-arrow-left"></i>Back to Imports</a>

        <div class="mb-4">
            <div class="pt-title"><i class="fas fa-chart-line me-2 text-primary"></i>{{ $session->original_filename }}</div>
            <div class="pt-sub">Imported {{ $session->created_at->format('d M Y, h:i A') }} &nbsp;•&nbsp;
                {{ $session->processed_rows }} tasks processed, {{ $session->failed_rows }} rows skipped</div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="border-radius:12px;font-size:.85rem;">{{ session('success') }}</div>
        @endif

        <div class="kpi-row">
            <div class="kpi" style="border-left:3px solid #6366f1">
                <div class="kpi-val" style="color:#6366f1">{{ $totalTasks }}</div>
                <div class="kpi-lbl">Total Tasks</div>
            </div>
            <div class="kpi" style="border-left:3px solid #f59e0b">
                <div class="kpi-val" style="color:#f59e0b">{{ $avgDelayProbability }}%</div>
                <div class="kpi-lbl">Avg Delay Probability</div>
            </div>
            <div class="kpi" style="border-left:3px solid #10b981">
                <div class="kpi-val" style="color:#10b981">{{ $onTimeCount }}</div>
                <div class="kpi-lbl">Predicted On-Time</div>
            </div>
            <div class="kpi" style="border-left:3px solid #ef4444">
                <div class="kpi-val" style="color:#ef4444">{{ $delayedCount }}</div>
                <div class="kpi-lbl">Predicted Delayed</div>
            </div>
        </div>

        <div class="charts-grid">
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-chart-bar me-2 text-primary"></i>Delay Risk Distribution</div>
                <div class="chart-box">
                    <canvas id="bucketChart"></canvas>
                </div>
            </div>
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-flag me-2 text-primary"></i>Priority Breakdown</div>
                <div class="chart-box">
                    <canvas id="priorityChart"></canvas>
                </div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:3fr 2fr;gap:1rem;">
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-exclamation-triangle me-2 text-primary"></i>Highest Risk Tasks
                </div>
                @if ($riskiestTasks->isEmpty())
                    <div style="font-size:.85rem;color:var(--muted);padding:.5rem 0;">No predictions available yet.
                        Check that the Flask ML API is reachable and re-import if needed.</div>
                @else
                    <table class="risk-table">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Assigned To</th>
                                <th>Priority</th>
                                <th>Risk</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riskiestTasks as $t)
                                @php
                                    $bucket = $t->delay_risk_bucket;
                                    $colors = [
                                        'Low' => ['#dcfce7', '#16a34a'],
                                        'Moderate' => ['#e0e7ff', '#4338ca'],
                                        'Elevated' => ['#fef3c7', '#b45309'],
                                        'High' => ['#ffedd5', '#c2410c'],
                                        'Critical' => ['#fee2e2', '#dc2626'],
                                    ];
                                    [$bg, $fg] = $colors[$bucket] ?? ['#f1f5f9', '#64748b'];
                                @endphp
                                <tr>
                                    <td style="font-weight:600;">{{ $t->task_name }}</td>
                                    <td style="color:var(--muted);">{{ $t->assigned_to ?? '—' }}</td>
                                    <td style="text-transform:capitalize;">{{ $t->priority }}</td>
                                    <td>
                                        <span class="risk-pill" style="background:{{ $bg }};color:{{ $fg }};">
                                            {{ $t->delay_probability }}% · {{ $bucket }}
                                        </span>
                                    </td>
                                    <td style="text-align:right;">
                                        @if ($t->converted_task_id)
                                            <span class="risk-pill" style="background:#dcfce7;color:#16a34a;">
                                                <i class="fas fa-check me-1"></i>On Task Board
                                            </span>
                                        @else
                                            <button type="button" class="convert-btn" data-bs-toggle="modal"
                                                data-bs-target="#convertModal-{{ $t->id }}">
                                                <i class="fas fa-arrow-right me-1"></i>Convert
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                @if (!$t->converted_task_id)
                                    <div class="modal fade" id="convertModal-{{ $t->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="border-radius:16px;border:none;">
                                                <form action="{{ route('import.convert', $t->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header" style="border-bottom:1px solid var(--border);">
                                                        <h5 class="modal-title" style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;">
                                                            Add to Task Board</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div style="font-size:.85rem;font-weight:600;margin-bottom:1rem;">
                                                            {{ $t->task_name }}</div>

                                                        <label style="font-size:.75rem;font-weight:700;color:var(--muted);text-transform:uppercase;">Assign To</label>
                                                        <select name="assigned_user_id" class="form-select mb-3" required
                                                            style="border-radius:10px;">
                                                            <option value="">Select a user…</option>
                                                            @foreach ($users as $u)
                                                                <option value="{{ $u->id }}"
                                                                    {{ $t->suggested_user_id == $u->id ? 'selected' : '' }}>
                                                                    {{ $u->first_name }} {{ $u->last_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($t->suggested_user_id)
                                                            <div style="font-size:.72rem;color:var(--muted);margin-top:-.6rem;margin-bottom:1rem;">
                                                                <i class="fas fa-magic me-1"></i>Pre-selected based on
                                                                "{{ $t->assigned_to }}" in the file — double check before saving.
                                                            </div>
                                                        @endif

                                                        <label style="font-size:.75rem;font-weight:700;color:var(--muted);text-transform:uppercase;">Priority</label>
                                                        <select name="priority" class="form-select mb-3" style="border-radius:10px;">
                                                            <option value="low" {{ $t->priority == 'low' ? 'selected' : '' }}>Low</option>
                                                            <option value="medium" {{ $t->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                                            <option value="high" {{ $t->priority == 'high' ? 'selected' : '' }}>High</option>
                                                        </select>

                                                        <label style="font-size:.75rem;font-weight:700;color:var(--muted);text-transform:uppercase;">Deadline</label>
                                                        <input type="date" name="deadline" class="form-control"
                                                            value="{{ optional($t->due_date)->format('Y-m-d') }}"
                                                            style="border-radius:10px;">
                                                    </div>
                                                    <div class="modal-footer" style="border-top:1px solid var(--border);">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                                                            style="border-radius:10px;font-size:.82rem;">Cancel</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            style="background:#6366f1;border:none;border-radius:10px;font-size:.82rem;font-weight:600;">
                                                            <i class="fas fa-check me-1"></i>Add Task
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-sliders-h me-2 text-primary"></i>Feature Importance</div>
                @foreach ($featureImportance as $feature => $importance)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1" style="font-size:.8rem;">
                            <span style="font-weight:600;">{{ $feature }}</span>
                            <span style="color:var(--muted);">{{ $importance }}%</span>
                        </div>
                        <div style="background:#e2e8f0;border-radius:999px;height:7px;">
                            <div
                                style="width:{{ $importance }}%;height:100%;border-radius:999px;background:linear-gradient(90deg,#4f46e5,#6366f1);">
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

        new Chart(document.getElementById('bucketChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($buckets)) !!},
                datasets: [{
                    label: 'Tasks',
                    data: {!! json_encode(array_values($buckets)) !!},
                    backgroundColor: ['#10b981', '#6366f1', '#f59e0b', '#f97316', '#ef4444'],
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
                        },
                        ticks: {
                            precision: 0
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

        new Chart(document.getElementById('priorityChart'), {
            type: 'pie',
            data: {
                labels: ['High', 'Medium', 'Low'],
                datasets: [{
                    data: [{{ $priorityCounts['high'] }}, {{ $priorityCounts['medium'] }},
                        {{ $priorityCounts['low'] }}
                    ],
                    backgroundColor: ['#ef4444', '#f59e0b', '#10b981'],
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
    </script>
@endsection
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
            grid-template-columns: repeat(3, 1fr);
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

        .model-info {
            background: linear-gradient(135deg, rgba(99, 102, 241, .04), rgba(99, 102, 241, .08));
            border: 1px solid rgba(99, 102, 241, .15);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
        }

        .api-status {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .75rem;
            font-weight: 600;
            padding: .3rem .8rem;
            border-radius: 8px;
        }

        .api-status.online {
            background: #dcfce7;
            color: #16a34a;
        }

        .api-status.offline {
            background: #fee2e2;
            color: #dc2626;
        }

        .chart-box {
            position: relative;
            width: 100%;
            height: 260px;
        }
    </style>

    <div class="pt-page">
        <div class="mb-4">
            <div class="pt-title"><i class="fas fa-brain me-2" style="color:#6366f1"></i>Delay Probability Model</div>
            <div class="pt-sub">Random Forest & Decision Tree ML model performance overview</div>
        </div>

        <div class="kpi-row">
            <div class="kpi" style="border-left:3px solid #6366f1">
                <div class="kpi-val" style="color:#6366f1">{{ $totalTasks }}</div>
                <div class="kpi-lbl">Total Tasks</div>
            </div>
            <div class="kpi" style="border-left:3px solid #10b981">
                <div class="kpi-val" style="color:#10b981">{{ $predictedTasks }}</div>
                <div class="kpi-lbl">Predictions Made</div>
            </div>
            <div class="kpi" style="border-left:3px solid #f59e0b">
                <div class="kpi-val" style="color:#f59e0b">{{ $accuracy }}%</div>
                <div class="kpi-lbl">On-Time Accuracy</div>
            </div>
        </div>

        <div class="model-info d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <div style="font-weight:700;font-size:.9rem;color:#0f172a;">ML Pipeline Status</div>
                <div style="font-size:.78rem;color:var(--muted);margin-top:2px;">Models: Random Forest · Decision Tree
                    &nbsp;|&nbsp; Integration: Flask REST API → Laravel</div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <span class="api-status offline"><span
                        style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>Flask
                    API</span>
                <span class="api-status online"><span
                        style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>Laravel
                    Connected</span>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="card-pt">
                <div class="card-title"><i class="fas fa-chart-bar me-2 text-primary"></i>Delay Probability Distribution
                </div>
                <div class="chart-box">
                    <canvas id="bucketChart"></canvas>
                </div>
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
                                style="width:{{ $importance }}%;height:100%;border-radius:999px;background:linear-gradient(90deg,#4f46e5,#6366f1);transition:.8s;">
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="mt-3 pt-3" style="border-top:1px solid var(--border);font-size:.72rem;color:var(--muted);">
                    <i class="fas fa-info-circle me-1"></i>Feature importance is based on static model weights. Connect
                    Flask API to get live values.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'DM Sans', sans-serif";
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
    </script>
@endsection
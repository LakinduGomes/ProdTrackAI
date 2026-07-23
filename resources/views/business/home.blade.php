@extends('layouts.business')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{
  --ink:        #E7E9EE;
  --ink-soft:   #C3C8D4;
  --canvas:     #0A0D14;
  --panel:      #12161F;
  --panel-2:    #171C27;
  --hairline:   rgba(255,255,255,.07);
  --hairline-strong: rgba(255,255,255,.14);
  --track:      #1D2330;

  --brass:      #818CF8;
  --brass-strong: #6366F1;
  --brass-soft: rgba(129,140,248,.14);
  --brass-line: rgba(129,140,248,.25);

  --steel:      #9AA1B0;

  --green:      #34D399;
  --green-soft: rgba(52,211,153,.14);
  --red:        #F87171;
  --red-soft:   rgba(248,113,113,.14);
  --amber:      #FBBF24;
  --amber-soft: rgba(251,191,36,.14);
  --amber-line: rgba(251,191,36,.25);

  --muted:      #8891A5;
  --muted-2:    #6b7280;

  --radius:     16px;
  --radius-sm:  11px;
  --shadow-sm:  0 1px 2px rgba(0,0,0,.3);
  --shadow:     0 6px 16px -6px rgba(0,0,0,.4), 0 2px 5px -2px rgba(0,0,0,.3);
  --shadow-lg:  0 20px 40px -14px rgba(0,0,0,.55);
}

html {
  background: var(--canvas) !important;
  color-scheme: dark;
}

body,
.content-wrapper {
  background: var(--canvas) !important;
}

::selection {
  background: var(--brass-soft);
  color: var(--ink);
}

.pt-wrapper { color: var(--ink); font-family:'Inter',sans-serif; -webkit-font-smoothing:antialiased; padding: 0 0 2rem; max-width: 1600px; margin: 0 auto; }
.pt-inner { padding: 0; }

.mono { font-family:'Inter',sans-serif; font-weight:600; }
.disp { font-family:'Inter',sans-serif; }

.pt-intro { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:.75rem; margin-bottom:1.5rem; padding-bottom:1.15rem; border-bottom:1px solid var(--hairline); }
.pt-intro h1 { font-family:'Inter',sans-serif; font-size:1.3rem; font-weight:800; color:var(--ink); margin:0; letter-spacing:-.01em; }
.pt-intro p { color:var(--muted); font-size:.82rem; margin:2px 0 0; font-weight:500; }
.pt-intro p strong { color:var(--ink); font-weight:600; }

.role-pill { font-size:.64rem; font-weight:700; padding:.3rem .75rem; border-radius:999px; letter-spacing:.06em; text-transform:uppercase; border:1px solid; }
.pill-admin    { background:var(--brass-soft); color:var(--brass); border-color:var(--brass-line); }
.pill-manager  { background:var(--green-soft); color:var(--green); border-color:rgba(52,211,153,.3); }
.pill-employee { background:rgba(154,161,176,.12); color:var(--steel); border-color:rgba(154,161,176,.3); }
.pill-readonly { background:var(--track); color:var(--muted); border-color:var(--hairline); }

.notif-btn { background:var(--panel); border:1px solid var(--hairline); border-radius:8px; padding:.48rem .85rem; color:var(--ink); position:relative; cursor:pointer; transition:.2s ease; box-shadow:var(--shadow-sm); }
.notif-btn:hover { background:var(--panel-2); border-color:var(--hairline-strong); }
.notif-badge { position:absolute; top:-5px; right:-5px; background:var(--red); color:#fff; font-size:9px; border-radius:50%; width:16px; height:16px; display:flex; align-items:center; justify-content:center; font-weight:700; border:2px solid var(--panel); }
.dropdown { position:relative !important; }
.notif-dropdown.dropdown-menu {
  background:var(--panel) !important;
  border:1px solid var(--hairline-strong) !important;
  border-radius:16px !important;
  min-width:340px !important;
  box-shadow:var(--shadow-lg) !important;
  padding:.4rem !important;
  margin-top:.5rem !important;
  color:var(--ink) !important;
  position:absolute !important;
  inset:auto 0 auto auto !important;
  top:100% !important;
  right:0 !important;
  left:auto !important;
  bottom:auto !important;
  transform:none !important;
  z-index:1050 !important;
}
.notif-dropdown .dropdown-header { color:var(--ink); font-weight:700; font-size:.85rem; padding:.75rem .8rem; border-bottom:1px solid var(--hairline); }
.notif-item { padding:.75rem .8rem; border-radius:var(--radius-sm); margin-bottom:2px; transition:.15s ease; }
.notif-item:hover { background:var(--panel-2); }
.notif-item.unread { background:var(--brass-soft); border-left:2px solid var(--brass); }

.gauge { position:relative; width:52px; height:52px; border-radius:50%; flex-shrink:0;
  background: conic-gradient(var(--ring, var(--brass)) calc(var(--pct,0) * 3.6deg), var(--track) 0deg);
  animation: gaugeIn .7s cubic-bezier(.16,1,.3,1) both;
}
.gauge::before { content:''; position:absolute; inset:6px; border-radius:50%; background:var(--panel); }
.gauge span { position:relative; z-index:1; width:100%; height:100%; display:flex; align-items:center; justify-content:center;
  font-family:'Inter',sans-serif; font-weight:700; font-size:.62rem; color:var(--ink); }
@keyframes gaugeIn { from{ opacity:0; transform:scale(.7);} to{ opacity:1; transform:scale(1);} }

.readonly-notice { background:var(--amber-soft); border:1px solid var(--amber-line); border-radius:var(--radius-sm); padding:.65rem 1rem; font-size:.78rem; color:var(--amber); font-weight:500; }
.overdue-alert { background:var(--red-soft); border:1px solid rgba(248,113,113,.25); border-radius:var(--radius-sm); padding:1rem 1.25rem; }

.kpi-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; }
@media(max-width:900px){ .kpi-grid{grid-template-columns:repeat(2,1fr);} }
.kpi-card { background:var(--panel); border:1px solid var(--hairline); border-radius:var(--radius); padding:1.15rem 1.25rem; display:flex; align-items:center; justify-content:space-between; gap:.75rem; box-shadow:var(--shadow-sm); transition:.25s ease; animation:fadeUp .5s ease both; }
.kpi-card:hover { box-shadow:var(--shadow); transform:translateY(-2px); border-color:var(--hairline-strong); }
.kpi-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:.85rem; margin-bottom:.6rem; background:var(--track); color:var(--muted); }
.kpi-value { font-family:'Inter',sans-serif; font-size:1.55rem; font-weight:800; line-height:1; margin-bottom:.3rem; color:var(--ink); letter-spacing:-.02em; }
.kpi-card.green .kpi-value { color:var(--green); }
.kpi-card.red   .kpi-value { color:var(--red); }
.kpi-label { font-size:.68rem; color:var(--muted); font-weight:600; text-transform:uppercase; letter-spacing:.05em; }

.risk-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; }
.risk-card { background:var(--panel); border:1px solid var(--hairline); border-radius:var(--radius-sm); padding:.9rem 1.1rem; display:flex; align-items:center; justify-content:space-between; gap:.75rem; box-shadow:var(--shadow-sm); animation:fadeUp .55s ease both; }
.risk-label { font-size:.68rem; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.04em; margin-bottom:.15rem; }
.risk-val { font-family:'Inter',sans-serif; font-size:1.25rem; font-weight:800; letter-spacing:-.02em; }

.pt-section { margin-top:1.5rem; }

.charts-row { display:grid; grid-template-columns:1.5fr 1fr; gap:1rem; align-items:start; }
@media(max-width:900px){ .charts-row{grid-template-columns:1fr;} }
.chart-card { background:var(--panel); border:1px solid var(--hairline); border-radius:var(--radius); padding:1.25rem; box-shadow:var(--shadow-sm); animation:fadeUp .55s ease both; }
.chart-card.blueprint {
  background-image: radial-gradient(circle, rgba(255,255,255,.05) 1px, transparent 1px);
  background-size: 16px 16px;
  background-position: 0 0;
  background-color: var(--panel);
}
.chart-card h5 { font-family:'Inter',sans-serif; font-size:.88rem; font-weight:700; color:var(--ink); margin-bottom:1rem; display:flex; align-items:center; gap:.55rem; letter-spacing:-.01em; }
.chart-card h5 .icon-badge { width:26px; height:26px; border-radius:7px; background:rgba(154,161,176,.12); color:var(--steel); display:inline-flex; align-items:center; justify-content:center; font-size:.72rem; }
.chart-canvas-wrap { position:relative; height:170px; width:100%; }
.chart-canvas-wrap.donut { height:190px; }
.chart-canvas-wrap canvas { position:absolute; inset:0; width:100% !important; height:100% !important; }

.pt-table { width:100%; border-collapse:separate; border-spacing:0; }
.pt-table thead th { font-size:.62rem; font-weight:700; text-transform:uppercase; color:var(--muted-2) !important; padding:0 .8rem .6rem; border-bottom:1px solid var(--hairline); letter-spacing:.05em; text-align:left; background:transparent !important; }
.pt-table tbody td { padding:.7rem .8rem; font-size:.79rem; color:var(--ink) !important; border-bottom:1px solid var(--hairline); background:transparent !important; }
.pt-table tbody tr:last-child td { border-bottom:none; }
.pt-table tbody tr:hover td { background:var(--panel-2) !important; }
.pt-table .num { font-family:'Inter',sans-serif; font-weight:600; font-size:.78rem; }
.badge-risk { font-size:.6rem; font-weight:700; padding:.3rem .65rem; border-radius:6px; letter-spacing:.02em; }
.badge-risk.high { background:var(--red-soft); color:var(--red); }
.badge-risk.low  { background:var(--green-soft); color:var(--green); }

.workload-row + .workload-row { margin-top:1rem; }
.workload-bar-bg { position:relative; background:var(--track); border-radius:999px; height:8px; overflow:hidden; }
.workload-bar-bg::after {
  content:''; position:absolute; inset:0;
  background-image: repeating-linear-gradient(90deg, transparent 0 calc(20% - 1px), rgba(0,0,0,.35) calc(20% - 1px) 20%);
  pointer-events:none;
}
.workload-bar-fill { background:var(--brass); border-radius:999px; height:100%; transition:1s cubic-bezier(.16,1,.3,1); }

.bottom-row { display:grid; grid-template-columns:1.5fr 1fr; gap:1rem; align-items:start; }
@media(max-width:900px){ .bottom-row{grid-template-columns:1fr;} }

::-webkit-scrollbar { width:8px; height:8px; }
::-webkit-scrollbar-track { background:var(--panel); }
::-webkit-scrollbar-thumb { background:var(--track); border-radius:99px; }
::-webkit-scrollbar-thumb:hover { background:var(--hairline-strong); }
* { scrollbar-color: var(--track) var(--panel); }

@keyframes fadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }

.badge.bg-light {
  background: var(--track) !important;
  color: var(--ink) !important;
  border-color: var(--hairline-strong) !important;
}

.btn-light {
  background: var(--panel-2) !important;
  color: var(--ink) !important;
  border-color: var(--hairline-strong) !important;
}

.btn-light:hover {
  background: var(--track) !important;
}

.btn-link.text-muted {
  color: var(--muted) !important;
}

.progress {
  background: var(--track) !important;
}

.dropdown-menu {
  background: var(--panel);
  border: 1px solid var(--hairline-strong);
}
</style>

<div class="pt-wrapper">

  <div class="pt-intro">
    <div>
      <h1>Dashboard</h1>
      <p>
        <strong>{{ $user->first_name }}</strong> &middot;
        @if($isAdmin) full system overview
        @elseif($isManager) manager dashboard
        @elseif($isEmployee) your personal workspace
        @else read-only overview
        @endif
      </p>
    </div>

    <div class="d-flex align-items-center gap-3 flex-wrap">
      <span class="role-pill
        @if($isAdmin) pill-admin
        @elseif($isManager) pill-manager
        @elseif($isEmployee) pill-employee
        @else pill-readonly
        @endif">
        @if($isAdmin) Admin
        @elseif($isManager) Manager
        @elseif($isEmployee) Employee
        @else Read-Only
        @endif
      </span>

      <div class="dropdown">
        <button class="notif-btn" data-bs-toggle="dropdown">
          <i class="far fa-bell"></i>
          @if($unreadCount > 0)
            <span class="notif-badge">{{ $unreadCount }}</span>
          @endif
        </button>
        <ul class="dropdown-menu notif-dropdown dropdown-menu-end">
          <li class="dropdown-header d-flex justify-content-between align-items-center">
            <span>Notifications</span>
            <div class="d-flex gap-2">
              @if($unreadCount > 0)
                <button class="btn btn-sm btn-light py-1 px-2" id="mark-all-read" style="font-size:10px;">Mark All Read</button>
              @endif
              @if($notifications->count())
                <button class="btn btn-sm btn-light py-1 px-2 text-danger" id="clear-all" style="font-size:10px;">Clear All</button>
              @endif
            </div>
          </li>
          <div id="notif-container" style="max-height:320px;overflow-y:auto;">
            @forelse($notifications as $n)
              <li>
                <div class="notif-item {{ !$n->is_read ? 'unread' : '' }}">
                  <div class="d-flex justify-content-between align-items-start">
                    <a href="{{ route('notifications.read', $n->id) }}" class="text-decoration-none flex-grow-1">
                      <div style="color:var(--ink);font-size:.8rem;">{{ $n->notification }}</div>
                      <div class="mt-1" style="font-size:.65rem;color:var(--muted-2);">{{ $n->created_at->diffForHumans() }}</div>
                    </a>
                    <button class="btn btn-link btn-sm p-0 text-muted remove-notif ms-2" data-id="{{ $n->id }}">
                      <i class="fas fa-times" style="font-size:9px;"></i>
                    </button>
                  </div>
                </div>
              </li>
            @empty
              <li class="text-center py-4 text-muted" style="font-size:.8rem;">No notifications</li>
            @endforelse
          </div>
        </ul>
      </div>
    </div>
  </div>

  <div class="pt-inner">

  @if($isReadOnly)
    <div class="readonly-notice mb-4">
      <i class="fas fa-lock me-2"></i> You are viewing in <strong>read-only mode</strong>. Contact your administrator to make changes.
    </div>
  @endif

  @if($isEmployee)

    @php $empTotal = max($totalTasks, 1); @endphp
    <div class="kpi-grid" style="grid-template-columns:repeat(3,1fr);">
      <div class="kpi-card indigo" style="animation-delay:.05s">
        <div>
          <div class="kpi-icon"><i class="fas fa-layer-group"></i></div>
          <div class="kpi-value mono">{{ $totalTasks }}</div>
          <div class="kpi-label">My Total Tasks</div>
        </div>
        <div class="gauge" style="--pct:100; --ring:var(--steel);"><span>100%</span></div>
      </div>
      <div class="kpi-card green" style="animation-delay:.1s">
        <div>
          <div class="kpi-icon"><i class="fas fa-check-double"></i></div>
          <div class="kpi-value mono">{{ $completedTasks }}</div>
          <div class="kpi-label">Completed</div>
        </div>
        @php $p = round($completedTasks / $empTotal * 100); @endphp
        <div class="gauge" style="--pct:{{ $p }}; --ring:var(--green);"><span>{{ $p }}%</span></div>
      </div>
      <div class="kpi-card amber" style="animation-delay:.15s">
        <div>
          <div class="kpi-icon"><i class="fas fa-hourglass-half"></i></div>
          <div class="kpi-value mono">{{ $inProgressTasks }}</div>
          <div class="kpi-label">In Progress</div>
        </div>
        @php $p = round($inProgressTasks / $empTotal * 100); @endphp
        <div class="gauge" style="--pct:{{ $p }}; --ring:var(--brass);"><span>{{ $p }}%</span></div>
      </div>
    </div>

    @if($overdueTasks > 0)
      <div class="overdue-alert d-flex align-items-center gap-3 pt-section">
        <i class="fas fa-exclamation-triangle" style="color:var(--red);font-size:1.1rem;"></i>
        <div>
          <strong style="color:var(--red);">{{ $overdueTasks }} overdue task{{ $overdueTasks > 1 ? 's' : '' }}</strong>
          <span style="color:var(--red);font-size:.83rem;opacity:.85;"> — check your task board and update progress.</span>
        </div>
      </div>
    @endif

    <div class="chart-card blueprint pt-section">
      <h5><span class="icon-badge"><i class="fas fa-chart-line"></i></span>My Completion Activity (Last 7 Days)</h5>
      <div class="chart-canvas-wrap"><canvas id="trendChart"></canvas></div>
    </div>

  @else

    @php $total = max($totalTasks, 1); @endphp
    <div class="kpi-grid">
      <div class="kpi-card indigo" style="animation-delay:.05s">
        <div>
          <div class="kpi-icon"><i class="fas fa-layer-group"></i></div>
          <div class="kpi-value mono">{{ $totalTasks }}</div>
          <div class="kpi-label">Total Tasks</div>
        </div>
        <div class="gauge" style="--pct:100; --ring:var(--steel);"><span>100%</span></div>
      </div>
      <div class="kpi-card green" style="animation-delay:.1s">
        <div>
          <div class="kpi-icon"><i class="fas fa-check-double"></i></div>
          <div class="kpi-value mono">{{ $completedTasks }}</div>
          <div class="kpi-label">Completed</div>
        </div>
        @php $p = round($completedTasks / $total * 100); @endphp
        <div class="gauge" style="--pct:{{ $p }}; --ring:var(--green);"><span>{{ $p }}%</span></div>
      </div>
      <div class="kpi-card amber" style="animation-delay:.15s">
        <div>
          <div class="kpi-icon"><i class="fas fa-hourglass-half"></i></div>
          <div class="kpi-value mono">{{ $inProgressTasks }}</div>
          <div class="kpi-label">In Progress</div>
        </div>
        @php $p = round($inProgressTasks / $total * 100); @endphp
        <div class="gauge" style="--pct:{{ $p }}; --ring:var(--brass);"><span>{{ $p }}%</span></div>
      </div>
      <div class="kpi-card red" style="animation-delay:.2s">
        <div>
          <div class="kpi-icon"><i class="fas fa-exclamation-circle"></i></div>
          <div class="kpi-value mono">{{ $overdueTasks }}</div>
          <div class="kpi-label">Overdue</div>
        </div>
        @php $p = round($overdueTasks / $total * 100); @endphp
        <div class="gauge" style="--pct:{{ $p }}; --ring:var(--red);"><span>{{ $p }}%</span></div>
      </div>
    </div>

    <div class="risk-grid pt-section">
      <div class="risk-card" style="animation-delay:.2s">
        <div>
          <div class="risk-label">High Risk</div>
          <div class="risk-val mono" style="color:var(--red)">{{ $highRiskTasks }}</div>
        </div>
        @php $p = round($highRiskTasks / $total * 100); @endphp
        <div class="gauge" style="width:44px;height:44px;--pct:{{ $p }}; --ring:var(--red);"><span style="font-size:.55rem;">{{ $p }}%</span></div>
      </div>
      <div class="risk-card" style="animation-delay:.25s">
        <div>
          <div class="risk-label">Predicted Delayed</div>
          <div class="risk-val mono" style="color:var(--amber)">{{ $delayedTasks }}</div>
        </div>
        @php $p = round($delayedTasks / $total * 100); @endphp
        <div class="gauge" style="width:44px;height:44px;--pct:{{ $p }}; --ring:var(--amber);"><span style="font-size:.55rem;">{{ $p }}%</span></div>
      </div>
      <div class="risk-card" style="animation-delay:.3s">
        <div>
          <div class="risk-label">On Track</div>
          <div class="risk-val mono" style="color:var(--green)">{{ $onTimeTasks }}</div>
        </div>
        @php $p = round($onTimeTasks / $total * 100); @endphp
        <div class="gauge" style="width:44px;height:44px;--pct:{{ $p }}; --ring:var(--green);"><span style="font-size:.55rem;">{{ $p }}%</span></div>
      </div>
    </div>

    <div class="charts-row pt-section">
      <div class="chart-card blueprint" style="animation-delay:.35s">
        <h5><span class="icon-badge"><i class="fas fa-chart-line"></i></span>Task Completion Trend (Last 7 Days)</h5>
        <div class="chart-canvas-wrap"><canvas id="trendChart"></canvas></div>
      </div>
      <div class="chart-card" style="animation-delay:.4s">
        <h5><span class="icon-badge"><i class="fas fa-chart-pie"></i></span>Status Breakdown</h5>
        <div class="chart-canvas-wrap donut"><canvas id="statusChart"></canvas></div>
      </div>
    </div>

    <div class="bottom-row pt-section">
      <div class="chart-card" style="animation-delay:.45s">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="m-0"><span class="icon-badge"><i class="fas fa-robot"></i></span>ML Delay Risk Predictions</h5>
          @if($isAdmin)
            <span class="badge bg-light text-dark border" style="font-size:9px;">System-Wide</span>
          @elseif($isReadOnly)
            <span class="badge bg-light border" style="font-size:9px;color:var(--amber);">Read-Only</span>
          @else
            <span class="badge bg-light text-dark border" style="font-size:9px;">Live AI</span>
          @endif
        </div>
        <div style="overflow-x:auto;">
          <table class="pt-table">
            <thead>
              <tr>
                <th>Task</th>
                <th>Assigned To</th>
                <th>Due</th>
                <th>Risk %</th>
                <th>Outcome</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentPredictions as $p)
                <tr>
                  <td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:600;background:transparent !important;color:var(--ink) !important;">{{ $p->task->title ?? 'N/A' }}</td>
                  <td>{{ $p->task->assignedUser->first_name ?? '—' }}</td>
                  <td class="num">{{ $p->task->deadline ? \Carbon\Carbon::parse($p->task->deadline)->format('M d') : '—' }}</td>
                  <td>
                    @php $pct = round($p->delay_probability * 100); @endphp
                    <div class="d-flex align-items-center gap-2">
                      <div class="progress flex-grow-1" style="height:5px;border-radius:10px;width:35px;background:var(--track);">
                        <div class="progress-bar" style="width:{{ $pct }}%;background:{{ $pct >= 70 ? 'var(--red)' : ($pct >= 40 ? 'var(--amber)' : 'var(--green)') }};"></div>
                      </div>
                      <span class="num fw-bold" style="font-size:.72rem;">{{ $pct }}%</span>
                    </div>
                  </td>
                  <td>
                    <span class="badge-risk {{ $p->predicted_outcome === 'delayed' ? 'high' : 'low' }}">
                      {{ ucfirst(str_replace('_', ' ', $p->predicted_outcome)) }}
                    </span>
                  </td>
                </tr>
              @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">Awaiting ML model output...</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="chart-card" style="animation-delay:.5s">
        <h5><span class="icon-badge"><i class="fas fa-users-cog"></i></span>Employee Workload</h5>
        @php $maxLoad = $workloadData->max('active_tasks') ?: 1; @endphp
        @forelse($workloadData as $emp)
          <div class="workload-row">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <span class="fw-bold" style="font-size:.8rem;">{{ $emp->first_name }}</span>
              <span class="badge bg-light text-muted border num" style="font-size:.68rem;">{{ $emp->active_tasks }} tasks</span>
            </div>
            <div class="workload-bar-bg">
              <div class="workload-bar-fill" style="width:{{ round(($emp->active_tasks / $maxLoad) * 100) }}%"></div>
            </div>
          </div>
        @empty
          <p class="text-center py-3 text-muted" style="font-size:.8rem;">No workload data available.</p>
        @endforelse
      </div>
    </div>

  @endif

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
Chart.defaults.color = '#8891A5';
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.font.size = 11;

const trendCtx = document.getElementById('trendChart');
const trendGradient = trendCtx.getContext('2d').createLinearGradient(0, 0, 0, 160);
trendGradient.addColorStop(0, 'rgba(129,140,248,0.22)');
trendGradient.addColorStop(1, 'rgba(129,140,248,0)');

const trendData = {!! json_encode($trendCounts) !!};
const trendMax = Math.max(...trendData, 0);
// Keep the y-axis tight to the data so a flat/near-zero trend
// doesn't leave a large empty gap above the line.
const trendSuggestedMax = trendMax === 0 ? 3 : trendMax + Math.max(1, Math.ceil(trendMax * 0.25));

new Chart(trendCtx, {
  type: 'line',
  data: {
    labels: {!! json_encode($trendLabels) !!},
    datasets:[{
      data: trendData,
      fill: true,
      backgroundColor: trendGradient,
      borderColor:'#818CF8',
      borderWidth:2.5,
      pointRadius:0,
      pointHoverRadius:4,
      pointHoverBackgroundColor:'#818CF8',
      pointBackgroundColor:'#818CF8',
      tension:0.35
    }]
  },
  options:{
    responsive:true, maintainAspectRatio:false,
    interaction:{ intersect:false, mode:'index' },
    plugins:{
      legend:{display:false},
      tooltip:{
        backgroundColor:'#1D2330',
        titleFont:{size:11, weight:'600', family:"'Inter',sans-serif"},
        bodyFont:{size:11, family:"'Inter',sans-serif"},
        titleColor:'#E7E9EE',
        bodyColor:'#E7E9EE',
        borderColor:'rgba(255,255,255,.14)',
        borderWidth:1,
        padding:8,
        cornerRadius:8,
        displayColors:false
      }
    },
    scales:{
      y:{
        beginAtZero:true,
        suggestedMax: trendSuggestedMax,
        grid:{display:false}, border:{display:false}, ticks:{display:false}
      },
      x:{grid:{display:false}, border:{display:false}, ticks:{color:'#8891A5', font:{size:10}}}
    }
  }
});

@if(!$isEmployee)
new Chart(document.getElementById('statusChart'), {
  type:'doughnut',
  data:{
    labels:['Done','In Progress','Overdue'],
    datasets:[{
      data:[{{ $completedTasks }}, {{ $inProgressTasks }}, {{ $overdueTasks }}],
      backgroundColor:['#34D399','#818CF8','#F87171'],
      borderWidth:3, borderColor:'#12161F',
      hoverOffset:4
    }]
  },
  options:{
    responsive:true, maintainAspectRatio:false, cutout:'78%',
    plugins:{
      legend:{position:'bottom', labels:{color:'#8891A5', usePointStyle:true, pointStyle:'circle', padding:12, font:{size:10}}},
      tooltip:{
        backgroundColor:'#1D2330',
        titleFont:{size:11, weight:'600'},
        bodyFont:{size:11, family:"'Inter',sans-serif"},
        titleColor:'#E7E9EE',
        bodyColor:'#E7E9EE',
        borderColor:'rgba(255,255,255,.14)',
        borderWidth:1,
        padding:8,
        cornerRadius:8
      }
    }
  }
});
@endif

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

document.getElementById('mark-all-read')?.addEventListener('click', () => {
  fetch('{{ route("notifications.markAllRead") }}', {method:'POST', headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json','Content-Type':'application/json'}})
    .then(r => r.json()).then(() => {
      document.querySelectorAll('.notif-item.unread').forEach(el => el.classList.remove('unread'));
      document.querySelector('.notif-badge')?.remove();
    });
});

document.getElementById('clear-all')?.addEventListener('click', () => {
  fetch('{{ route("notifications.clearAll") }}', {method:'DELETE', headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json'}})
    .then(r => r.json()).then(() => {
      document.getElementById('notif-container').innerHTML = '<li class="text-center py-4 text-muted">No notifications</li>';
      document.querySelector('.notif-badge')?.remove();
    });
});

document.querySelectorAll('.remove-notif').forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    fetch(`/notifications/${btn.dataset.id}`, {method:'DELETE', headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json'}})
      .then(r => r.json()).then(() => btn.closest('li')?.remove());
  });
});
</script>

@endsection
@extends('layouts.business')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

<style>
:root{
  --bg:       #f8fafc;
  --surface:  #ffffff;
  --surface2: #f1f5f9;
  --accent:   #6366f1;
  --accent2:  #4f46e5;
  --success:  #10b981;
  --warning:  #f59e0b;
  --danger:   #ef4444;
  --text:     #0f172a;
  --muted:    #64748b;
  --border:   rgba(0,0,0,0.04);
  --shadow:   0 10px 15px -3px rgba(0,0,0,0.04), 0 4px 6px -2px rgba(0,0,0,0.02);
}
body, .content-wrapper { background: var(--bg) !important; color: var(--text) !important; font-family:'DM Sans',sans-serif; }
.pt-wrapper { padding: 1.5rem; max-width: 1600px; margin: 0 auto; }
.pt-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:.75rem; }
.pt-header-left h1 { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; background:linear-gradient(135deg,var(--accent2),var(--accent)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; margin:0; }
.pt-header-left p { color:var(--muted); font-size:0.83rem; margin-top:2px; }
.pt-clock { background:var(--surface); border:1px solid var(--border); box-shadow:var(--shadow); border-radius:10px; padding:.5rem 1rem; font-size:.8rem; color:var(--text); font-weight:500; }
.role-pill { font-size:.7rem; font-weight:700; padding:.3rem .8rem; border-radius:999px; letter-spacing:.04em; }
.pill-admin    { background:rgba(99,102,241,.1);  color:var(--accent); }
.pill-manager  { background:rgba(16,185,129,.1);  color:var(--success); }
.pill-employee { background:rgba(245,158,11,.1);  color:var(--warning); }
.pill-readonly { background:rgba(100,116,139,.1); color:var(--muted); }

.notif-btn { background:var(--surface); border:1px solid var(--border); border-radius:10px; padding:.5rem .9rem; color:var(--text); position:relative; cursor:pointer; transition:.3s; box-shadow:var(--shadow); }
.notif-btn:hover { border-color:var(--accent); transform:translateY(-2px); }
.notif-badge { position:absolute; top:-4px; right:-4px; background:var(--accent); color:#fff; font-size:9px; border-radius:50%; width:16px; height:16px; display:flex; align-items:center; justify-content:center; font-weight:600; border:2px solid var(--surface); }
.notif-dropdown { background:var(--surface); border:1px solid var(--border); border-radius:18px; min-width:340px; box-shadow:0 25px 50px -12px rgba(0,0,0,.08); padding:.4rem; }
.notif-dropdown .dropdown-header { color:var(--text); font-weight:700; padding:.8rem; border-bottom:1px solid var(--border); }
.notif-item { padding:.8rem; border-radius:10px; margin-bottom:3px; transition:.2s; }
.notif-item:hover { background:var(--surface2); }
.notif-item.unread { background:rgba(99,102,241,.04); border-left:3px solid var(--accent); }

.kpi-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem; }
@media(max-width:900px){ .kpi-grid{grid-template-columns:repeat(2,1fr);} }
.kpi-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:1.25rem; position:relative; overflow:hidden; transition:.4s; box-shadow:var(--shadow); animation:fadeInUp .6s ease both; }
.kpi-card:hover { transform:translateY(-5px); }
.kpi-icon { width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; margin-bottom:1rem; }
.kpi-card.indigo .kpi-icon { background:rgba(99,102,241,.08); color:var(--accent); }
.kpi-card.green  .kpi-icon { background:rgba(16,185,129,.08); color:var(--success); }
.kpi-card.amber  .kpi-icon { background:rgba(245,158,11,.08); color:var(--warning); }
.kpi-card.red    .kpi-icon { background:rgba(239,68,68,.08);  color:var(--danger); }
.kpi-value { font-family:'Syne',sans-serif; font-size:1.8rem; font-weight:800; line-height:1; margin-bottom:.3rem; color:var(--text); }
.kpi-label { font-size:.72rem; color:var(--muted); font-weight:600; text-transform:uppercase; letter-spacing:.05em; }

.risk-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:1.5rem; }
.risk-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:1rem; display:flex; align-items:center; gap:1rem; box-shadow:var(--shadow); animation:fadeInUp .7s ease both; }
.risk-val { font-family:'Syne',sans-serif; font-size:1.4rem; font-weight:700; }
.risk-label { font-size:.72rem; font-weight:600; color:var(--muted); }

.charts-row { display:grid; grid-template-columns:1.5fr 1fr; gap:1rem; margin-bottom:1.5rem; align-items:start; }
@media(max-width:900px){ .charts-row{grid-template-columns:1fr;} }
.chart-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:1.25rem; box-shadow:var(--shadow); animation:fadeInUp .8s ease both; }
.chart-card h5 { font-family:'Syne',sans-serif; font-size:.95rem; font-weight:700; color:var(--text); margin-bottom:1rem; }
.chart-card canvas { max-height:160px !important; }

.pt-table { width:100%; border-collapse:separate; border-spacing:0 .5rem; }
.pt-table thead th { font-size:.65rem; font-weight:700; text-transform:uppercase; color:var(--muted); padding:0 .8rem; border:none; }
.pt-table tbody tr { background:var(--surface2); transition:.3s; }
.pt-table tbody tr:hover { background:#fff; box-shadow:0 4px 10px rgba(0,0,0,.02); }
.pt-table tbody td { padding:.8rem; font-size:.8rem; color:var(--text); border:none; }
.pt-table tbody td:first-child { border-radius:10px 0 0 10px; font-weight:600; }
.pt-table tbody td:last-child  { border-radius:0 10px 10px 0; }
.badge-risk { font-size:.6rem; font-weight:700; padding:.3rem .7rem; border-radius:8px; }
.badge-risk.high   { background:#fee2e2; color:var(--danger); }
.badge-risk.medium { background:#fef3c7; color:var(--warning); }
.badge-risk.low    { background:#dcfce7; color:var(--success); }

.workload-bar-bg   { background:#e2e8f0; border-radius:999px; height:8px; }
.workload-bar-fill { background:linear-gradient(90deg,var(--accent2),var(--accent)); border-radius:999px; height:100%; transition:1s ease; }

.bottom-row { display:grid; grid-template-columns:1.5fr 1fr; gap:1rem; }
@media(max-width:900px){ .bottom-row{grid-template-columns:1fr;} }

.readonly-notice { background:rgba(245,158,11,.07); border:1px solid rgba(245,158,11,.2); border-radius:12px; padding:.65rem 1rem; font-size:.78rem; color:var(--warning); margin-bottom:1.25rem; }

::-webkit-scrollbar { width:6px; }
::-webkit-scrollbar-track { background:var(--bg); }
::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:99px; }
@keyframes fadeInUp { from{opacity:0;transform:translateY(15px)} to{opacity:1;transform:translateY(0)} }
</style>

<div class="pt-wrapper">

  {{-- ── Header ──────────────────────────────────────────────────────── --}}
  <div class="pt-header">
    <div class="pt-header-left">
      <h1><i class="fas fa-bolt me-2"></i>ProdTrack AI</h1>
      <p>
        Hello, <strong style="color:var(--text)">{{ $user->first_name }}</strong> &mdash;
        @if($isAdmin) Full system overview
        @elseif($isManager) Manager dashboard
        @elseif($isEmployee) Your personal workspace
        @else Read-only overview
        @endif
      </p>
    </div>

    <div class="d-flex align-items-center gap-3 flex-wrap">
      {{-- Role pill --}}
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

      <div class="pt-clock d-none d-md-block">
        <i class="far fa-clock me-2 text-primary"></i>
        <span id="pt-time">{{ now()->format('D, M j · H:i:s') }}</span>
      </div>

      {{-- Notification bell --}}
      <div class="dropdown">
        <button class="notif-btn" data-bs-toggle="dropdown">
          <i class="far fa-bell"></i>
          @if($unreadCount > 0)
            <span class="notif-badge" id="notif-badge">{{ $unreadCount }}</span>
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
                      <div style="color:var(--text);font-size:.8rem;">{{ $n->notification }}</div>
                      <div class="mt-1 opacity-75" style="font-size:.65rem;">{{ $n->created_at->diffForHumans() }}</div>
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

  {{-- ── Read-only notice ────────────────────────────────────────────── --}}
  @if($isReadOnly)
    <div class="readonly-notice">
      <i class="fas fa-lock me-2"></i> You are viewing in <strong>read-only mode</strong>. Contact your administrator to make changes.
    </div>
  @endif

  {{-- ══════════════════════════════════════════════════════════════════
       EMPLOYEE VIEW — only their own tasks, no AI, no team
  ══════════════════════════════════════════════════════════════════ --}}
  @if($isEmployee)

    <div class="kpi-grid" style="grid-template-columns:repeat(3,1fr);">
      <div class="kpi-card indigo" style="animation-delay:.1s">
        <div class="kpi-icon"><i class="fas fa-layer-group"></i></div>
        <div class="kpi-value">{{ $totalTasks }}</div>
        <div class="kpi-label">My Total Tasks</div>
      </div>
      <div class="kpi-card green" style="animation-delay:.2s">
        <div class="kpi-icon"><i class="fas fa-check-double"></i></div>
        <div class="kpi-value">{{ $completedTasks }}</div>
        <div class="kpi-label">Completed</div>
      </div>
      <div class="kpi-card amber" style="animation-delay:.3s">
        <div class="kpi-icon"><i class="fas fa-hourglass-half"></i></div>
        <div class="kpi-value">{{ $inProgressTasks }}</div>
        <div class="kpi-label">In Progress</div>
      </div>
    </div>

    @if($overdueTasks > 0)
      <div class="alert d-flex align-items-center gap-3 mb-4" style="background:#fee2e2;border:1px solid #fca5a5;border-radius:14px;padding:1rem 1.25rem;">
        <i class="fas fa-exclamation-triangle text-danger fa-lg"></i>
        <div>
          <strong style="color:#b91c1c;">{{ $overdueTasks }} overdue task{{ $overdueTasks > 1 ? 's' : '' }}</strong>
          <span style="color:#dc2626;font-size:.83rem;"> — please check your task board and update progress.</span>
        </div>
      </div>
    @endif

    <div class="chart-card">
      <h5><i class="fas fa-chart-line me-2 text-primary"></i>My Completion Activity (Last 7 Days)</h5>
      <canvas id="trendChart" height="60"></canvas>
    </div>

  {{-- ══════════════════════════════════════════════════════════════════
       ADMIN / MANAGER / READ-ONLY VIEW — full dashboard
  ══════════════════════════════════════════════════════════════════ --}}
  @else

    {{-- KPI Cards --}}
    <div class="kpi-grid">
      <div class="kpi-card indigo" style="animation-delay:.1s">
        <div class="kpi-icon"><i class="fas fa-layer-group"></i></div>
        <div class="kpi-value">{{ $totalTasks }}</div>
        <div class="kpi-label">Total Tasks</div>
      </div>
      <div class="kpi-card green" style="animation-delay:.2s">
        <div class="kpi-icon"><i class="fas fa-check-double"></i></div>
        <div class="kpi-value">{{ $completedTasks }}</div>
        <div class="kpi-label">Completed</div>
      </div>
      <div class="kpi-card amber" style="animation-delay:.3s">
        <div class="kpi-icon"><i class="fas fa-hourglass-half"></i></div>
        <div class="kpi-value">{{ $inProgressTasks }}</div>
        <div class="kpi-label">In Progress</div>
      </div>
      <div class="kpi-card red" style="animation-delay:.4s">
        <div class="kpi-icon"><i class="fas fa-exclamation-circle"></i></div>
        <div class="kpi-value">{{ $overdueTasks }}</div>
        <div class="kpi-label">Overdue</div>
      </div>
    </div>

    {{-- AI Risk Row --}}
    <div class="risk-grid">
      <div class="risk-card" style="border-bottom:3px solid var(--danger)">
        <div style="font-size:1.4rem;">🔥</div>
        <div>
          <div class="risk-label">High Risk</div>
          <div class="risk-val" style="color:var(--danger)">{{ $highRiskTasks }}</div>
        </div>
      </div>
      <div class="risk-card" style="border-bottom:3px solid var(--warning)">
        <div style="font-size:1.4rem;">⚠️</div>
        <div>
          <div class="risk-label">Predicted Delayed</div>
          <div class="risk-val" style="color:var(--warning)">{{ $delayedTasks }}</div>
        </div>
      </div>
      <div class="risk-card" style="border-bottom:3px solid var(--success)">
        <div style="font-size:1.4rem;">✨</div>
        <div>
          <div class="risk-label">On Track</div>
          <div class="risk-val" style="color:var(--success)">{{ $onTimeTasks }}</div>
        </div>
      </div>
    </div>

    {{-- Charts --}}
    <div class="charts-row">
      <div class="chart-card" style="animation-delay:.5s">
        <h5><i class="fas fa-chart-line me-2 text-primary"></i>Task Completion Trend (Last 7 Days)</h5>
        <canvas id="trendChart" height="60"></canvas>
      </div>
      <div class="chart-card" style="animation-delay:.6s">
        <h5><i class="fas fa-chart-pie me-2 text-primary"></i>Status Breakdown</h5>
        <canvas id="statusChart" height="100"></canvas>
      </div>
    </div>

    {{-- Bottom: Predictions + Workload --}}
    <div class="bottom-row">
      <div class="chart-card" style="animation-delay:.7s">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="m-0"><i class="fas fa-robot me-2 text-danger"></i>ML Delay Risk Predictions</h5>
          @if($isAdmin)
            <span class="badge bg-light text-dark border" style="font-size:9px;">System-Wide</span>
          @elseif($isReadOnly)
            <span class="badge bg-light text-warning border" style="font-size:9px;"><i class="fas fa-lock me-1"></i>Read-Only</span>
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
                  <td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $p->task->title ?? 'N/A' }}</td>
                  <td>{{ $p->task->assignedUser->first_name ?? '—' }}</td>
                  <td>{{ $p->task->deadline ? \Carbon\Carbon::parse($p->task->deadline)->format('M d') : '—' }}</td>
                  <td>
                    @php $pct = round($p->delay_probability * 100); @endphp
                    <div class="d-flex align-items-center gap-2">
                      <div class="progress flex-grow-1" style="height:5px;border-radius:10px;width:35px;">
                        <div class="progress-bar {{ $pct >= 70 ? 'bg-danger' : ($pct >= 40 ? 'bg-warning' : 'bg-success') }}" style="width:{{ $pct }}%"></div>
                      </div>
                      <span class="fw-bold" style="font-size:.7rem;">{{ $pct }}%</span>
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

      <div class="chart-card" style="animation-delay:.8s">
        <h5><i class="fas fa-users-cog me-2 text-primary"></i>Employee Workload</h5>
        @php $maxLoad = $workloadData->max('active_tasks') ?: 1; @endphp
        @forelse($workloadData as $emp)
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <span class="fw-bold" style="font-size:.8rem;">{{ $emp->first_name }}</span>
              <span class="badge bg-light text-muted border" style="font-size:.7rem;">{{ $emp->active_tasks }} tasks</span>
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

  @endif {{-- end admin/manager/readonly view --}}

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function updateClock(){
  const el = document.getElementById('pt-time');
  if(el) el.textContent = new Date().toLocaleString('en-US',{weekday:'short',month:'short',day:'numeric',hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:false});
}
setInterval(updateClock, 1000);

Chart.defaults.color = '#64748b';
Chart.defaults.font.family = "'DM Sans', sans-serif";

new Chart(document.getElementById('trendChart'), {
  type: 'line',
  data: {
    labels: {!! json_encode($trendLabels) !!},
    datasets:[{
      data: {!! json_encode($trendCounts) !!},
      fill: true,
      backgroundColor:'rgba(99,102,241,0.05)',
      borderColor:'#6366f1',
      borderWidth:2,
      pointRadius:3,
      tension:0.4
    }]
  },
  options:{
    responsive:true, maintainAspectRatio:false,
    plugins:{legend:{display:false}},
    scales:{
      y:{beginAtZero:true, grid:{display:false}, border:{display:false}, ticks:{display:false}},
      x:{grid:{display:false}, border:{display:false}, ticks:{font:{size:9}}}
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
      backgroundColor:['#10b981','#6366f1','#ef4444'],
      borderWidth:4, borderColor:'#fff'
    }]
  },
  options:{
    responsive:true, maintainAspectRatio:false, cutout:'82%',
    plugins:{legend:{position:'bottom', labels:{usePointStyle:true, padding:10, font:{size:9}}}}
  }
});
@endif

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

document.getElementById('mark-all-read')?.addEventListener('click', () => {
  fetch('{{ route("notifications.markAllRead") }}', {method:'POST', headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json','Content-Type':'application/json'}})
    .then(r => r.json()).then(() => {
      document.querySelectorAll('.notif-item.unread').forEach(el => el.classList.remove('unread'));
      document.getElementById('notif-badge')?.remove();
    });
});

document.getElementById('clear-all')?.addEventListener('click', () => {
  fetch('{{ route("notifications.clearAll") }}', {method:'DELETE', headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json'}})
    .then(r => r.json()).then(() => {
      document.getElementById('notif-container').innerHTML = '<li class="text-center py-4 text-muted">No notifications</li>';
      document.getElementById('notif-badge')?.remove();
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
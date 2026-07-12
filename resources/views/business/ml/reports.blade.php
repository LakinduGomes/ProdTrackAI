@extends('layouts.business')
@section('title') ML Reports @endsection
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{--accent:#6366f1;--success:#10b981;--warning:#f59e0b;--danger:#ef4444;--surface:#fff;--bg:#f8fafc;--muted:#64748b;--border:rgba(0,0,0,0.06);--shadow:0 1px 3px rgba(0,0,0,0.04),0 4px 12px rgba(0,0,0,0.04);}
body,.content-wrapper{background:var(--bg)!important;font-family:'DM Sans',sans-serif;}
.pt-page{padding:1.5rem;}
.pt-title{font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:#0f172a;margin:0;}
.pt-sub{color:var(--muted);font-size:.82rem;margin-top:2px;}
.card-pt{background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:1.25rem;box-shadow:var(--shadow);margin-bottom:1rem;}
.card-title{font-family:'Syne',sans-serif;font-size:.95rem;font-weight:800;color:#0f172a;margin-bottom:.75rem;}
.kpi-row{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;}
.kpi{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:1rem 1.2rem;box-shadow:var(--shadow);}
.kpi-val{font-family:'Syne',sans-serif;font-size:1.6rem;font-weight:800;color:#0f172a;}
.kpi-lbl{font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:var(--muted);}
.flask-panel{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:1.1rem 1.3rem;box-shadow:var(--shadow);margin-bottom:1.5rem;}
.flask-status{display:inline-flex;align-items:center;gap:.45rem;font-size:.78rem;font-weight:700;padding:.35rem .9rem;border-radius:999px;transition:.3s;}
.flask-status.online{background:#dcfce7;color:#16a34a;}
.flask-status.offline{background:#fee2e2;color:#dc2626;}
.flask-status.checking{background:#e0e7ff;color:#4338ca;}
.status-dot{width:8px;height:8px;border-radius:50%;background:currentColor;}
.status-dot.pulse{animation:blink 1.5s infinite;}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.3}}
.btn-fl{border:none;border-radius:10px;padding:.45rem 1rem;font-size:.8rem;font-weight:600;cursor:pointer;transition:.2s;display:inline-flex;align-items:center;gap:.4rem;}
.btn-fl:disabled{opacity:.45;cursor:not-allowed;}
.btn-stop{background:#ef4444;color:#fff;}
.btn-stop:hover:not(:disabled){background:#dc2626;}
.btn-check{background:#6366f1;color:#fff;}
.btn-check:hover{background:#4f46e5;}
.startup-box{background:#0f172a;border-radius:12px;padding:1rem 1.25rem;font-family:monospace;font-size:.8rem;color:#a5f3fc;margin-top:.75rem;position:relative;}
.startup-box .copy-btn{position:absolute;top:.6rem;right:.75rem;background:rgba(255,255,255,.1);border:none;color:#fff;border-radius:6px;padding:.2rem .6rem;font-size:.7rem;cursor:pointer;}
.startup-box .copy-btn:hover{background:rgba(255,255,255,.2);}
.log-box{background:#0f172a;border-radius:12px;padding:1rem;font-family:monospace;font-size:.73rem;color:#94a3b8;max-height:160px;overflow-y:auto;white-space:pre-wrap;word-break:break-all;margin-top:.75rem;}
.metrics-table{width:100%;font-size:.82rem;}
.metrics-table th{font-size:.68rem;font-weight:700;text-transform:uppercase;color:var(--muted);padding:.5rem .75rem;border:none;border-bottom:2px solid var(--border);}
.metrics-table td{padding:.6rem .75rem;border:none;border-bottom:1px solid var(--border);}
.metrics-table tr:last-child td{border-bottom:none;}
.metric-winner{background:rgba(16,185,129,.06);}
.badge-model{font-size:.65rem;font-weight:700;padding:.2rem .55rem;border-radius:6px;}
.badge-dt{background:#e0e7ff;color:#4338ca;}
.badge-rf{background:#dcfce7;color:#16a34a;}
.param-pill{background:#f1f5f9;color:#475569;font-size:.68rem;padding:.15rem .5rem;border-radius:6px;margin:.1rem;display:inline-block;}
.reports-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;margin-bottom:1.5rem;}
@media(max-width:900px){.reports-grid{grid-template-columns:1fr;}}
.report-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;overflow:hidden;box-shadow:var(--shadow);transition:.3s;}
.report-card:hover{transform:translateY(-3px);box-shadow:0 8px 25px rgba(0,0,0,.08);}
.report-header{padding:.9rem 1.1rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;}
.report-num{font-family:'Syne',sans-serif;font-size:.72rem;font-weight:800;color:var(--accent);background:rgba(99,102,241,.08);padding:.2rem .6rem;border-radius:6px;margin-bottom:.3rem;}
.report-title{font-family:'Syne',sans-serif;font-size:.88rem;font-weight:700;color:#0f172a;}
.report-img{width:100%;display:block;cursor:zoom-in;}
.report-missing{background:#f8fafc;padding:3rem;text-align:center;color:var(--muted);font-size:.82rem;}
.lightbox{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.9);z-index:9999;align-items:center;justify-content:center;flex-direction:column;gap:.75rem;}
.lightbox.active{display:flex;}
.lightbox img{max-width:92vw;max-height:86vh;border-radius:12px;}
.lightbox-title{color:#fff;font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;}
.lightbox-close{position:absolute;top:16px;right:20px;color:#fff;font-size:1.4rem;cursor:pointer;background:rgba(255,255,255,.12);border:none;border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;}
.lightbox-close:hover{background:rgba(255,255,255,.25);}
</style>
<div class="pt-page">
  <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
    <div>
      <div class="pt-title"><i class="fas fa-chart-bar me-2 text-primary"></i>ML Evaluation Reports</div>
      <div class="pt-sub">Model performance metrics and visual analysis — Decision Tree vs Random Forest</div>
    </div>
  </div>
  @if(session('success'))<div class="alert alert-success rounded-3 mb-3" style="font-size:.83rem;">{{ session('success') }}</div>@endif
  <div class="flask-panel">
    <div class="d-flex align-items-center gap-3 flex-wrap mb-2">
      <div>
        <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);">Flask ML API Status</div>
        <div id="flask-status-badge" class="flask-status checking mt-1">
          <span class="status-dot pulse" id="status-dot"></span>
          <span id="flask-status-text">Checking...</span>
        </div>
      </div>
      <div id="flask-accuracy" style="font-size:.8rem;color:var(--muted);display:none;">
        <i class="fas fa-brain me-1 text-primary"></i>Model Accuracy: <strong id="acc-val" style="color:#0f172a;"></strong>
      </div>
      <div class="ms-auto d-flex gap-2 flex-wrap">
        @if(!$isReadOnly)
          <button class="btn-fl btn-stop" id="btn-stop" onclick="stopFlask()" disabled>
            <i class="fas fa-stop"></i> Stop API
          </button>
        @endif
        <button class="btn-fl btn-check" onclick="checkStatus(true)">
          <i class="fas fa-sync"></i> Check Status
        </button>
      </div>
    </div>
    <div id="startup-guide" style="display:none;">
      <div style="font-size:.78rem;color:var(--muted);margin-bottom:.4rem;"><i class="fas fa-terminal me-1"></i>Flask is offline. Run this in your terminal:</div>
      <div class="startup-box">
        <span>cd ~/prodtrack-ml && source venv/bin/activate && python3 app.py</span>
        <button class="copy-btn" onclick="copyCmd()"><i class="fas fa-copy me-1"></i>Copy</button>
      </div>
      <div style="font-size:.72rem;color:var(--muted);margin-top:.5rem;">Then click <strong>Check Status</strong> above.</div>
    </div>
    <div id="log-section" style="display:none;">
      <div class="d-flex justify-content-between align-items-center mt-2">
        <div style="font-size:.72rem;font-weight:600;color:var(--muted);text-transform:uppercase;"><i class="fas fa-terminal me-1"></i>Flask Live Log</div>
        <button onclick="loadLog()" style="border:none;background:none;font-size:.72rem;color:var(--accent);cursor:pointer;"><i class="fas fa-refresh me-1"></i>Refresh</button>
      </div>
      <div class="log-box" id="log-content">Loading logs...</div>
    </div>
  </div>
  @if($metricsError)
    <div class="alert alert-warning rounded-3 mb-4" style="font-size:.83rem;"><i class="fas fa-exclamation-triangle me-2"></i>{{ $metricsError }}</div>
  @endif
  <div class="kpi-row">
    <div class="kpi"><div class="kpi-val">{{ $totalPredictions }}</div><div class="kpi-lbl">Total Predictions</div></div>
    <div class="kpi" style="border-left:3px solid #ef4444"><div class="kpi-val" style="color:#ef4444">{{ $highRisk }}</div><div class="kpi-lbl">High Risk</div></div>
    <div class="kpi" style="border-left:3px solid #ef4444"><div class="kpi-val" style="color:#ef4444">{{ $delayed }}</div><div class="kpi-lbl">Predicted Delayed</div></div>
    <div class="kpi" style="border-left:3px solid #10b981"><div class="kpi-val" style="color:#10b981">{{ $onTime }}</div><div class="kpi-lbl">Predicted On-Time</div></div>
  </div>
  @if($metrics)
  <div class="card-pt mb-4">
    <div class="card-title"><i class="fas fa-table me-2 text-primary"></i>Model Performance Summary</div>
    <div style="overflow-x:auto;">
      <table class="metrics-table">
        <thead><tr><th>Metric</th><th><span class="badge-model badge-dt">Decision Tree</span></th><th><span class="badge-model badge-rf">Random Forest</span></th><th>Winner</th></tr></thead>
        <tbody>
          @php $metricRows=[['label'=>'Baseline Accuracy','key'=>'baseline_accuracy'],['label'=>'Tuned Accuracy','key'=>'accuracy'],['label'=>'Precision','key'=>'precision'],['label'=>'Recall','key'=>'recall'],['label'=>'F1 Score','key'=>'f1'],['label'=>'MCC','key'=>'mcc'],['label'=>'ROC AUC','key'=>'roc_auc'],['label'=>'CV Mean (5-fold)','key'=>'cv_mean']]; @endphp
          @foreach($metricRows as $row)
            @php $dtVal=$metrics['decision_tree'][$row['key']]??0;$rfVal=$metrics['random_forest'][$row['key']]??0;$dtWins=$dtVal>$rfVal;$rfWins=$rfVal>$dtVal; @endphp
            <tr>
              <td style="font-weight:600;">{{ $row['label'] }}</td>
              <td class="{{ $dtWins?'metric-winner':'' }}"><strong>{{ number_format($dtVal,4) }}</strong>@if($dtWins)<i class="fas fa-arrow-up text-success ms-1" style="font-size:.6rem;"></i>@endif</td>
              <td class="{{ $rfWins?'metric-winner':'' }}"><strong>{{ number_format($rfVal,4) }}</strong>@if($rfWins)<i class="fas fa-arrow-up text-success ms-1" style="font-size:.6rem;"></i>@endif</td>
              <td>@if($dtWins)<span class="badge-model badge-dt">DT</span>@elseif($rfWins)<span class="badge-model badge-rf">RF</span>@else<span style="color:var(--muted);font-size:.72rem;">Tie</span>@endif</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="row mt-3 g-3">
      <div class="col-md-6"><div style="background:#f8fafc;border-radius:10px;padding:.75rem 1rem;"><div style="font-size:.75rem;font-weight:700;color:#0f172a;margin-bottom:.4rem;"><span class="badge-model badge-dt me-1">DT</span> Best Parameters</div>@foreach($metrics['decision_tree']['best_params']??[] as $key=>$val)<span class="param-pill">{{ $key }}: {{ $val }}</span>@endforeach</div></div>
      <div class="col-md-6"><div style="background:#f8fafc;border-radius:10px;padding:.75rem 1rem;"><div style="font-size:.75rem;font-weight:700;color:#0f172a;margin-bottom:.4rem;"><span class="badge-model badge-rf me-1">RF</span> Best Parameters</div>@foreach($metrics['random_forest']['best_params']??[] as $key=>$val)<span class="param-pill">{{ $key }}: {{ $val }}</span>@endforeach</div></div>
    </div>
    <div class="mt-3 pt-3" style="border-top:1px solid var(--border);"><div class="d-flex gap-4 flex-wrap" style="font-size:.78rem;color:var(--muted);"><span><i class="fas fa-database me-1"></i>Source: <strong style="color:#0f172a;">{{ $metrics['dataset_source']??'N/A' }}</strong></span><span><i class="fas fa-list me-1"></i>Total: <strong style="color:#0f172a;">{{ $metrics['dataset_size']??'N/A' }}</strong></span><span><i class="fas fa-train me-1"></i>Train: <strong style="color:#0f172a;">{{ $metrics['train_size']??'N/A' }}</strong></span><span><i class="fas fa-vial me-1"></i>Test: <strong style="color:#0f172a;">{{ $metrics['test_size']??'N/A' }}</strong></span><span><i class="fas fa-clock me-1"></i>Trained: <strong style="color:#0f172a;">{{ isset($metrics['trained_at'])?\Carbon\Carbon::parse($metrics['trained_at'])->format('M d, Y H:i'):'N/A' }}</strong></span></div></div>
  </div>
  @endif
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:#0f172a;"><i class="fas fa-images me-2 text-primary"></i>Evaluation Charts</div>
    <span style="font-size:.75rem;color:var(--muted);"><i class="fas fa-search-plus me-1"></i>Click any chart to enlarge</span>
  </div>
  <div class="reports-grid">
    @foreach($charts as $key=>$chart)
      <div class="report-card">
        <div class="report-header">
          <div><div class="report-num">Report {{ $loop->iteration }} of {{ count($charts) }}</div><div class="report-title">{{ $chart['title'] }}</div></div>
          @if($chart['exists'])<a href="{{ $chart['route'] }}" download="{{ $chart['file'] }}" class="btn btn-sm btn-light border" style="font-size:.72rem;border-radius:8px;"><i class="fas fa-download me-1"></i>Save</a>@endif
        </div>
        @if($chart['exists'])
          <img src="{{ $chart['route'] }}?t={{ time() }}" class="report-img" alt="{{ $chart['title'] }}" onclick="openLightbox(this.src,'{{ $chart['title'] }}')">
        @else
          <div class="report-missing"><i class="fas fa-image fa-2x mb-2" style="color:#cbd5e1;display:block;"></i><div>Chart not generated yet.</div><div style="margin-top:.4rem;font-size:.75rem;">Run <code>python3 train_model_enhanced.py</code></div></div>
        @endif
      </div>
    @endforeach
  </div>
</div>
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
  <button class="lightbox-close" onclick="closeLightbox()"><i class="fas fa-times"></i></button>
  <div class="lightbox-title" id="lightbox-title"></div>
  <img id="lightbox-img" src="" alt="" onclick="event.stopPropagation()">
</div>
@endsection
@section('scripts')
<script>
const csrf=document.querySelector('meta[name="csrf-token"]')?.content;
const FLASK = 'http://127.0.0.1:5001';
let isOnline=false;
function setStatus(status,accuracy){
    const badge=document.getElementById('flask-status-badge');
    const text=document.getElementById('flask-status-text');
    const dot=document.getElementById('status-dot');
    const btnStop=document.getElementById('btn-stop');
    const guide=document.getElementById('startup-guide');
    const logSec=document.getElementById('log-section');
    const accEl=document.getElementById('flask-accuracy');
    const accVal=document.getElementById('acc-val');
    if(status==='online'){
        isOnline=true;
        badge.className='flask-status online mt-1';
        text.textContent='Online';
        dot.className='status-dot pulse';
        if(btnStop)btnStop.disabled=false;
        if(guide)guide.style.display='none';
        if(logSec)logSec.style.display='block';
        if(accEl)accEl.style.display='flex';
        if(accuracy&&accVal)accVal.textContent=(accuracy*100).toFixed(0)+'%';
        loadLog();
    }else{
        isOnline=false;
        badge.className='flask-status offline mt-1';
        text.textContent='Offline';
        dot.className='status-dot';
        if(btnStop)btnStop.disabled=true;
        if(guide)guide.style.display='block';
        if(logSec)logSec.style.display='none';
        if(accEl)accEl.style.display='none';
    }
}
function checkStatus(showAlert){
    document.getElementById('flask-status-badge').className='flask-status checking mt-1';
    document.getElementById('flask-status-text').textContent='Checking...';
    document.getElementById('status-dot').className='status-dot pulse';
    fetch(FLASK+'/',{signal:AbortSignal.timeout(3000)})
        .then(r=>r.json())
        .then(data=>{
            setStatus('online',data.rf_accuracy);
            if(showAlert)showToast('✅ Flask is online — Accuracy: '+(data.rf_accuracy*100).toFixed(0)+'%','success');
        })
        .catch(()=>{
            setStatus('offline',null);
            if(showAlert)showToast('❌ Flask is offline. Start it in terminal first.','danger');
        });
}
function stopFlask(){
    const btn=document.getElementById('btn-stop');
    btn.disabled=true;
    btn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Stopping...';
    fetch('/ml/flask-stop',{method:'POST',headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json','Content-Type':'application/json'}})
    .then(r=>r.json())
    .then(()=>{
        setTimeout(()=>{
            fetch(FLASK+'/',{signal:AbortSignal.timeout(2000)})
                .then(()=>{setStatus('online',null);showToast('⚠️ Flask still running.','warning');})
                .catch(()=>{setStatus('offline',null);showToast('🛑 Flask stopped.','success');});
            btn.innerHTML='<i class="fas fa-stop"></i> Stop API';
        },2000);
    })
    .catch(()=>{btn.disabled=false;btn.innerHTML='<i class="fas fa-stop"></i> Stop API';});
}
function loadLog(){
    fetch('/ml/flask-log',{headers:{'Accept':'application/json'}})
        .then(r=>r.json())
        .then(data=>{
            const box=document.getElementById('log-content');
            if(box){
                let html=data.log||'No logs yet.';
                html=html.replace(/API ready|Models loaded/g,m=>`<span style="color:#10b981">${m}</span>`);
                html=html.replace(/WARNING/g,m=>`<span style="color:#f59e0b">${m}</span>`);
                html=html.replace(/Error|Traceback/g,m=>`<span style="color:#ef4444">${m}</span>`);
                box.innerHTML=html;
                box.scrollTop=box.scrollHeight;
            }
        }).catch(()=>{});
}
function showToast(msg,type){
    const colors={success:'#10b981',danger:'#ef4444',warning:'#f59e0b'};
    const t=document.createElement('div');
    t.style.cssText=`position:fixed;bottom:24px;right:24px;background:${colors[type]||'#6366f1'};color:#fff;padding:.75rem 1.25rem;border-radius:12px;font-size:.82rem;font-weight:600;z-index:9999;box-shadow:0 8px 24px rgba(0,0,0,.2);max-width:340px;`;
    t.textContent=msg;
    document.body.appendChild(t);
    setTimeout(()=>t.remove(),4000);
}
function copyCmd(){
    navigator.clipboard.writeText('cd ~/prodtrack-ml && source venv/bin/activate && python3 app.py');
    showToast('✅ Command copied!','success');
}
setInterval(()=>checkStatus(false),10000);
setInterval(()=>{if(isOnline)loadLog();},8000);
window.addEventListener('load',()=>checkStatus(false));
function openLightbox(src,title){document.getElementById('lightbox-img').src=src;document.getElementById('lightbox-title').textContent=title;document.getElementById('lightbox').classList.add('active');document.body.style.overflow='hidden';}
function closeLightbox(){document.getElementById('lightbox').classList.remove('active');document.body.style.overflow='';}
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeLightbox();});
</script>
@endsection

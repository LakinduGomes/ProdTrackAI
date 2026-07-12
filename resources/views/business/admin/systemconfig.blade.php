@extends('layouts.business')

@section('content')
<div class="container py-5">

    <div class="row g-4">

        <!-- Working Hours Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-5 hover-card">
                <div class="card-header bg-gradient-to-right-primary text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i> Working Hours</h5>
                    <span class="badge bg-light text-primary">Configure</span>
                </div>
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Start Time</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-play text-primary"></i></span>
                                <input type="time" class="form-control" id="startTime" value="08:00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">End Time</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-stop text-danger"></i></span>
                                <input type="time" class="form-control" id="endTime" value="18:00">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-muted fw-medium">Total Working Hours: <span id="totalHours">10h 0m</span></div>
                    <button class="btn btn-primary w-100 mt-3" onclick="saveWorkingHours()"><i class="fas fa-save me-2"></i> Save</button>
                </div>
            </div>
        </div>

        <!-- RFID Rules Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-5 hover-card">
                <div class="card-header bg-gradient-to-right-success text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="fas fa-id-card me-2"></i> RFID Rules</h5>
                    <span class="badge bg-light text-success">Configure</span>
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="allowMultipleRFID" checked>
                        <label class="form-check-label fw-medium" for="allowMultipleRFID">Allow Multiple RFID per Visitor</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="autoExpireRFID" checked>
                        <label class="form-check-label fw-medium" for="autoExpireRFID">Auto-Expire RFID after Visit</label>
                    </div>
                    <div class="small text-muted mb-2">Example: Visitor card preview reflects these rules.</div>
                    <button class="btn btn-success w-100" onclick="saveConfig('RFID Rules')"><i class="fas fa-save me-2"></i>Save</button>
                </div>
            </div>
        </div>

        <!-- Gate Timings Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-5 hover-card">
                <div class="card-header bg-gradient-to-right-warning text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="fas fa-door-open me-2"></i> Gate Timings</h5>
                    <span class="badge bg-light text-warning">Configure</span>
                </div>
                <div class="card-body">
                    <div id="gateList">
                        <div class="row g-3 mb-2 gate-item">
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="Main Gate" placeholder="Gate Name">
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" value="07:30">
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" value="19:30">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-warning w-100 mb-2" onclick="addGate()"><i class="fas fa-plus me-2"></i>Add Gate</button>
                    <button class="btn btn-warning w-100" onclick="saveConfig('Gate Timings')"><i class="fas fa-save me-2"></i>Save</button>
                </div>
            </div>
        </div>

        <!-- Branding Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-5 hover-card">
                <div class="card-header bg-gradient-to-right-info text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="fas fa-paint-roller me-2"></i> Branding</h5>
                    <span class="badge bg-light text-info">Customize</span>
                </div>
                <div class="card-body">
                    <label class="form-label fw-semibold">Company Logo</label>
                    <input type="file" class="form-control mb-3" id="logoInput" onchange="previewLogo(event)">
                    <img id="logoPreview" src="#" alt="Logo Preview" class="rounded-3 d-block mb-3" style="max-height:80px; display:none;">

                    <label class="form-label fw-semibold">Theme Color</label>
                    <input type="color" class="form-control form-control-color mb-2" id="themeColor" value="#1e88e5" onchange="updateThemePreview()">
                    <div class="theme-preview p-2 rounded mb-3 text-center text-white fw-bold" style="background-color:#1e88e5;">Preview Header</div>

                    <button class="btn btn-info w-100" onclick="saveConfig('Branding')"><i class="fas fa-save me-2"></i>Save</button>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* Modern Card Hover */
.hover-card:hover { transform: translateY(-6px); transition: 0.3s; box-shadow: 0 10px 25px rgba(0,0,0,0.12); }

/* Gradient Headers */
.bg-gradient-to-right-primary { background: linear-gradient(135deg,#3b82f6,#0ea5e9); }
.bg-gradient-to-right-warning { background: linear-gradient(135deg,#f59e0b,#d97706); }
.bg-gradient-to-right-success { background: linear-gradient(135deg,#10b981,#059669); }
.bg-gradient-to-right-info { background: linear-gradient(135deg,#06b6d4,#0ea5e9); }

/* Buttons */
.btn-primary { background: #3b82f6; border-radius: 50px; transition: transform 0.2s; }
.btn-primary:hover { transform: scale(1.05); }
.btn-warning { background: #f59e0b; border-radius: 50px; transition: transform 0.2s; }
.btn-warning:hover { transform: scale(1.05); }
.btn-success { background: #10b981; border-radius: 50px; transition: transform 0.2s; }
.btn-success:hover { transform: scale(1.05); }
.btn-info { background: #06b6d4; border-radius: 50px; transition: transform 0.2s; }
.btn-info:hover { transform: scale(1.05); }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    calcHours();
});

// Working Hours calculation
document.getElementById('startTime').addEventListener('input', calcHours);
document.getElementById('endTime').addEventListener('input', calcHours);

function calcHours() {
    const start = document.getElementById('startTime').value;
    const end = document.getElementById('endTime').value;
    if(start && end){
        const diff = (new Date(`1970-01-01T${end}`) - new Date(`1970-01-01T${start}`))/60000;
        if(diff < 0) {
            document.getElementById('totalHours').textContent = 'Invalid time range';
            return;
        }
        const hours = Math.floor(diff/60);
        const mins = diff % 60;
        document.getElementById('totalHours').textContent = `${hours}h ${mins}m`;
    }
}

function saveWorkingHours(){ saveConfig('Working Hours'); }

function addGate(){
    const gateList = document.getElementById('gateList');
    const newGate = document.createElement('div');
    newGate.classList.add('row','g-3','mb-2','gate-item');
    newGate.innerHTML = `
        <div class="col-md-4"><input type="text" class="form-control" value="New Gate" placeholder="Gate Name"></div>
        <div class="col-md-4"><input type="time" class="form-control" value="08:00"></div>
        <div class="col-md-4"><input type="time" class="form-control" value="18:00"></div>
    `;
    gateList.appendChild(newGate);
}

function previewLogo(event){
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('logoPreview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}

function updateThemePreview(){
    const color = document.getElementById('themeColor').value;
    document.querySelector('.theme-preview').style.backgroundColor = color;
}

function saveConfig(type){
    Swal.fire({
        toast:true,
        position:'top-end',
        icon:'success',
        title: type + ' saved successfully!',
        showConfirmButton:false,
        timer:2000,
        background:'linear-gradient(135deg,#4CAF50,#81C784)',
        color:'#fff'
    });
}
</script>
@endsection

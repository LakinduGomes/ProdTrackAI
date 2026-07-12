@extends('layouts.business')
@section('title')
    Employees
@endsection
@section('content')
    <style>
        .modal-dialog-scrollable .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .section-title {
            font-weight: 700;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #6366f1;
            padding-bottom: .4rem;
            border-bottom: 2px solid #e0e7ff;
            margin-bottom: 1rem;
            margin-top: 1.2rem;
        }

        .form-label {
            font-size: .78rem;
            font-weight: 600;
            color: #374151;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            font-size: .83rem;
            border: 1px solid #e2e8f0;
        }

        .modal-content {
            border-radius: 16px;
            border: none;
        }

        .login-badge {
            background: #dcfce7;
            color: #16a34a;
            font-size: .68rem;
            font-weight: 700;
            padding: .2rem .6rem;
            border-radius: 6px;
        }

        .no-login-badge {
            background: #fee2e2;
            color: #dc2626;
            font-size: .68rem;
            font-weight: 700;
            padding: .2rem .6rem;
            border-radius: 6px;
        }
    </style>

    <div class="row">
        <div class="col-sm-12" style="margin-top:-20px;margin-left:-20px;">
            <div class="card card-table show-entire">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Employees</h4>
                        <button class="btn btn-primary" onclick="addEmployee()"><i class="fa fa-plus me-1"></i>Add
                            Employee</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-stripped" id="emp_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Job Title</th>
                                    <th>Department</th>
                                    <th>Phone</th>
                                    <th>Work Email</th>
                                    <th>Type</th>
                                    <th>Emp. Status</th>
                                    <th>Login</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalTitle">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="employeeForm" enctype="multipart/form-data">
                    <input type="hidden" id="emp_id" name="emp_id">
                    <div class="modal-body px-4">

                        <div class="section-title"><i class="fa fa-user me-2"></i>Personal Information</div>
                        <div class="row g-3">
                            <div class="col-md-3"><label class="form-label">First Name *</label><input type="text"
                                    name="first_name" id="emp_first_name" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Last Name *</label><input type="text"
                                    name="last_name" id="emp_last_name" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Date of Birth</label><input type="date"
                                    name="date_of_birth" id="emp_dob" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Gender</label>
                                <select name="gender" id="emp_gender" class="form-select">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3"><label class="form-label">National ID / NIC</label><input type="text"
                                    name="national_id" id="emp_nic" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Profile Photo</label><input type="file"
                                    name="profile_photo" class="form-control" accept="image/*"></div>
                        </div>

                        <div class="section-title"><i class="fa fa-phone me-2"></i>Contact Information</div>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Phone</label><input type="text"
                                    name="phone" id="emp_phone" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Personal Email</label><input type="email"
                                    name="personal_email" id="emp_personal_email" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Work Email</label><input type="email"
                                    name="work_email" id="emp_work_email" class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Emergency Contact Name</label><input
                                    type="text" name="emergency_contact_name" id="emp_ec_name" class="form-control">
                            </div>
                            <div class="col-md-4"><label class="form-label">Emergency Contact Phone</label><input
                                    type="text" name="emergency_contact_phone" id="emp_ec_phone"
                                    class="form-control"></div>
                            <div class="col-md-4"><label class="form-label">Relationship</label><input type="text"
                                    name="emergency_contact_relation" id="emp_ec_rel" class="form-control"
                                    placeholder="e.g. Spouse, Parent"></div>
                        </div>

                        <div class="section-title"><i class="fa fa-map-marker me-2"></i>Address</div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Address Line 1</label><input type="text"
                                    name="address_line1" id="emp_addr1" class="form-control"></div>
                            <div class="col-md-6"><label class="form-label">Address Line 2</label><input type="text"
                                    name="address_line2" id="emp_addr2" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">City</label><input type="text"
                                    name="city" id="emp_city" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">State / Province</label><input type="text"
                                    name="state" id="emp_state" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Postal Code</label><input type="text"
                                    name="postal_code" id="emp_postal" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Country</label><input type="text"
                                    name="country" id="emp_country" class="form-control" value="Sri Lanka"></div>
                        </div>

                        <div class="section-title"><i class="fa fa-briefcase me-2"></i>Employment Details</div>
                        <div class="row g-3">
                            <div class="col-md-3"><label class="form-label">Employee Code</label><input type="text"
                                    name="employee_code" id="emp_code" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Job Title</label><input type="text"
                                    name="job_title" id="emp_job_title" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Department</label>
                                <select name="department" id="emp_department" class="form-select">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-3"><label class="form-label">Reporting Manager</label>
                                <select name="reporting_manager_id" id="emp_manager" class="form-select">
                                    <option value="">None</option>
                                </select>
                            </div>
                            <div class="col-md-3"><label class="form-label">Employment Type</label>
                                <select name="employment_type" id="emp_type" class="form-select">
                                    <option value="full_time">Full Time</option>
                                    <option value="part_time">Part Time</option>
                                    <option value="contract">Contract</option>
                                    <option value="intern">Intern</option>
                                </select>
                            </div>
                            <div class="col-md-3"><label class="form-label">Employment Status</label>
                                <select name="employment_status" id="emp_emp_status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="on_leave">On Leave</option>
                                    <option value="resigned">Resigned</option>
                                    <option value="terminated">Terminated</option>
                                </select>
                            </div>
                            <div class="col-md-3"><label class="form-label">Joining Date</label><input type="date"
                                    name="joining_date" id="emp_joining" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Probation End Date</label><input
                                    type="date" name="probation_end_date" id="emp_probation" class="form-control">
                            </div>
                        </div>

                        <div class="section-title"><i class="fa fa-money me-2"></i>Payroll & Banking</div>
                        <div class="row g-3">
                            <div class="col-md-3"><label class="form-label">Basic Salary (LKR)</label><input
                                    type="number" name="basic_salary" id="emp_salary" class="form-control"
                                    step="0.01"></div>
                            <div class="col-md-3"><label class="form-label">Bank Name</label><input type="text"
                                    name="bank_name" id="emp_bank" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Branch</label><input type="text"
                                    name="bank_branch" id="emp_branch" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Account Number</label><input type="text"
                                    name="bank_account_number" id="emp_account" class="form-control"></div>
                        </div>

                        <div class="section-title"><i class="fa fa-graduation-cap me-2"></i>Qualifications</div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Highest Qualification</label><input
                                    type="text" name="highest_qualification" id="emp_qual" class="form-control">
                            </div>
                            <div class="col-md-6"><label class="form-label">Field of Study</label><input type="text"
                                    name="field_of_study" id="emp_field" class="form-control"></div>
                        </div>

                        <div class="section-title"><i class="fa fa-sticky-note me-2"></i>Additional</div>
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label">Notes</label>
                                <textarea name="notes" id="emp_notes" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch mt-3">
                                    <input class="form-check-input" type="checkbox" name="status"
                                        id="emp_record_status" checked>
                                    <label class="form-check-label" for="emp_record_status">Active Record</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveEmployee()">Save Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Employee Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4" id="viewEmployeeBody">Loading...</div>
                <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var empTable;
        var empSaveMethod = "add";

        $(document).ready(function() {
            loadEmpTable();
        });

        function loadEmpTable() {
            if ($.fn.DataTable.isDataTable('#emp_table')) $('#emp_table').DataTable().destroy();
            empTable = $('#emp_table').DataTable({
                stripeClasses: [],
                lengthMenu: [10, 25, 50],
                pageLength: 25,
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: {
                    url: "{{ url('/employees-data') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'employee_code',
                        render: d => d || '—'
                    },
                    {
                        data: null,
                        render: d => d.first_name + ' ' + d.last_name
                    },
                    {
                        data: 'job_title',
                        render: d => d || '—'
                    },
                    {
                        data: 'department_name',
                        render: d => d || '—'
                    },
                    {
                        data: 'phone',
                        render: d => d || '—'
                    },
                    {
                        data: 'work_email',
                        render: d => d || '—'
                    },
                    {
                        data: 'employment_type',
                        render: d => d ? d.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) : '—'
                    },
                    {
                        data: 'employment_status',
                        render: function(d) {
                            let colors = {
                                active: '#dcfce7|#16a34a',
                                on_leave: '#fef3c7|#d97706',
                                resigned: '#fee2e2|#dc2626',
                                terminated: '#f1f5f9|#64748b'
                            };
                            let c = ((colors[d]) || '#f1f5f9|#64748b').split('|');
                            return `<span style="background:${c[0]};color:${c[1]};padding:2px 8px;border-radius:6px;font-size:.72rem;font-weight:700;">${d ? d.replace('_', ' ') : '—'}</span>`;
                        }
                    },
                    {
                        data: 'user_id',
                        render: d => d ?
                            '<span class="login-badge"><i class="fa fa-check me-1"></i>Has Login</span>' :
                            '<span class="no-login-badge">No Login</span>'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        }

        function addEmployee() {
            empSaveMethod = "add";
            $('#employeeForm')[0].reset();
            $('#emp_id').val('');
            $('#employeeModalTitle').text('Add Employee');
            $('#emp_record_status').prop('checked', true);
            loadEmpMaster();
            $('#employeeModal').modal('show');
        }

        function loadEmpMaster() {
            $.ajax({
                url: "{{ url('/employees-master-data') }}",
                success: function(data) {
                    $('#emp_department').empty().append('<option value="">Select</option>');
                    data.departments.forEach(d => $('#emp_department').append(
                        `<option value="${d.id}">${d.name}</option>`));
                    $('#emp_manager').empty().append('<option value="">None</option>');
                    data.managers.forEach(m => $('#emp_manager').append(
                        `<option value="${m.id}">${m.first_name} ${m.last_name}</option>`));
                }
            });
        }

        function saveEmployee() {
            let id = $("#emp_id").val();
            let url = empSaveMethod === "add" ? "{{ url('/employees-store') }}" : "{{ url('/employees-update') }}/" + id;
            let formData = new FormData(document.getElementById('employeeForm'));
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            if (empSaveMethod === "update") formData.append('_method', 'PUT');

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                                icon: 'success',
                                title: 'Saved!',
                                text: res.message
                            })
                            .then(() => {
                                $('#employeeModal').modal('hide');
                                empTable.ajax.reload();
                            });
                    } else {
                        let msg = res.errors ? '<ul>' + res.errors.map(e => '<li>' + e + '</li>').join('') +
                            '</ul>' : res.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: msg
                        });
                    }
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON?.errors ? '<ul>' + xhr.responseJSON.errors.map(e => '<li>' + e +
                        '</li>').join('') + '</ul>' : 'Unexpected error.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: msg
                    });
                }
            });
        }

        function editEmployee(id) {
            empSaveMethod = "update";
            loadEmpMaster();
            $.ajax({
                url: "{{ url('/employees-details') }}/" + id,
                success: function(res) {
                    if (res.success) {
                        let e = res.data;
                        $('#emp_id').val(e.id);
                        $('#emp_first_name').val(e.first_name);
                        $('#emp_last_name').val(e.last_name);
                        $('#emp_dob').val(e.date_of_birth);
                        $('#emp_gender').val(e.gender);
                        $('#emp_nic').val(e.national_id);
                        $('#emp_phone').val(e.phone);
                        $('#emp_personal_email').val(e.personal_email);
                        $('#emp_work_email').val(e.work_email);
                        $('#emp_ec_name').val(e.emergency_contact_name);
                        $('#emp_ec_phone').val(e.emergency_contact_phone);
                        $('#emp_ec_rel').val(e.emergency_contact_relation);
                        $('#emp_addr1').val(e.address_line1);
                        $('#emp_addr2').val(e.address_line2);
                        $('#emp_city').val(e.city);
                        $('#emp_state').val(e.state);
                        $('#emp_postal').val(e.postal_code);
                        $('#emp_country').val(e.country);
                        $('#emp_code').val(e.employee_code);
                        $('#emp_job_title').val(e.job_title);
                        $('#emp_type').val(e.employment_type);
                        $('#emp_emp_status').val(e.employment_status);
                        $('#emp_joining').val(e.joining_date);
                        $('#emp_probation').val(e.probation_end_date);
                        $('#emp_salary').val(e.basic_salary);
                        $('#emp_bank').val(e.bank_name);
                        $('#emp_branch').val(e.bank_branch);
                        $('#emp_account').val(e.bank_account_number);
                        $('#emp_qual').val(e.highest_qualification);
                        $('#emp_field').val(e.field_of_study);
                        $('#emp_notes').val(e.notes);
                        $('#emp_record_status').prop('checked', e.status == 1);
                        $('#employeeModalTitle').text('Edit Employee');
                        setTimeout(function() {
                            $('#emp_department').val(e.department);
                            $('#emp_manager').val(e.reporting_manager_id);
                        }, 400);
                        $('#employeeModal').modal('show');
                    }
                }
            });
        }

        function viewEmployee(id) {
            $.ajax({
                url: "{{ url('/employees-details') }}/" + id,
                success: function(res) {
                    if (res.success) {
                        let e = res.data;
                        let addr = [e.address_line1, e.address_line2, e.city, e.state, e.postal_code, e.country]
                            .filter(Boolean).join(', ') || '—';
                        $('#viewEmployeeBody').html(`
                    <div class="row g-3 small">
                        <div class="col-md-6"><b>Name:</b> ${e.first_name} ${e.last_name}</div>
                        <div class="col-md-6"><b>Code:</b> ${e.employee_code || '—'}</div>
                        <div class="col-md-6"><b>Job Title:</b> ${e.job_title || '—'}</div>
                        <div class="col-md-6"><b>Phone:</b> ${e.phone || '—'}</div>
                        <div class="col-md-6"><b>Work Email:</b> ${e.work_email || '—'}</div>
                        <div class="col-md-6"><b>Personal Email:</b> ${e.personal_email || '—'}</div>
                        <div class="col-md-6"><b>Gender:</b> ${e.gender || '—'}</div>
                        <div class="col-md-6"><b>DOB:</b> ${e.date_of_birth || '—'}</div>
                        <div class="col-md-6"><b>NIC:</b> ${e.national_id || '—'}</div>
                        <div class="col-md-6"><b>Joining Date:</b> ${e.joining_date || '—'}</div>
                        <div class="col-md-6"><b>Employment Type:</b> ${e.employment_type || '—'}</div>
                        <div class="col-md-6"><b>Employment Status:</b> ${e.employment_status || '—'}</div>
                        <div class="col-md-6"><b>Basic Salary:</b> ${e.basic_salary ? 'LKR ' + Number(e.basic_salary).toLocaleString() : '—'}</div>
                        <div class="col-md-6"><b>Bank:</b> ${e.bank_name || '—'} ${e.bank_branch ? '/ ' + e.bank_branch : ''}</div>
                        <div class="col-md-6"><b>Account No:</b> ${e.bank_account_number || '—'}</div>
                        <div class="col-md-6"><b>Qualification:</b> ${e.highest_qualification || '—'}</div>
                        <div class="col-md-6"><b>Field of Study:</b> ${e.field_of_study || '—'}</div>
                        <div class="col-12"><b>Address:</b> ${addr}</div>
                        <div class="col-md-6"><b>Emergency Contact:</b> ${e.emergency_contact_name || '—'} ${e.emergency_contact_phone ? '(' + e.emergency_contact_phone + ')' : ''} ${e.emergency_contact_relation ? '- ' + e.emergency_contact_relation : ''}</div>
                        <div class="col-12"><b>Notes:</b> ${e.notes || '—'}</div>
                    </div>`);
                        $('#viewEmployeeModal').modal('show');
                    }
                }
            });
        }

        function createUserForEmployee(id, first, last) {
            window.location.href = "{{ url('/system-users') }}?emp_id=" + id + "&first=" + encodeURIComponent(first) +
                "&last=" + encodeURIComponent(last);
        }
    </script>
@endsection

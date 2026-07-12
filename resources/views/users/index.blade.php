@extends('layouts.business')

@section('title')
    Manage Users
@endsection

@section('content')
    <style>
        .hover-shadow:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.2s ease-in-out;
        }

        #module_list ul {
            padding-left: 0;
            margin-top: 20px;
        }

        #module_list li {
            margin-bottom: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: #f9f9f9;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: .2s;
            cursor: pointer;
        }

        #module_list li:hover {
            background: #f0f4ff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        #module_list label {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        #module_list input[type="checkbox"] {
            accent-color: #0d6efd;
            transform: scale(1.2);
            margin: 0;
        }

        .employee-autofill-box {
            background: #f0f4ff;
            border: 1px solid #c7d2fe;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 12px;
            font-size: .82rem;
            color: #4338ca;
            display: none;
        }
    </style>

    <div class="row">
        <div class="col-sm-12" style="margin-top:-20px;margin-left:-20px;">
            <div class="card card-table show-entire">
                <div class="card-body">
                    <div class="page-table-header mb-2">
                        <div class="row align-items-center mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4>Manage Users</h4>
                                <button class="btn btn-primary" onclick="addNew()">Add New</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-stripped" id="data_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Level</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Add / Edit User Modal --}}
                    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="userForm">
                                    <div class="modal-body">
                                        @csrf
                                        <input type="hidden" id="id" name="id">
                                        <input type="hidden" id="employee_id" name="employee_id">

                                        <div class="mb-3" id="employee_select_wrap">
                                            <label>Link to Employee <span class="text-muted"
                                                    style="font-weight:400;font-size:.78rem;">(optional — auto-fills name &
                                                    email)</span></label>
                                            <select id="employee_select" class="form-control">
                                                <option value="">— Select Employee or fill manually —</option>
                                            </select>
                                        </div>

                                        <div class="employee-autofill-box" id="autofill_notice">
                                            <i class="fa fa-link me-2"></i>
                                            Name and email auto-filled from employee record. You can still edit below.
                                        </div>

                                        <div class="mb-3">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" id="first_name" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Last Name <span class="text-danger">*</span></label>
                                            <input type="text" name="last_name" id="last_name" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Level <span class="text-danger">*</span></label>
                                            <select name="level" id="level" class="form-control"></select>
                                        </div>

                                        <div class="mb-3">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Status</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="status"
                                                    name="status" checked>
                                                <label class="form-check-label" for="status">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="save()">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Permissions Modal --}}
                    <div class="modal fade" id="addUserModuleModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content rounded-4 shadow border-0">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="bi bi-person-gear me-2"></i>User Permissions</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="userPermissionForm">
                                    <input type="hidden" id="user_id" name="user_id">
                                    <div class="modal-body py-4 px-5" style="max-height:70vh;overflow-y:auto;">
                                        <p class="text-muted">Select which modules this user can access:</p>
                                        <ul style="list-style:none;">
                                            <li><label style="width:auto"><input class="check-modules" type="checkbox"
                                                        id="check-all"> Select All</label></li>
                                        </ul>
                                        <div id="module_list" class="row g-4"></div>
                                    </div>
                                    <div
                                        class="modal-footer bg-light rounded-bottom-4 px-4 py-3 d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary px-4 rounded-pill"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary px-4 rounded-pill"
                                            onclick="savePermissions()">
                                            <i class="bi bi-check-circle me-1"></i>Save Permissions
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endsection

                @section('scripts')
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        var saveMethod;
                        var table;

                        $(document).ready(function() {
                            saveMethod = "add";
                            loadData();
                        });

                        function loadData() {
                            let url = "{{ url('/get-users-data') }}";
                            if ($.fn.DataTable.isDataTable('#data_table')) $('#data_table').DataTable().destroy();

                            table = $('#data_table').DataTable({
                                stripeClasses: [],
                                lengthMenu: [5, 10, 20, 50],
                                pageLength: 50,
                                processing: true,
                                serverSide: true,
                                order: [
                                    [0, 'desc']
                                ],
                                ajax: {
                                    url: url
                                },
                                columns: [{
                                        data: 'DT_RowIndex',
                                        orderable: false,
                                        searchable: false
                                    },
                                    {
                                        data: 'first_name'
                                    },
                                    {
                                        data: 'last_name'
                                    },
                                    {
                                        data: 'level_name'
                                    },
                                    {
                                        data: 'email'
                                    },
                                    {
                                        data: 'status'
                                    },
                                    {
                                        data: 'action',
                                        orderable: false,
                                        searchable: false
                                    }
                                ],
                                rowCallback: function(row, data) {
                                    if (data.status == 1) {
                                        $(row).find('td:eq(5)').html(
                                            '<span style="background:#31f620;color:#050303;border-radius:5px;padding:2px 5px;">Active</span>'
                                            );
                                    } else {
                                        $(row).find('td:eq(5)').html(
                                            '<span style="background:#e00505;color:#fff;border-radius:5px;padding:2px 5px;">Inactive</span>'
                                            );
                                    }
                                }
                            });
                        }

                        function addNew() {
                            saveMethod = "add";
                            $("#userForm")[0].reset();
                            $("#id").val('');
                            $("#employee_id").val('');
                            $("#employee_select_wrap").show();
                            $("#autofill_notice").hide();
                            getMaster();
                            $("#addUserModal").modal('show');
                        }

                        function getMaster() {
                            $.ajax({
                                url: "{{ url('/system-users-master-data') }}",
                                type: 'GET',
                                dataType: 'JSON',
                                success: function(data) {
                                    $('#level').empty().append('<option value="">Select User Level</option>');
                                    $.each(data.user_level, function(k, v) {
                                        $('#level').append('<option value="' + v.id + '">' + v.code + '</option>');
                                    });

                                    $('#employee_select').empty().append(
                                        '<option value="">— Select Employee or fill manually —</option>');
                                    $.each(data.unlinked_employees, function(k, v) {
                                        $('#employee_select').append('<option value="' + v.id + '" data-first="' + v
                                            .first_name + '" data-last="' + v.last_name + '" data-email="' + (v
                                                .work_email || '') + '">' + v.first_name + ' ' + v.last_name +
                                            '</option>');
                                    });
                                }
                            });
                        }

                        $('#employee_select').on('change', function() {
                            let selected = $(this).find(':selected');
                            if ($(this).val()) {
                                $('#employee_id').val($(this).val());
                                $('#first_name').val(selected.data('first'));
                                $('#last_name').val(selected.data('last'));
                                $('#email').val(selected.data('email'));
                                $('#autofill_notice').show();
                            } else {
                                $('#employee_id').val('');
                                $('#first_name').val('');
                                $('#last_name').val('');
                                $('#email').val('');
                                $('#autofill_notice').hide();
                            }
                        });

                        function save() {
                            let url = saveMethod === "add" ?
                                "{{ url('/system-users-store') }}" :
                                "{{ url('/system-users-update') }}/" + $("#id").val();

                            let formData = $('#userForm').serialize() + '&_token=' + $('meta[name="csrf-token"]').attr('content');

                            $.ajax({
                                url: url,
                                type: "POST",
                                data: formData,
                                success: function(response) {
                                    if (response.success) {
                                        saveMethod = "add";
                                        Swal.fire({
                                                icon: 'success',
                                                title: 'Success!',
                                                text: response.message,
                                                confirmButtonText: 'OK'
                                            })
                                            .then(() => {
                                                $('#addUserModal').modal('hide');
                                                table.ajax.reload();
                                            });
                                    } else {
                                        let msg = response.errors ? '<ul style="text-align:left;">' + response.errors.map(e =>
                                            '<li>' + e + '</li>').join('') + '</ul>' : response.message;
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Validation Error',
                                            html: msg,
                                            confirmButtonText: 'Try Again'
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    let msg = xhr.responseJSON?.errors ? '<ul>' + xhr.responseJSON.errors.map(e => '<li>' + e +
                                        '</li>').join('') + '</ul>' : (xhr.responseJSON?.message || 'Unexpected error.');
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        html: msg
                                    });
                                }
                            });
                        }

                        function savePermissions() {
                            let formData = $('#userPermissionForm').serialize() + '&_token=' + $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: "{{ url('/system-users-store-permissions') }}",
                                type: "POST",
                                data: formData,
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                                icon: 'success',
                                                title: 'Success!',
                                                text: 'Permissions saved!'
                                            })
                                            .then(() => {
                                                $('#addUserModuleModal').modal('hide');
                                                table.ajax.reload();
                                            });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: response.message
                                        });
                                    }
                                }
                            });
                        }

                        function editInfo(id) {
                            saveMethod = "update";
                            $("#employee_select_wrap").hide();
                            $("#autofill_notice").hide();
                            getMaster();

                            $.ajax({
                                url: "{{ url('/get-user-details') }}/" + id,
                                type: "GET",
                                dataType: "json",
                                success: function(response) {
                                    if (response.success) {
                                        let u = response.data;
                                        $('#id').val(id);
                                        $('#first_name').val(u.first_name);
                                        $('#last_name').val(u.last_name);
                                        $('#email').val(u.email);
                                        $('#status').prop('checked', u.status == 1);
                                        setTimeout(function() {
                                            $('#level').val(u.level);
                                        }, 400);
                                        $('#addUserModal').modal('show');
                                    }
                                }
                            });
                        }

                        function permissionInfo(id) {
                            $.ajax({
                                url: "{{ url('/get-user-module-details') }}/" + id,
                                type: "GET",
                                dataType: "json",
                                success: function(response) {
                                    if (response.success) {
                                        $('#user_id').val(id);
                                        $(".check-modules").prop("checked", false);
                                        $('#module_list').html('');

                                        let html = "<div class='row'>";
                                        let perCol = Math.ceil(response.modules.length / 4);
                                        for (let j = 0; j < response.modules.length; j++) {
                                            if (j % perCol === 0) {
                                                if (j !== 0) html += "</ul></div>";
                                                html += "<div class='col-md-3'><ul style='list-style:none;'>";
                                            }
                                            html +=
                                                "<li><label style='width:auto'><input class='check-modules' type='checkbox' value='" +
                                                response.modules[j].id + "' id='val_" + response.modules[j].id +
                                                "' name='modules[]'> " + response.modules[j].name + "</label></li>";
                                        }
                                        html += "</ul></div></div>";
                                        $('#module_list').append(html);

                                        response.permissions.forEach(p => {
                                            $("#val_" + p.module).prop("checked", true);
                                        });
                                        $('#addUserModuleModal').modal('show');
                                    }
                                }
                            });
                        }

                        document.getElementById('check-all').addEventListener('change', function() {
                            document.querySelectorAll('.check-modules').forEach(chk => chk.checked = this.checked);
                        });
                    </script>
                @endsection

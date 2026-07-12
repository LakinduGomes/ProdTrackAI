@extends('layouts.business')
@section('title')
    Audit Log
@endsection
@section('content')
    <style>
        body,
        .content-wrapper {
            background: #f8fafc !important;
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
            color: #64748b;
            font-size: .82rem;
            margin-top: 2px;
        }

        .card-pt {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 18px;
            padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        .filter-bar {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            font-size: .82rem;
            border: 1px solid #e2e8f0;
        }

        .form-label {
            font-size: .75rem;
            font-weight: 600;
            color: #374151;
        }
    </style>

    <div class="pt-page">
        <div class="mb-4">
            <div class="pt-title"><i class="fas fa-history me-2 text-primary"></i>Audit Log</div>
            <div class="pt-sub">Complete activity trail — every action recorded</div>
        </div>

        {{-- Filters --}}
        <div class="filter-bar">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Module</label>
                    <select id="filter_module" class="form-select form-select-sm">
                        <option value="">All Modules</option>
                        <option value="Tasks">Tasks</option>
                        <option value="Employees">Employees</option>
                        <option value="Users">Users</option>
                        <option value="Auth">Auth (Login/Logout)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Action</label>
                    <select id="filter_action" class="form-select form-select-sm">
                        <option value="">All Actions</option>
                        <option value="CREATE">Create</option>
                        <option value="UPDATE">Update</option>
                        <option value="DELETE">Delete</option>
                        <option value="STATUS_CHANGE">Status Change</option>
                        <option value="LOGIN">Login</option>
                        <option value="LOGOUT">Logout</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date From</label>
                    <input type="date" id="filter_date_from" class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date To</label>
                    <input type="date" id="filter_date_to" class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <button onclick="applyFilters()" class="btn btn-primary btn-sm w-100" style="border-radius:8px;">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="card-pt">
            <div class="table-responsive">
                <table class="table table-stripped" id="audit_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Module</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Date & Time</th>
                            <th>Changes</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- Changes Modal --}}
    <div class="modal fade" id="changesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content" style="border-radius:16px;border:none;">
                <div class="modal-header">
                    <h5 class="modal-title">Change Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="changesBody">Loading...</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var auditTable;

        $(document).ready(function() {
            loadTable();
        });

        function loadTable(filters = {}) {
            if ($.fn.DataTable.isDataTable('#audit_table')) $('#audit_table').DataTable().destroy();

            auditTable = $('#audit_table').DataTable({
                stripeClasses: [],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 25,
                processing: true,
                serverSide: true,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: "{{ url('/audit-log-data') }}",
                    data: function(d) {
                        d.module = $('#filter_module').val();
                        d.action = $('#filter_action').val();
                        d.date_from = $('#filter_date_from').val();
                        d.date_to = $('#filter_date_to').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_name',
                        render: d => d || '<span style="color:#94a3b8;">System</span>'
                    },
                    {
                        data: 'action_badge',
                        orderable: false
                    },
                    {
                        data: 'module'
                    },
                    {
                        data: 'description',
                        render: d => `<span style="font-size:.8rem;">${d || '—'}</span>`
                    },
                    {
                        data: 'ip_address',
                        render: d => d || '—'
                    },
                    {
                        data: 'created_at',
                        render: d => `<span style="font-size:.78rem;color:#64748b;">${d}</span>`
                    },
                    {
                        data: 'changes',
                        orderable: false,
                        searchable: false
                    }
                ],
                rowCallback: function(row, data) {
                    if (data.action === 'DELETE') {
                        $(row).css('background', '#fff5f5');
                    } else if (data.action === 'LOGIN') {
                        $(row).css('background', '#f0fdf4');
                    }
                }
            });
        }

        function applyFilters() {
            if (auditTable) auditTable.ajax.reload();
        }

        function viewChanges(id) {
            $.ajax({
                url: "{{ url('/audit-log-details') }}/" + id,
                success: function(res) {
                    if (res.success) {
                        let d = res.data;
                        let old = d.old_values ? JSON.stringify(d.old_values, null, 2) : null;
                        let nw = d.new_values ? JSON.stringify(d.new_values, null, 2) : null;

                        let html = `<div class="mb-3">
                    <strong>Action:</strong> ${d.action} &nbsp;|&nbsp;
                    <strong>Module:</strong> ${d.module} &nbsp;|&nbsp;
                    <strong>By:</strong> ${d.user_name || 'System'}
                </div>
                <div class="mb-2"><strong>Description:</strong> ${d.description || '—'}</div>`;

                        if (old) {
                            html += `<div class="mb-2">
                        <strong>Before:</strong>
                        <pre style="background:#fee2e2;border-radius:8px;padding:.75rem;font-size:.75rem;max-height:200px;overflow-y:auto;">${old}</pre>
                    </div>`;
                        }
                        if (nw) {
                            html += `<div class="mb-2">
                        <strong>After:</strong>
                        <pre style="background:#dcfce7;border-radius:8px;padding:.75rem;font-size:.75rem;max-height:200px;overflow-y:auto;">${nw}</pre>
                    </div>`;
                        }

                        $('#changesBody').html(html);
                        $('#changesModal').modal('show');
                    }
                }
            });
        }
    </script>
@endsection

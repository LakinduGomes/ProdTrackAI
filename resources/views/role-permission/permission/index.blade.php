@extends('layouts.business')

@section('title')
@endsection

@section('content')
    <style>
        /* Basic tab styles */
        .nav-tabs .nav-link {
            border: 2px solid transparent;
            border-radius: 5px;
            padding: 10px 20px;
            background-color: #f8f9fa;
            color: #007bff;
            position: relative;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
            box-shadow: 0 4px 6px rgba(0, 123, 255, 0.3);
        }

        .nav-tabs .nav-link:hover {
            background-color: #e7f1ff;
            border-color: #007bff;
            color: #007bff;
        }

        .nav-tabs .nav-link::before {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            background: #007bff;
            bottom: 0;
            left: 50%;
            transition: width 0.4s ease, left 0.4s ease;
        }

        .nav-tabs .nav-link.active::before {
            width: 100%;
            left: 0;
        }

        .nav-tabs .nav-link:hover::before {
            width: 50%;
            left: 25%;
        }
    </style>

    <div class="row">
        <div class="col-sm-12" style="margin-top: -20px; margin-left: -20px;">
            <div class="card card-table show-entire">
                <div class="card-body">

                    <div class="page-table-header mb-2">
                        <div class="row align-items-center mb-2">
                            <div class="col">
                                <div class="doctor-table-blk">
                                    <h3 class="text-uppercase">User Permission</h3>
                                </div>
                            </div>
                            <div class="col-auto text-end float-end ms-auto download-grp">
                                <a href="#" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#formModal">
                                    +&nbsp;Add New Permission
                                </a>
                            </div>
                        </div>
                    </div>

                    @if (Auth::user()->is_admin == 1)

                        <div class="staff-search-table">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 ml-2 mr-2">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                        <div class="input-block local-forms ">
                                            <label>Users</label>
                                            <select class="form-control select2 users" name="users" id="users">
                                                <option value="">All Users</option>
                                                @foreach ($users as $item)
                                                    <option value="{{ $item->id }}">{{ Str::limit($item->first_name.' '.$item->last_name,30) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                        <div class="input-block local-forms ">
                                            <label>Select status </label>
                                            <select class="form-control select2" id="status" name="status">
                                                <option value="">Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <small class="text-danger font-weight-bold err_status"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-stripped " id="data_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th class="text-end"></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="{{ url('permissions') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12" style="margin-top: -10px;">
                                <div class="card mb-12" style="border: 2px solid #007bff;">
                                    <br>
                                    <div class="card-body" style="margin-top: -30px;">
                                        <div class="row mt-2">
                                            <div class="col-md-12 d-flex align-items-center">
                                                <label class="mr-2" for="name">Permission Name</label>
                                                <input type="text" id="name" name="name" class="form-control" placeholder="Permission Name" style="margin-left: 20px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        @endsection
        @section('scripts')

            <script>
                $(document).ready(function() {
                    $('#formModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                });

            </script>
            <script>
                var table;

                $(document).ready(function() {
                    loadData()
                });

                function loadData() {
                    table = $('#data_table').DataTable({
                        "stripeClasses": [],
                        "lengthMenu": [5,10, 20, 50],
                        "pageLength": 5,
                        processing: true,
                        serverSide: true,
                        orderable: false,
                        ajax: {
                            url: "{{ route('permissions.index', ['json' => 1]) }}",
                            data: function(d) {
                                d.user = $('#users').val();
                                d.status = $('#status').val();
                            }
                        },
                        columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                            {
                                data: 'name',
                                name: 'name',
                                orderable: false,
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ]
                    });
                }

                $('#users').change(function(e) {
                    e.preventDefault();

                    table.clear();
                    table.ajax.reload();
                    table.draw();

                });

                $('#status').change(function(e) {
                    e.preventDefault();

                    table.clear();
                    table.ajax.reload();
                    table.draw();
                });

                function deleteConfirmation(id) {
                    $.confirm({
                        theme: 'modern',
                        columnClass: 'col-lg-6 col-md-8 col-sm-10 col-12',
                        icon: 'far fa-question-circle text-danger',
                        title: 'Are you Sure!',
                        content: 'Do you want to Delete the Selected Category?',
                        type: 'red',
                        autoClose: 'cancel|10000',
                        buttons: {
                            confirm: {
                                text: 'Yes',
                                btnClass: 'btn-green',
                                action: function() {
                                    $("#loader").show();
                                    var data = {
                                        "_token": $('input[name=_token]').val(),
                                        "id": id,
                                    }
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('business.category.delete') }}",
                                        data: data,
                                        success: function(response) {
                                            $("#loader").hide();
                                            table.clear();
                                            table.ajax.reload();
                                            table.draw();
                                        },
                                        statusCode: {
                                            401: function() {
                                                window.location.href =
                                                    '{{ route('login') }}'; //or what ever is your login URI
                                            },
                                            419: function() {
                                                window.location.href =
                                                    '{{ route('login') }}'; //or what ever is your login URI
                                            },
                                        },
                                        error: function(data) {
                                            someThingWrong();
                                        }
                                    });
                                }
                            },

                            cancel: {
                                text: 'Cancel',
                                btnClass: 'btn-red',
                                action: function() {

                                }
                            },
                        }
                    });
                }


            </script>
@endsection

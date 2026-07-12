@extends('layouts.business')

@section('content')
<div class="row">
    <div class="col-sm-12" style="margin-top: -20px; margin-left: -20px;">
        <div class="card card-table show-entire shadow-lg rounded-4 border-0">
            <div class="card-body">

                <div class="page-table-header mb-3">
                    <div class="row align-items-center mb-2">
                        <div class="col">
                            <h3 class="text-uppercase">User Roles</h3>
                        </div>
                        <div class="col-auto text-end ms-auto">
                            <a href="javascript:;" class="btn btn-primary" onclick="addNewUser()">
                                <i class="fas fa-plus me-1"></i> Add User
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="roles_table">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Modules Access</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $users = [
                                ['name'=>'Kamal Perera','email'=>'kamal@domain.com','role'=>'Admin','modules'=>'Visitors, Invites, System Config'],
                                ['name'=>'Chandani Fernando','email'=>'chandani@domain.com','role'=>'Staff','modules'=>'Visitors, Gate View'],
                                ['name'=>'Ruwan Jayasuriya','email'=>'ruwan@domain.com','role'=>'Manager','modules'=>'Visitors, Invites, Reports'],
                            ];
                            @endphp
                            @foreach($users as $index => $u)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $u['name'] }}</td>
                                <td>{{ $u['email'] }}</td>
                                <td><span class="badge bg-primary">{{ $u['role'] }}</span></td>
                                <td>{{ $u['modules'] }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-icon text-dark me-1" onclick="viewUser({{ $index }})" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon text-dark me-1" onclick="editUser({{ $index }})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon text-dark" onclick="deleteUser({{ $index }})" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Add/Edit User Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-4 animate__animated animate__fadeInDown">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="user_form">
                <input type="hidden" id="user_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" id="user_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" id="user_email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select id="user_role" class="form-control">
                                <option value="Admin">Admin</option>
                                <option value="Manager">Manager</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Modules Access</label>
                            <select id="user_modules" class="form-control" multiple>
                                <option value="Visitors">Visitors</option>
                                <option value="Invites">Invites</option>
                                <option value="Gate View">Gate View</option>
                                <option value="System Config">System Config</option>
                                <option value="Reports">Reports</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveUser()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4 animate__animated animate__fadeInDown">
      <div class="modal-header bg-gradient-primary text-black rounded-top-4">
        <h5 class="modal-title">User Details</h5>
        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-md-6"><small class="text-muted">Name</small><div id="v_user_name" class="fw-semibold"></div></div>
          <div class="col-md-6"><small class="text-muted">Email</small><div id="v_user_email" class="fw-semibold"></div></div>
          <div class="col-md-6"><small class="text-muted">Role</small><div id="v_user_role" class="badge bg-primary"></div></div>
          <div class="col-md-6"><small class="text-muted">Modules Access</small><div id="v_user_modules" class="fw-semibold"></div></div>
        </div>
      </div>
      <div class="modal-footer border-0 justify-content-end">
        <button class="btn btn-light rounded-3" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script>
let users = [
    {name:'Kamal Perera', email:'kamal@domain.com', role:'Admin', modules:['Visitors','Invites','System Config']},
    {name:'Chandani Fernando', email:'chandani@domain.com', role:'Staff', modules:['Visitors','Gate View']},
    {name:'Ruwan Jayasuriya', email:'ruwan@domain.com', role:'Manager', modules:['Visitors','Invites','Reports']},
];

function renderTable(){
    const table = $('#roles_table').DataTable();
    table.clear();
    users.forEach((u,i)=>{
        table.row.add([
            i+1,
            u.name,
            u.email,
            `<span class="badge bg-primary">${u.role}</span>`,
            u.modules.join(', '),
            `<button class="btn btn-sm p-0 text-dark me-1" onclick="viewUser(${i})"><i class="fas fa-eye"></i></button>
             <button class="btn btn-sm p-0 text-dark me-1" onclick="editUser(${i})"><i class="fas fa-edit"></i></button>
             <button class="btn btn-sm p-0 text-dark" onclick="deleteUser(${i})"><i class="fas fa-trash-alt"></i></button>`
        ]);
    });
    table.draw();
}

$(document).ready(function(){
    $('#roles_table').DataTable({responsive:true, pageLength:5, lengthChange:false, dom:'lrtip'});
    renderTable();
});

function showUserSuccess(message='User saved successfully!', type='success'){
    Swal.fire({
        toast:true, position:'top-end', icon:type, title:message,
        showConfirmButton:false, timer:2000, timerProgressBar:true,
        background:type=='success' ? 'linear-gradient(135deg,#4CAF50,#81C784)' : 'linear-gradient(135deg,#EF5350,#E57373)',
        color:'#fff',
        showClass:{popup:'animate__animated animate__fadeInRight'},
        hideClass:{popup:'animate__animated animate__fadeOutRight'}
    });
}

function addNewUser(){
    $('#user_id').val(''); $('#user_name').val(''); $('#user_email').val(''); $('#user_role').val('Admin'); $('#user_modules').val([]);
    $('#userModal .modal-title').text('Add User');
    $('#userModal').modal('show');
}

function viewUser(id){
    const u = users[id];
    $('#v_user_name').text(u.name); $('#v_user_email').text(u.email);
    $('#v_user_role').text(u.role); $('#v_user_modules').text(u.modules.join(', '));
    $('#viewUserModal').modal('show');
}

function editUser(id){
    const u = users[id];
    $('#user_id').val(id); $('#user_name').val(u.name); $('#user_email').val(u.email);
    $('#user_role').val(u.role); $('#user_modules').val(u.modules);
    $('#userModal .modal-title').text('Edit User');
    $('#userModal').modal('show');
}

function deleteUser(id){
    Swal.fire({
        title:'Are you sure?', text:'This user will be deleted!', icon:'warning',
        showCancelButton:true, confirmButtonText:'Yes, delete it!', cancelButtonText:'Cancel'
    }).then((result)=>{
        if(result.isConfirmed){
            users.splice(id,1); renderTable();
            showUserSuccess('User deleted successfully!','error');
        }
    });
}

function saveUser(){
    const id = $('#user_id').val();
    const newUser = {
        name:$('#user_name').val(),
        email:$('#user_email').val(),
        role:$('#user_role').val(),
        modules:$('#user_modules').val()
    };
    if(id !== ''){
        users[id] = newUser;
        showUserSuccess('User updated successfully!');
    } else {
        users.push(newUser);
        showUserSuccess();
    }
    $('#userModal').modal('hide');
    renderTable();
}
</script>
@endsection

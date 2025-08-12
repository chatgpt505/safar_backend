@extends('adminlte::page')

@section('title', 'User Management - Safar Backend')

@section('content_header')
    <h1>User Management</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Users</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createUserModal">
                        <i class="fas fa-plus mr-1"></i> Add User
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th style="width:280px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                                <tr>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>
                                        <span class="badge badge-secondary">{{ ucfirst($u->role) }}</span>
                                        <button type="button" class="btn btn-xs btn-outline-primary ml-1" 
                                                onclick="changeUserRole('{{ $u->_id }}', '{{ $u->role }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        @if($u->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $u->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    onclick="toggleUserStatus('{{ $u->_id }}', '{{ $u->name }}')">
                                                <i class="fas fa-exchange-alt mr-1"></i> Toggle
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary" 
                                                    onclick="resetUserPassword('{{ $u->_id }}', '{{ $u->name }}')">
                                                <i class="fas fa-key mr-1"></i> Reset
                                            </button>
                                            @if($u->role !== 'admin' || $u->_id !== auth()->id())
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="deleteUser('{{ $u->_id }}', '{{ $u->name }}')">
                                                <i class="fas fa-trash mr-1"></i> Delete
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if(method_exists($users, 'links'))
                <div class="card-footer clearfix">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('dashboard.users.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New User</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone (Optional)</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Role Modal -->
<div class="modal fade" id="changeRoleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="changeRoleForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Change User Role</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_role">New Role</label>
                        <select class="form-control" id="new_role" name="role" required>
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Change Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
function toggleUserStatus(userId, userName) {
    if (confirm(`Toggle status for ${userName}?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('dashboard.users.toggle', '') }}/${userId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

function resetUserPassword(userId, userName) {
    if (confirm(`Reset password for ${userName}?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('dashboard.users.reset', '') }}/${userId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const passwordField = document.createElement('input');
        passwordField.type = 'hidden';
        passwordField.name = 'new_password';
        passwordField.value = 'password123';
        
        form.appendChild(csrfToken);
        form.appendChild(passwordField);
        document.body.appendChild(form);
        form.submit();
    }
}

function deleteUser(userId, userName) {
    if (confirm(`Delete ${userName}? This action cannot be undone.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('dashboard.users.delete', '') }}/${userId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

function changeUserRole(userId, currentRole) {
    document.getElementById('new_role').value = currentRole;
    document.getElementById('changeRoleForm').action = `{{ route('dashboard.users.update', '') }}/${userId}`;
    $('#changeRoleModal').modal('show');
}
</script>
@stop



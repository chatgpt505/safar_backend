@extends('adminlte::page')

@section('title', 'Role Management - Safar Backend')

@section('content_header')
    <h1>Role Management</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Roles</h3>
                <div class="card-tools">
                    <a href="{{ route('dashboard.roles.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Create Role
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                                <th>Users</th>
                                <th>Status</th>
                                <th style="width:200px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>
                                        <code>{{ $role->name }}</code>
                                    </td>
                                    <td>{{ $role->display_name }}</td>
                                    <td>{{ $role->description ?: 'No description' }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $role->users_count }}</span>
                                    </td>
                                    <td>
                                        @if($role->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dashboard.roles.show', $role) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye mr-1"></i> View
                                            </a>
                                            <a href="{{ route('dashboard.roles.edit', $role) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            @if(!in_array($role->name, ['admin', 'moderator', 'user']))
                                                <button type="button" class="btn btn-sm btn-secondary" 
                                                        onclick="toggleRoleStatus('{{ $role->id }}', '{{ $role->name }}')">
                                                    <i class="fas fa-exchange-alt mr-1"></i> Toggle
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        onclick="deleteRole('{{ $role->id }}', '{{ $role->name }}')">
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
            @if(method_exists($roles, 'links'))
                <div class="card-footer clearfix">
                    {{ $roles->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Permissions Overview -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Available Permissions</h3>
            </div>
            <div class="card-body">
                @foreach($permissions as $group => $groupPermissions)
                    <div class="mb-4">
                        <h5 class="text-capitalize">{{ $group }}</h5>
                        <div class="row">
                            @foreach($groupPermissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <span class="badge badge-secondary">{{ $permission->display_name }}</span>
                                    <small class="text-muted d-block">{{ $permission->name }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
function toggleRoleStatus(roleId, roleName) {
    if (confirm(`Toggle status for role "${roleName}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('dashboard.roles.toggle', '') }}/${roleId}`;
        
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

function deleteRole(roleId, roleName) {
    if (confirm(`Delete role "${roleName}"? This action cannot be undone.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('dashboard.roles.destroy', '') }}/${roleId}`;
        
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
</script>
@stop

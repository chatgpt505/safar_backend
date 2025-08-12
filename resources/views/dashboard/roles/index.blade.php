@extends('layouts.app')

@section('title', 'Role Management - Safar Backend')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Role Management</h1>
        <a href="{{ route('dashboard.roles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            <i class="fas fa-plus mr-2"></i> Create Role
        </a>
    </div>

    <!-- Roles Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Display Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($roles as $role)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $role->name }}</code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $role->display_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $role->description ?: 'No description' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $role->users_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($role->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('dashboard.roles.show', $role) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                <a href="{{ route('dashboard.roles.edit', $role) }}" 
                                   class="text-yellow-600 hover:text-yellow-800">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                @if(!in_array($role->name, ['admin', 'moderator', 'user']))
                                    <button type="button" class="text-gray-600 hover:text-gray-800" 
                                            onclick="toggleRoleStatus('{{ $role->id }}', '{{ $role->name }}')">
                                        <i class="fas fa-exchange-alt mr-1"></i> Toggle
                                    </button>
                                    <button type="button" class="text-red-600 hover:text-red-800" 
                                            onclick="deleteRole('{{ $role->id }}', '{{ $role->name }}')">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(method_exists($roles, 'links'))
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $roles->links() }}
            </div>
        @endif
    </div>

    <!-- Permissions Overview -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Available Permissions</h3>
        @foreach($permissions as $group => $groupPermissions)
            <div class="mb-6">
                <h4 class="text-md font-medium text-gray-900 mb-3 capitalize">{{ $group }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($groupPermissions as $permission)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-sm text-gray-700">{{ $permission->display_name ?: $permission->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
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
@endpush
@endsection

@extends('layouts.app')

@section('title', 'User Management - Safar Backend')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
        <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium" 
                onclick="document.getElementById('createUserModal').classList.remove('hidden')">
            <i class="fas fa-plus mr-1"></i> Add User
        </button>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $u)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $u->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($u->role) }}
                                </span>
                                <button type="button" class="ml-1 text-blue-600 hover:text-blue-800" 
                                        onclick="changeUserRole('{{ $u->_id }}', '{{ $u->role }}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($u->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button type="button" class="text-yellow-600 hover:text-yellow-800" 
                                        onclick="toggleUserStatus('{{ $u->_id }}', '{{ $u->name }}')">
                                    <i class="fas fa-exchange-alt mr-1"></i> Toggle
                                </button>
                                <button type="button" class="text-gray-600 hover:text-gray-800" 
                                        onclick="resetUserPassword('{{ $u->_id }}', '{{ $u->name }}')">
                                    <i class="fas fa-key mr-1"></i> Reset
                                </button>
                                @if($u->role !== 'admin' || $u->_id !== auth()->id())
                                <button type="button" class="text-red-600 hover:text-red-800" 
                                        onclick="deleteUser('{{ $u->_id }}', '{{ $u->name }}')">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(method_exists($users, 'links'))
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Create User Modal -->
<div id="createUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Create New User</h3>
            <form action="{{ route('dashboard.users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                           id="name" name="name" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                           id="email" name="email" required>
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone (Optional)</label>
                    <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                           id="phone" name="phone">
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                            id="role" name="role" required>
                        <option value="user">User</option>
                        <option value="moderator">Moderator</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                           id="password" name="password" required>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                           id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium" 
                            onclick="document.getElementById('createUserModal').classList.add('hidden')">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Role Modal -->
<div id="changeRoleModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Change User Role</h3>
            <form id="changeRoleForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="new_role" class="block text-sm font-medium text-gray-700">New Role</label>
                    <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                            id="new_role" name="role" required>
                        <option value="user">User</option>
                        <option value="moderator">Moderator</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium" 
                            onclick="document.getElementById('changeRoleModal').classList.add('hidden')">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Change Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
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
    document.getElementById('changeRoleModal').classList.remove('hidden');
}
</script>
@endpush
@endsection



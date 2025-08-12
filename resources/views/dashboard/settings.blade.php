@extends('layouts.app')

@section('title', 'Settings - Safar Backend')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Settings</h2>
        
        <div class="space-y-6">
            <!-- API Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">API Information</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">Base URL for API requests:</p>
                    <code class="bg-white px-2 py-1 rounded text-sm font-mono">http://localhost:8000/api</code>
                    
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 mb-2">Authentication:</p>
                        <p class="text-sm text-gray-900">Use Bearer token authentication. Include the token in the Authorization header:</p>
                        <code class="bg-white px-2 py-1 rounded text-sm font-mono">Authorization: Bearer {your_token}</code>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ url('api/documentation') }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-book mr-2"></i>
                            View API Documentation
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- System Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Framework</p>
                            <p class="text-sm text-gray-900">Laravel {{ app()->version() }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Database</p>
                            <p class="text-sm text-gray-900">MongoDB</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Authentication</p>
                            <p class="text-sm text-gray-900">Laravel Sanctum</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">API Documentation</p>
                            <p class="text-sm text-gray-900">Swagger UI</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Links</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('dashboard.profile') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-user text-blue-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900">Profile</p>
                            <p class="text-sm text-gray-600">View and edit your profile</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('change-password') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-key text-green-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900">Change Password</p>
                            <p class="text-sm text-gray-600">Update your password</p>
                        </div>
                    </a>
                    
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('dashboard.admin') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-crown text-purple-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900">Admin Panel</p>
                            <p class="text-sm text-gray-600">Administrative tools</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('dashboard.users') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-users text-yellow-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900">User Management</p>
                            <p class="text-sm text-gray-600">Manage all users</p>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

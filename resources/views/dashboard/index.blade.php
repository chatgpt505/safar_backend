@extends('layouts.app')

@section('title', 'Dashboard - Safar Backend')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ $user->name }}!</h1>
                <p class="text-gray-600">Role: {{ ucfirst($user->role) }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-check text-green-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-crown text-purple-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Admins</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['admin_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Moderators</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['moderator_users'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('dashboard.profile') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-user text-blue-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">View Profile</p>
                    <p class="text-sm text-gray-600">Update your information</p>
                </div>
            </a>

            <a href="{{ route('dashboard.settings') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-cog text-gray-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Settings</p>
                    <p class="text-sm text-gray-600">Manage your preferences</p>
                </div>
            </a>

            <a href="{{ url('api/documentation') }}" target="_blank" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-book text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">API Documentation</p>
                    <p class="text-sm text-gray-600">View API endpoints</p>
                </div>
            </a>
        </div>
    </div>

    @if($user->isAdmin())
    <!-- Admin Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Admin Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('dashboard.admin') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-crown text-purple-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Admin Panel</p>
                    <p class="text-sm text-gray-600">Advanced administration tools</p>
                </div>
            </a>

            <a href="{{ route('dashboard.users') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-users text-blue-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">User Management</p>
                    <p class="text-sm text-gray-600">Manage all users</p>
                </div>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@extends('adminlte::page')

@section('title', 'Change Password - Safar Backend')
@section('content_header')
    <h1>Change Password</h1>
@endsection

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Change Password</h1>
        
        <form method="POST" action="{{ route('change-password') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                <input id="current_password" name="current_password" type="password" required 
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('current_password') border-red-500 @enderror"
                       placeholder="Enter your current password">
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input id="new_password" name="new_password" type="password" required 
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('new_password') border-red-500 @enderror"
                       placeholder="Enter your new password">
                @error('new_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                <input id="new_password_confirmation" name="new_password_confirmation" type="password" required 
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                       placeholder="Confirm your new password">
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('dashboard.profile') }}" class="text-sm text-blue-600 hover:text-blue-500">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back to Profile
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-key mr-2"></i>
                    Change Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.tailwindcss.com"></script>
@endsection

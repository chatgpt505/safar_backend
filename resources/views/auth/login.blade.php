@extends('layouts.app')

@section('title', 'Login - Safar Backend')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <i class="fas fa-plane text-blue-600 text-4xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Sign in to Safar Backend</h2>
                <p class="text-gray-600 mb-6">Enter your credentials to access your account</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                           placeholder="Enter your email" value="{{ old('email') }}" autofocus>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                           placeholder="Enter your password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center space-y-2">
                <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    <i class="fas fa-key mr-1"></i>
                    Forgot your password?
                </a>
                <div>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-user-plus mr-1"></i>
                        Don't have an account? Register
                    </a>
                </div>
            </div>

            <!-- Demo Credentials Info -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h6 class="text-center font-semibold text-gray-700 mb-3">Demo Credentials</h6>
                <div class="grid grid-cols-1 gap-2 text-sm">
                    <div class="flex justify-between">
                        <span class="font-medium">Admin:</span>
                        <span class="text-gray-600">admin@safar.com / admin123</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">User:</span>
                        <span class="text-gray-600">user@safar.com / user123</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Moderator:</span>
                        <span class="text-gray-600">moderator@safar.com / moderator123</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
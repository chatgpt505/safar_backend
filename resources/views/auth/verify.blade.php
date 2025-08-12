@extends('layouts.app')

@section('title', 'Email Verification - Safar Backend')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <i class="fas fa-envelope text-blue-600 text-4xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Verify Your Email</h2>
                <p class="text-gray-600 mb-6">
                    Before proceeding, please check your email for a verification link.
                </p>
                
                @if (session('resent'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.resend') }}" class="space-y-4">
                    @csrf
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Resend Verification Email
                    </button>
                </form>

                <div class="mt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-sign-out-alt mr-1"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
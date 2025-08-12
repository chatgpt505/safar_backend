<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login']);
    Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register']);
    
    // Password reset routes (for AdminLTE compatibility)
    Route::get('/password/reset', function () {
        return redirect()->route('login')->with('info', 'Please contact an administrator to reset your password.');
    })->name('password.request');
    
    Route::post('/password/email', function () {
        return redirect()->route('login')->with('info', 'Please contact an administrator to reset your password.');
    })->name('password.email');
    
    Route::get('/password/reset/{token}', function () {
        return redirect()->route('login')->with('info', 'Please contact an administrator to reset your password.');
    })->name('password.reset');
    
    Route::post('/password/reset', function () {
        return redirect()->route('login')->with('info', 'Please contact an administrator to reset your password.');
    })->name('password.update');
});

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
    
    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users');
        Route::post('/dashboard/users', [DashboardController::class, 'store'])->name('dashboard.users.store');
        Route::patch('/dashboard/users/{id}', [DashboardController::class, 'update'])->name('dashboard.users.update');
        Route::patch('/dashboard/users/{id}/toggle-status', [DashboardController::class, 'toggleUserStatusWeb'])->name('dashboard.users.toggle');
        Route::post('/dashboard/users/{id}/reset-password', [DashboardController::class, 'resetUserPasswordWeb'])->name('dashboard.users.reset');
        Route::delete('/dashboard/users/{id}', [DashboardController::class, 'deleteUserWeb'])->name('dashboard.users.delete');
        
        // Role management routes
        Route::resource('dashboard/roles', RoleController::class, ['as' => 'dashboard']);
        Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('dashboard.profile');
        Route::get('/dashboard/settings', [SettingsController::class, 'index'])->name('dashboard.settings');
        Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('dashboard.admin');
        Route::get('/dashboard/users', [UserController::class, 'index'])->name('dashboard.users');

        Route::patch('/dashboard/roles/{role}/toggle-status', [RoleController::class, 'toggleStatus'])->name('dashboard.roles.toggle');
    });
    
    // Authentication routes
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
    Route::get('/change-password', [WebAuthController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [WebAuthController::class, 'changePassword']);
});

// Swagger UI route - handled by L5-Swagger package

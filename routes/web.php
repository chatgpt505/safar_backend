<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

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
    
    // Password reset routes
    Route::get('/password/reset', function () {
        return view('auth.passwords.email');
    })->name('password.request');
    
    Route::post('/password/email', function () {
        return redirect()->route('login')->with('success', 'Password reset link sent to your email.');
    })->name('password.email');
    
    Route::get('/password/reset/{token}', function ($token) {
        return view('auth.passwords.reset', ['token' => $token]);
    })->name('password.reset');
    
    Route::post('/password/reset', function () {
        return redirect()->route('login')->with('success', 'Password has been reset successfully.');
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
        Route::patch('/dashboard/roles/{role}/toggle-status', [RoleController::class, 'toggleStatus'])->name('dashboard.roles.toggle');
    });
    
    // Sample CRUD routes
    Route::resource('dashboard/products', ProductController::class, ['as' => 'dashboard']);
    Route::resource('dashboard/categories', CategoryController::class, ['as' => 'dashboard']);
    Route::resource('dashboard/orders', OrderController::class, ['as' => 'dashboard']);
    
    // Authentication routes
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
    Route::get('/change-password', [WebAuthController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [WebAuthController::class, 'changePassword']);
    
    // Password confirmation route
    Route::get('/password/confirm', function () {
        return view('auth.passwords.confirm');
    })->name('password.confirm');
    
    Route::post('/password/confirm', function () {
        return redirect()->intended();
    })->name('password.confirm');
});

// Auto-generated Swagger documentation routes
Route::get('/api/documentation/auto', [App\Http\Controllers\AutoSwaggerController::class, 'ui'])->name('api.documentation.auto');
Route::get('/api/documentation/auto.json', [App\Http\Controllers\AutoSwaggerController::class, 'json'])->name('api.documentation.auto.json');
Route::get('/api/documentation/auto.yaml', [App\Http\Controllers\AutoSwaggerController::class, 'yaml'])->name('api.documentation.auto.yaml');

// Test route to generate and view auto documentation
Route::get('/test-auto-swagger', function () {
    $swaggerService = app(\App\Services\AutoSwaggerService::class);
    $documentation = $swaggerService->generateDocumentation();
    
    return response()->json([
        'message' => 'Auto-generated Swagger documentation test',
        'total_endpoints' => count($documentation['paths']),
        'endpoints' => array_keys($documentation['paths']),
        'documentation' => $documentation
    ]);
})->name('test.auto.swagger');

// Original Swagger UI route - handled by L5-Swagger package

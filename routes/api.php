<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (no authentication required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (authentication required)
Route::middleware('token.auth')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/refresh-token', [AuthController::class, 'refresh']);
    Route::get('/dashboard/roles', [YourController::class, 'roles'])->name('dashboard.roles');


    // Admin routes (admin role required)
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // User management
        Route::get('/users', [AdminController::class, 'getAllUsers']);
        Route::get('/users/{id}', [AdminController::class, 'getUserById']);
        Route::post('/users', [AdminController::class, 'createUser']);
        Route::put('/users/{id}', [AdminController::class, 'updateUser']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
        Route::patch('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus']);
        Route::post('/users/{id}/reset-password', [AdminController::class, 'resetUserPassword']);
        Route::get('/users/role/{role}', [AdminController::class, 'getUsersByRole']);
    });

    // Moderator routes (moderator or admin role required)
    Route::middleware('role:moderator,admin')->prefix('moderator')->group(function () {
        // Add moderator-specific routes here
        Route::get('/dashboard', function () {
            return response()->json([
                'success' => true,
                'message' => 'Moderator dashboard accessed successfully'
            ]);
        });
    });

    // User routes (any authenticated user)
    Route::prefix('user')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json([
                'success' => true,
                'message' => 'User dashboard accessed successfully'
            ]);
        });
    });
});

// Test route to check if API is working
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is working correctly',
        'timestamp' => now()
    ]);
});

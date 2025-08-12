<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Show the main dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $stats = $this->getDashboardStats();
        
        return view('dashboard.index', compact('user', 'stats'));
    }

    /**
     * Show admin dashboard
     */
    public function admin()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $stats = $this->getAdminStats();
        $recentUsers = User::latest()->take(5)->get();
        
        return view('dashboard.admin', compact('user', 'stats', 'recentUsers'));
    }

    /**
     * Show user profile page
     */
    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    /**
     * Show user management page (admin only)
     */
    public function users()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $users = User::paginate(15);
        return view('dashboard.users', compact('user', 'users'));
    }

    /**
     * Store a new user (admin only)
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:user,admin,moderator',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'is_active' => true,
        ]);
        
        return redirect()->route('dashboard.users')->with('success', 'User created successfully!');
    }

    /**
     * Update user (admin only)
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $targetUser = User::find($id);
        if (!$targetUser) {
            return redirect()->route('dashboard.users')->with('error', 'User not found.');
        }
        
        $request->validate([
            'role' => 'required|string|in:user,admin,moderator',
        ]);
        
        $targetUser->update([
            'role' => $request->role,
        ]);
        
        return redirect()->route('dashboard.users')->with('success', 'User role updated successfully!');
    }

    /**
     * Show settings page
     */
    public function settings()
    {
        $user = Auth::user();
        return view('dashboard.settings', compact('user'));
    }

    /**
     * Admin action: Toggle a user's active status.
     */
    public function toggleUserStatusWeb(Request $request, string $id)
    {
        $currentUser = Auth::user();
        if (!$currentUser->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $targetUser = User::find($id);
        if (!$targetUser) {
            return back()->with('error', 'User not found.');
        }

        if ($currentUser->id === $targetUser->id) {
            return back()->with('error', 'Cannot change your own status.');
        }

        $targetUser->update(['is_active' => !$targetUser->is_active]);
        return back()->with('success', 'User status updated successfully.');
    }

    /**
     * Admin action: Reset a user's password.
     */
    public function resetUserPasswordWeb(Request $request, string $id)
    {
        $currentUser = Auth::user();
        if (!$currentUser->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $request->validate([
            'new_password' => 'sometimes|string|min:8',
        ]);

        $targetUser = User::find($id);
        if (!$targetUser) {
            return back()->with('error', 'User not found.');
        }

        $newPassword = $request->input('new_password', 'password123');
        $targetUser->update(['password' => Hash::make($newPassword)]);

        return back()->with('success', 'User password reset successfully.');
    }

    /**
     * Admin action: Delete a user.
     */
    public function deleteUserWeb(Request $request, string $id)
    {
        $currentUser = Auth::user();
        if (!$currentUser->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $targetUser = User::find($id);
        if (!$targetUser) {
            return back()->with('error', 'User not found.');
        }

        if ($currentUser->id === $targetUser->id) {
            return back()->with('error', 'Cannot delete your own account.');
        }

        $targetUser->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    /**
     * Get dashboard statistics
     */
    private function getDashboardStats()
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'moderator_users' => User::where('role', 'moderator')->count(),
        ];
    }

    /**
     * Get admin dashboard statistics
     */
    private function getAdminStats()
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'moderator_users' => User::where('role', 'moderator')->count(),
            'regular_users' => User::where('role', 'user')->count(),
            'users_this_month' => User::whereMonth('created_at', now()->month)->count(),
        ];
    }
}

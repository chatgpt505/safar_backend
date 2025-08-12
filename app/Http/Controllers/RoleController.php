<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of roles
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $roles = Role::withCount('users')->paginate(15);
        $permissions = Permission::active()->get()->groupBy('group');
        
        return view('dashboard.roles.index', compact('user', 'roles', 'permissions'));
    }

    /**
     * Show the form for creating a new role
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $permissions = Permission::active()->get()->groupBy('group');
        
        return view('dashboard.roles.create', compact('user', 'permissions'));
    }

    /**
     * Store a newly created role
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);
        
        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'permissions' => $request->permissions ?? [],
        ]);
        
        return redirect()->route('dashboard.roles.index')
            ->with('success', 'Role created successfully!');
    }

    /**
     * Show the form for editing the specified role
     */
    public function edit(Role $role)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $permissions = Permission::active()->get()->groupBy('group');
        
        return view('dashboard.roles.edit', compact('user', 'role', 'permissions'));
    }

    /**
     * Update the specified role
     */
    public function update(Request $request, Role $role)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $request->validate([
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);
        
        $role->update([
            'display_name' => $request->display_name,
            'description' => $request->description,
            'permissions' => $request->permissions ?? [],
        ]);
        
        return redirect()->route('dashboard.roles.index')
            ->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified role
     */
    public function destroy(Role $role)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        // Prevent deletion of system roles
        if (in_array($role->name, ['admin', 'moderator', 'user'])) {
            return redirect()->route('dashboard.roles.index')
                ->with('error', 'Cannot delete system roles.');
        }
        
        // Check if role has users
        if ($role->users()->count() > 0) {
            return redirect()->route('dashboard.roles.index')
                ->with('error', 'Cannot delete role with assigned users.');
        }
        
        $role->delete();
        
        return redirect()->route('dashboard.roles.index')
            ->with('success', 'Role deleted successfully!');
    }

    /**
     * Show role details and assigned users
     */
    public function show(Role $role)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        $users = $role->users()->paginate(15);
        
        return view('dashboard.roles.show', compact('user', 'role', 'users'));
    }

    /**
     * Toggle role active status
     */
    public function toggleStatus(Role $role)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }
        
        // Prevent deactivation of admin role
        if ($role->name === 'admin') {
            return redirect()->route('dashboard.roles.index')
                ->with('error', 'Cannot deactivate admin role.');
        }
        
        $role->update(['is_active' => !$role->is_active]);
        
        return redirect()->route('dashboard.roles.index')
            ->with('success', 'Role status updated successfully!');
    }
}

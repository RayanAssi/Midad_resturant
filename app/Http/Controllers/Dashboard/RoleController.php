<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->get();

        $stats = [
            'total_roles'       => Role::count(),
            'total_permissions' => Permission::count(),
            'total_users'       => \App\Models\User::count(),
        ];

        return view('admin.roles.index', compact('roles', 'stats'));
    }


    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            // group by first part (before dot)
            return explode('.', $permission->name)[0];
        });

        return view('admin.roles.create', compact('permissions'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255|unique:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $role = Role::create([
                'name'       => $request->name,
                'guard_name' => 'web',
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            return redirect()
                ->route('admin.roles.index')
                ->with('flashMessage', 'Role created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }


    public function show($id)
    {
        $role = Role::with('permissions')->find($id);

        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found');
        }

        return view('admin.roles.show', compact('role'));
    }


    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);

        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found');
        }


        if ($role->name === 'super-admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'The super-admin role is protected and cannot be edited.');
        }

        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }


    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found');
        }


        if ($role->name === 'super-admin') {
            return back()->with('error', 'The super-admin role is protected and cannot be updated.');
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $role->update(['name' => $request->name]);

            $role->syncPermissions($request->permissions ?? []);

            return redirect()
                ->route('admin.roles.index')
                ->with('flashMessage', 'Role updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found');
        }


        if ($role->name === 'super-admin') {
            return back()->with('error', 'Cannot delete super-admin role');
        }

        try {
            $role->delete();

            return redirect()
                ->route('admin.roles.index')
                ->with('flashMessage', 'Role deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    /**
     * Store a new role via AJAX (from Employee Form).
     */
    public function quickStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255|unique:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $role = Role::create([
                'name'       => $request->name,
                'guard_name' => 'web',
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            return response()->json([
                'success' => true,
                'role'    => [
                    'id'   => $role->id,
                    'name' => $role->name,
                ],
                'message' => 'Role created successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * عرض قائمة الأدوار
     */
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

    /**
     * فورم إنشاء دور
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            // group by first part (before dot)
            return explode('.', $permission->name)[0];
        });

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * حفظ دور جديد
     */
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

    /**
     * عرض دور
     */
    public function show($id)
    {
        $role = Role::with('permissions')->find($id);

        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found');
        }

        return view('admin.roles.show', compact('role'));
    }

    /**
     * فورم تعديل دور
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);

        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found');
        }

        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * تحديث دور
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found');
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

    /**
     * حذف دور
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Role not found');
        }

        // منع حذف super-admin
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
}
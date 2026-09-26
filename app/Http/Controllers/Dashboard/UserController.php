<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query()->where('role', 'employee')->with('roles');

        // ═══ 1) Search — name + email ═══
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('position')) {
            $query->where('position', 'like', '%' . $request->position . '%');
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $total      = User::where('role', 'employee')->count();
        $todayCount = User::where('role', 'employee')->whereDate('created_at', today())->count();

        return view('admin.users.index', [
            'users'      => $users,
            'total'      => $total,
            'todayCount' => $todayCount,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = User::where('role', 'employee')
            ->whereNotNull('position')
            ->where('position', '!=', '')
            ->distinct()
            ->orderBy('position')
            ->pluck('position');

        
        $roles = Role::all();

        return view('admin.users.create', compact('positions', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
            'position'     => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'string', 'max:20'],
            'country_code' => ['nullable', 'string', 'max:6'],
            'roles'        => ['nullable', 'array'],
            'roles.*'      => ['exists:roles,name'],
        ]);

        $data['role'] = 'employee';

        if (empty($data['country_code'])) {
            $data['phone'] = $data['phone'];
        } else {
            $data['phone'] = $data['country_code'] . ' ' . trim($data['phone']);
        }

        unset($data['country_code']);

        
        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        $user = User::create($data);

        if (!empty($roles)) {
        $roleModels = Role::whereIn('name', $roles)
            ->where('guard_name', 'web')
            ->get();

        $user->syncRoles($roleModels);
    }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user->role !== 'employee') {
            abort(404);
        }

        $user->load('roles');

        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($user->role !== 'employee') {
            abort(404);
        }

        $positions = User::where('role', 'employee')
            ->whereNotNull('position')
            ->where('position', '!=', '')
            ->where('id', '!=', $user->id)
            ->distinct()
            ->orderBy('position')
            ->pluck('position');

        
        $roles     = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();

        return view('admin.users.edit', [
            'user'      => $user,
            'positions' => $positions,
            'roles'     => $roles,
            'userRoles' => $userRoles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($user->role !== 'employee') {
            abort(404);
        }

        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password'     => ['nullable', 'string', 'min:8', 'confirmed'],
            'position'     => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'string', 'max:20'],
            'country_code' => ['nullable', 'string', 'max:6'],
            'roles'        => ['nullable', 'array'],
            'roles.*'      => ['exists:roles,name'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if (!empty($data['country_code'])) {
            $data['phone'] = $data['country_code'] . ' ' . trim($data['phone']);
        }

        unset($data['country_code']);

        
        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        $user->update($data);

        $roleModels = Role::whereIn('name', $roles)
        ->where('guard_name', 'web')
        ->get();

    $user->syncRoles($roleModels);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role !== 'employee') {
            abort(404);
        }

        if ($user->id === auth('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
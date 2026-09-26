<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query()->where('role', 'employee');

        // ═══ 1) Search — name + email ═══
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // ═══ 2) Phone ═══
        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        // ═══ 3) Position ═══
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

        return view('admin.users.create', compact('positions'));
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
        ]);

        $data['role'] = 'employee';

        if (empty($data['country_code'])) {
            $data['phone'] = $data['phone'];
        } else {
            $data['phone'] = $data['country_code'] . ' ' . trim($data['phone']);
        }

        unset($data['country_code']);

        User::create($data);

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

        return view('admin.users.edit', [
            'user'      => $user,
            'positions' => $positions,
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
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if (!empty($data['country_code'])) {
            $data['phone'] = $data['country_code'] . ' ' . trim($data['phone']);
        }

        unset($data['country_code']);

        $user->update($data);

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

<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = function ($query) use ($request) {
            if ($request->filled('search')) {
                $query->where('title', 'like', '%' . $request->search . '%');
            }

            if ($request->filled('from')) {
                $query->whereDate('date', '>=', $request->from);
            }

            if ($request->filled('to')) {
                $query->whereDate('date', '<=', $request->to);
            }

            if ($request->boolean('mine')) {
                $query->where('user_id', auth('web')->id());
            }
        };

        $total = Expense::query()
            ->tap($filters)
            ->sum('amount');

        $count = Expense::query()
            ->tap($filters)
            ->count();

        $average = $count > 0 ? $total / $count : 0;

        $topExpense = Expense::query()
            ->tap($filters)
            ->orderByDesc('amount')
            ->first();

        $todayCount = Expense::whereDate('date', today())->count();
        $todayTotal = Expense::whereDate('date', today())->sum('amount');

        $weekCount = Expense::whereBetween('date', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->count();

        $weekTotal = Expense::whereBetween('date', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->sum('amount');

        $monthCount = Expense::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        $monthTotal = Expense::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $expenses = Expense::query()
            ->with('user')
            ->tap($filters)
            ->latest('date')
            ->paginate(15)
            ->withQueryString();

        return view('employee.expenses.index', [
            'expenses'   => $expenses,
            'total'      => $total,
            'count'      => $count,
            'average'    => $average,
            'topExpense' => $topExpense,
            'todayCount' => $todayCount,
            'todayTotal' => $todayTotal,
            'weekCount'  => $weekCount,
            'weekTotal'  => $weekTotal,
            'monthCount' => $monthCount,
            'monthTotal' => $monthTotal,
        ]);
    }

    public function create()
    {
        return view('employee.expenses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'  => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'date'   => ['required', 'date'],
        ]);

        $data['user_id'] = auth('web')->id();

        Expense::create($data);

        return redirect()
            ->route('employee.expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    public function show(Expense $expense)
    {
        $expense->load('user');

        return view('employee.expenses.show', ['expense' => $expense]);
    }

    public function edit(Expense $expense)
    {
        if ($expense->user_id !== auth('web')->id()) {
            abort(403, 'You are not allowed to edit this expense.');
        }

        return view('employee.expenses.edit', ['expense' => $expense]);
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== auth('web')->id()) {
            abort(403, 'You are not allowed to update this expense.');
        }

        $data = $request->validate([
            'title'  => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'date'   => ['required', 'date'],
        ]);

        $expense->update($data);

        return redirect()
            ->route('employee.expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== auth('web')->id()) {
            abort(403, 'You are not allowed to delete this expense.');
        }

        $expense->delete();

        return redirect()
            ->route('employee.expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}

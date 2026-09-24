<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index(Request $request)
    {
        // ═══ 1) الفلاتر المشتركة ═══
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

            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->boolean('mine')) {
                $query->where('user_id', auth('admin')->id());
            }
        };

        // ═══ 2) إحصائيات الفلترة (Expenses) ═══
        $total   = Expense::query()->tap($filters)->sum('amount');
        $count   = Expense::query()->tap($filters)->count();
        $average = $count > 0 ? $total / $count : 0;

        $topExpense = Expense::query()
            ->tap($filters)
            ->orderByDesc('amount')
            ->first();

        // ═══ 3) إيرادات الفلترة (Invoices) ═══
        $revenueFilters = function ($query) use ($request) {
            if ($request->filled('from')) {
                $query->whereDate('created_at', '>=', $request->from);
            }
            if ($request->filled('to')) {
                $query->whereDate('created_at', '<=', $request->to);
            }
        };

        $revenue   = Invoice::query()->tap($revenueFilters)->sum('total_amount');
        $netProfit = $revenue - $total;
        $margin    = $revenue > 0 ? ($netProfit / $revenue) * 100 : 0;

        // ═══ 4) إحصائيات اليوم ═══
        $todayCount    = Expense::whereDate('date', today())->count();
        $todayExpenses = Expense::whereDate('date', today())->sum('amount');
        $todayRevenue  = Invoice::whereDate('created_at', today())->sum('total_amount');
        $todayNet      = $todayRevenue - $todayExpenses;
        $todayMargin   = $todayRevenue > 0 ? ($todayNet / $todayRevenue) * 100 : 0;

        // ═══ 5) إحصائيات الشهر ═══
        $monthCount    = Expense::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        $monthExpenses = Expense::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $monthRevenue = Invoice::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        $monthNet    = $monthRevenue - $monthExpenses;
        $monthMargin = $monthRevenue > 0 ? ($monthNet / $monthRevenue) * 100 : 0;

        // ═══ 6) المستخدمون للفلترة ═══
        $users = User::withCount('expenses')
        ->role('expense-manager', 'web')
            ->orderBy('name')
            ->get(['id', 'name']);

        // ═══ 7) الجدول ═══
        $expenses = Expense::query()
            ->with('user')
            ->tap($filters)
            ->latest('date')
            ->paginate(15)
            ->withQueryString();

        return view('admin.expenses.index', [
            'expenses'   => $expenses,
            'users'      => $users,

            'total'      => $total,
            'count'      => $count,
            'average'    => $average,
            'topExpense' => $topExpense,
            'revenue'    => $revenue,
            'netProfit'  => $netProfit,
            'margin'     => $margin,

            'todayCount'    => $todayCount,
            'todayExpenses' => $todayExpenses,
            'todayRevenue'  => $todayRevenue,
            'todayNet'      => $todayNet,
            'todayMargin'   => $todayMargin,

            'monthCount'    => $monthCount,
            'monthExpenses' => $monthExpenses,
            'monthRevenue'  => $monthRevenue,
            'monthNet'      => $monthNet,
            'monthMargin'   => $monthMargin,
        ]);
    }

    public function create()
    {
        return view('admin.expenses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'  => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'date'   => ['required', 'date', 'before_or_equal:today'],
        ]);

        $data['user_id'] = auth('admin')->id();

        Expense::create($data);

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    public function show(Expense $expense)
    {
        $expense->load('user');

        return view('admin.expenses.show', ['expense' => $expense]);
    }

    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', ['expense' => $expense]);
    }

    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'title'  => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'date'   => ['required', 'date', 'before_or_equal:today'],
        ]);

        $expense->update($data);

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}
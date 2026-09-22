<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $stats = [];

        
        if ($user->can('orders.view')) {
            $stats['orders'] = [
                'total'   => Order::count(),
                'today'   => Order::whereDate('created_at', today())->count(),
                'revenue' => Order::sum('total_amount') ?? 0,
            ];
        }

        
        if ($user->can('invoices.view')) {
            $stats['invoices'] = [
                'total'   => Invoice::where('created_by', $user->id)->count(),
                'today'   => Invoice::where('created_by', $user->id)
                                    ->whereDate('created_at', today())
                                    ->count(),
                'revenue' => Invoice::where('created_by', $user->id)
                                    ->sum('total_amount') ?? 0,
            ];
        }

        
        if ($user->can('menu-items.view')) {
            $stats['menu'] = [
                'total' => MenuItem::count(),
            ];
        }

        
        if ($user->can('expenses.view') && class_exists(\App\Models\Expense::class)) {
            $stats['expenses'] = [
                'count' => \App\Models\Expense::count(),
                'total' => \App\Models\Expense::sum('amount') ?? 0,
                'today' => \App\Models\Expense::whereDate('date', today())->sum('amount') ?? 0,
            ];
        }

        return view('employee.dashboard', compact('stats'));
    }
}
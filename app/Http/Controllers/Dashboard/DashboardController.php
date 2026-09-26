<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Expense;
use App\Models\MenuItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // ═══ Stats — Today ═══
        $ordersToday = Order::whereDate('created_at', $today)->count();
        $ordersYesterday = Order::whereDate('created_at', $yesterday)->count();
        $ordersChange = $ordersYesterday > 0
            ? (($ordersToday - $ordersYesterday) / $ordersYesterday) * 100
            : ($ordersToday > 0 ? 100 : 0);

        $revenueToday = Invoice::whereDate('created_at', $today)->sum('total_amount');
        $revenueYesterday = Invoice::whereDate('created_at', $yesterday)->sum('total_amount');
        $revenueChange = $revenueYesterday > 0
            ? (($revenueToday - $revenueYesterday) / $revenueYesterday) * 100
            : ($revenueToday > 0 ? 100 : 0);

        $invoicesToday = Invoice::whereDate('created_at', $today)->count();
        $invoicesYesterday = Invoice::whereDate('created_at', $yesterday)->count();
        $invoicesChange = $invoicesYesterday > 0
            ? (($invoicesToday - $invoicesYesterday) / $invoicesYesterday) * 100
            : ($invoicesToday > 0 ? 100 : 0);

        $expensesToday = Expense::whereDate('date', $today)->sum('amount');
        $expensesYesterday = Expense::whereDate('date', $yesterday)->sum('amount');
        $expensesChange = $expensesYesterday > 0
            ? (($expensesToday - $expensesYesterday) / $expensesYesterday) * 100
            : ($expensesToday > 0 ? 100 : 0);

        
        $salesLast7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $salesLast7Days->push([
                'date'  => $date->format('D'),
                'total' => (float) Invoice::whereDate('created_at', $date)->sum('total_amount'),
            ]);
        }

        $maxSale = $salesLast7Days->max('total') ?: 1;

        // ═══ Recent Orders ═══
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // ═══ Top Selling Items ═══
        $topItems = DB::table('order_items')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->groupBy('menu_items.id', 'menu_items.name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // ═══ Totals ═══
        $totals = [
            'orders'   => Order::count(),
            'invoices' => Invoice::count(),
            'menu'     => MenuItem::count(),
            'expenses' => Expense::sum('amount'),
        ];

        return view('admin.dashboard', compact(
            'ordersToday', 'ordersChange',
            'revenueToday', 'revenueChange',
            'invoicesToday', 'invoicesChange',
            'expensesToday', 'expensesChange',
            'salesLast7Days', 'maxSale',
            'recentOrders', 'topItems', 'totals'
        ));
    }
}
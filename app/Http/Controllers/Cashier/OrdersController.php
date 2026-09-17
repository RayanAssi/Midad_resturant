<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('cashier.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('cashier.orders.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        // رح نبنيه لاحقاً
        return redirect()->route('cashier.orders.index');
    }

    public function show(Order $order)
{
    $order->load('items.menuItem', 'user');
    return view('cashier.orders.show', compact('order'));
}

    public function edit(Order $order)
    {
        return view('cashier.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        // رح نبنيه لاحقاً
        return redirect()->route('cashier.orders.index');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('cashier.orders.index')->with('success', 'Order deleted successfully.');
    }
}

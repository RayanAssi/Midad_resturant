<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $items = $query->latest()->paginate(12)->withQueryString();

        return view('admin.menu-items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.menu-items.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'price'    => ['required', 'numeric', 'min:0'],
            'category' => ['required', 'in:' . implode(',', MenuItem::categories())],
            'image'    => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu-items', 'public');
        }

        MenuItem::create($data);

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Menu item created successfully.');
    }

    public function show(MenuItem $menuItem)
    {
        $menuItem->loadCount('orders');

        $recentOrders = $menuItem->orders()
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.menu-items.show', [
            'item' => $menuItem,
            'recentOrders' => $recentOrders,
        ]);
    }

    public function edit(MenuItem $menuItem)
    {
        return view('admin.menu-items.edit', ['item' => $menuItem]);
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'price'    => ['required', 'numeric', 'min:0'],
            'category' => ['required', 'in:' . implode(',', MenuItem::categories())],
            'image'    => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            // احذف القديمة فقط إذا مو مستعملة من صنف تاني
            if ($menuItem->image && Storage::disk('public')->exists($menuItem->image)) {
                $usedByOthers = MenuItem::where('image', $menuItem->image)
                    ->where('id', '!=', $menuItem->id)
                    ->exists();

                if (! $usedByOthers) {
                    Storage::disk('public')->delete($menuItem->image);
                }
            }

            $filename = Str::slug($data['name']) . '.' . $request->file('image')->getClientOriginalExtension();

            if (Storage::disk('public')->exists('menu-items/' . $filename)) {
                $filename = Str::slug($data['name']) . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            }

            $data['image'] = $request->file('image')->storeAs('menu-items', $filename, 'public');
        }

        $menuItem->update($data);

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Menu item updated successfully.');
    }
    public function destroy(MenuItem $menuItem)
    {
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Menu item deleted successfully.');
    }
}

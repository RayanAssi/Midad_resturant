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
        $menuItem = new MenuItem();
        return view('admin.menu-items.create', [
            'menuItem' => $menuItem,
        ]);
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
        return view('admin.menu-items.edit', [
            'item' => $menuItem,
            /* 'translations' => [
                'name' => session(
                    'name.translations',
                    $menuItem->translationsForText($menuItem)
                ),
                'category' => session(
                    'category.translations',
                    $menuItem->translationsForText($menuItem)
                ),
            ] */
        ]);
    }
    public function update(Request $request, MenuItem $menuItem)
    {
        // Validate the incoming request data
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'price'    => ['required', 'numeric', 'min:0'],
            'category' => ['required', 'in:' . implode(',', MenuItem::categories())],
            'image'    => ['nullable', 'image', 'max:5120'],
        ]);

        // Store the old values before updating
        $oldName = $menuItem->name;
        $oldDescription = $menuItem->description; // Ensure this field exists in the MenuItem model

        // Handle the image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists and is not used by other items
            if ($menuItem->image && Storage::disk('public')->exists($menuItem->image)) {
                $usedByOthers = MenuItem::where('image', $menuItem->image)
                    ->where('id', '!=', $menuItem->id)
                    ->exists();

                if (! $usedByOthers) {
                    Storage::disk('public')->delete($menuItem->image);
                }
            }

            // Generate a unique filename for the new image
            $filename = Str::slug($data['name']) . '.' . $request->file('image')->getClientOriginalExtension();

            if (Storage::disk('public')->exists('menu-items/' . $filename)) {
                $filename = Str::slug($data['name']) . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            }

            // Store the new image
            $data['image'] = $request->file('image')->storeAs('menu-items', $filename, 'public');
        }

        // Update the menu item with the validated data
        $menuItem->update($data);

        // Update translation keys if the name or description has changed
        if ($oldName !== $menuItem->name) {
            $menuItem->renameTranslationKey($oldName, $menuItem->name);
        }

        if ($oldDescription !== $menuItem->description) {
            $menuItem->renameTranslationKey($oldDescription, $menuItem->description);
        }

        // Redirect back with a success message
        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(MenuItem $menuItem)
    {
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }
        $menuItem->deleteTranslationsFromJson();
        $menuItem->delete();

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Menu item deleted successfully.');
    }
}

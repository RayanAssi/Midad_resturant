<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

        $items = $query->orderBy('category')->orderBy('name')->get();

        return view('employee.menu-items.index', compact('items'));
    }

    
    public function create()
    {
        $categories = MenuItem::categories();

        return view('employee.menu-items.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|in:' . implode(',', MenuItem::categories()),
            'image'    => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->only(['name', 'price', 'category']);
            $data['image'] = $request->file('image')->store('menu-items', 'public');

            MenuItem::create($data);

            return redirect()
                ->route('employee.menu-items.index')
                ->with('flashMessage', 'The item has been successfully added.');

        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage())->withInput();
        }
    }

    
    public function show($id)
    {
        $item = MenuItem::find($id);

        if (!$item) {
            return redirect()
                ->route('employee.menu-items.index')
                ->with('error', 'The item does not exist');
        }

        return view('employee.menu-items.show', compact('item'));
    }

    
    public function edit($id)
    {
        $item = MenuItem::find($id);

        if (!$item) {
            return redirect()
                ->route('employee.menu-items.index')
                ->with('error', 'The item does not exist');
        }

        $categories = MenuItem::categories();

        return view('employee.menu-items.edit', compact('item', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $item = MenuItem::find($id);

        if (!$item) {
            return redirect()
                ->route('employee.menu-items.index')
                ->with('error', 'The item does not exist');
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|in:' . implode(',', MenuItem::categories()),
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->only(['name', 'price', 'category']);

            if ($request->hasFile('image')) {
                
                if ($item->image && Storage::disk('public')->exists($item->image)) {
                    Storage::disk('public')->delete($item->image);
                }
                $data['image'] = $request->file('image')->store('menu-items', 'public');
            }

            $item->update($data);

            return redirect()
                ->route('employee.menu-items.index')
                ->with('flashMessage', 'The item has been successfully updated.');

        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage())->withInput();
        }
    }

    
    public function destroy($id)
    {
        $item = MenuItem::find($id);

        if (!$item) {
            return redirect()
                ->route('employee.menu-items.index')
                ->with('error', 'The item does not exist');
        }

        try {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $item->delete();

            return redirect()
                ->route('employee.menu-items.index')
                ->with('flashMessage', 'The item has been successfully deleted.');

        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
}
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
            $query->where(
                'category',
                $request->category
            );
        }

        if ($request->filled('search')) {
            $query->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );
        }

        $items = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view(
            'admin.menu-items.index',
            compact('items')
        );
    }

    
    public function create()
    {
        $item = new MenuItem();

        $translations = [
            'name' => []
        ];

        
        $nameSource = trim(
            (string) session('name_source', '')
        );

        if ($nameSource !== '') {
            $translations['name'] =
                session('name_translations', []);

            
            if (empty($translations['name'])) {
                $translations['name'] =
                    $item->translationsForText(
                        $nameSource
                    );
            }
        }

        
        $oldTranslations =
            old('name_translations');

        if (is_array($oldTranslations)) {
            $translations['name'] = array_merge(
                $translations['name'],
                $oldTranslations
            );
        }

        return view(
            'admin.menu-items.create',
            compact(
                'item',
                'translations'
            )
        );
    }


    public function store(Request $request)
    {


        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'price' => [
                'required',
                'numeric',
                'min:100'
            ],

            'category' => [
                'required',
                'in:' . implode(
                    ',',
                    MenuItem::categories()
                )
            ],

            'image' => [
                'required',
                'image',
                'max:5120'
            ],
        ]);

        
        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store(
                    'menu-items',
                    'public'
                );
        }

        $menuItem = MenuItem::create($data);
        
        $translations = $request->input(
            'name_translations',
            []
        );

        if (is_array($translations)) {
            foreach (
                $translations as $locale => $translation
            ) {
                $translation =
                    trim((string) $translation);

                if ($translation === '') {
                    continue;
                }

                $menuItem->addTranslationToJson(
                    $menuItem->name,
                    $locale,
                    $translation
                );
            }
        }

        
        session()->forget([
            'name_source',
            'name_translations'
        ]);

        return redirect()
            ->route('admin.menu-items.index')
            ->with(
                'success',
                'Menu item created successfully.'
            );
    }

    public function show(MenuItem $menuItem)
    {
        $menuItem->loadCount('orders');

        $recentOrders = $menuItem
            ->orders()
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view(
            'admin.menu-items.show',
            [
                'item' => $menuItem,
                'recentOrders' => $recentOrders,
            ]
        );
    }

    
    public function edit(MenuItem $menuItem)
    {
        $item = $menuItem;

        $translations = [];

        foreach ($item->getTranslatableAttributes() as $attr) {

            $text = trim((string) ($item->{$attr} ?? ''));

            if ($text === '') {
                continue;
            }

            $translations[$attr] = $item->translationsForText($text);

           

            $oldTranslations = old("{$attr}_translations");

            if (is_array($oldTranslations)) {
                $translations[$attr] = array_merge(
                    $translations[$attr] ?? [],
                    $oldTranslations
                );
            }
        }

        return view('admin.menu-items.edit', compact(
            'item',
            'translations'
        ));
    }


    
    public function update(
        Request $request,
        MenuItem $menuItem
    ) {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'price' => [
                'required',
                'numeric',
                'min:0'
            ],

            'category' => [
                'required',
                'in:' . implode(
                    ',',
                    MenuItem::categories()
                )
            ],

            'image' => [
                'nullable',
                'image',
                'max:5120'
            ],
        ]);

        $oldName = $menuItem->name;

        
        if ($request->hasFile('image')) {

            if (
                $menuItem->image &&
                Storage::disk('public')
                ->exists($menuItem->image)
            ) {
                $usedByOthers =
                    MenuItem::where(
                        'image',
                        $menuItem->image
                    )
                    ->where(
                        'id',
                        '!=',
                        $menuItem->id
                    )
                    ->exists();

                if (!$usedByOthers) {
                    Storage::disk('public')
                        ->delete(
                            $menuItem->image
                        );
                }
            }

            $filename =
                Str::slug($data['name'])
                . '.'
                . $request
                ->file('image')
                ->getClientOriginalExtension();

            if (
                Storage::disk('public')
                ->exists(
                    'menu-items/' . $filename
                )
            ) {
                $filename =
                    Str::slug($data['name'])
                    . '-'
                    . time()
                    . '.'
                    . $request
                    ->file('image')
                    ->getClientOriginalExtension();
            }

            $data['image'] =
                $request
                ->file('image')
                ->storeAs(
                    'menu-items',
                    $filename,
                    'public'
                );
        }

        
        $menuItem->update($data);

        
        if ($oldName !== $menuItem->name) {
            $menuItem->renameTranslationKey(
                $oldName,
                $menuItem->name
            );
        }

        
        $translations = $request->input(
            'name_translations',
            []
        );

        if (is_array($translations)) {
            foreach (
                $translations as $locale => $translation
            ) {
                $translation =
                    trim((string) $translation);

                if ($translation === '') {
                    continue;
                }

                $menuItem->addTranslationToJson(
                    $menuItem->name,
                    $locale,
                    $translation
                );
            }
        }

        
        session()->forget([
            'name_source',
            'name_translations'
        ]);

        return redirect()
            ->route('admin.menu-items.index')
            ->with(
                'success',
                'Menu item updated successfully.'
            );
    }

    
    public function destroy(MenuItem $menuItem)
    {
        if ($menuItem->image) {
            Storage::disk('public')->delete(
                $menuItem->image
            );
        }

        $menuItem->deleteTranslationsFromJson();

        $menuItem->delete();

        return redirect()
            ->route('admin.menu-items.index')
            ->with(
                'success',
                'Menu item deleted successfully.'
            );
    }
}

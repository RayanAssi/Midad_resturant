@php
    // نجيب الـ path من الـ URL
    $segments = request()->segments();
    $url = '';

    // خريطة لتحويل الـ slugs لأسماء جميلة
    $labels = [
        'admin'      => 'Admin',
        'employee'    => 'Employee',
        'menu-items' => 'Menu Items',
        'orders'     => 'Orders',
        'invoices'   => 'Invoices',
        'expenses'   => 'Daily Expenses',
        'create'     => 'Create',
        'edit'       => 'Edit',
        'show'       => 'Details',
    ];

    // خريطة للـ routes
    $routes = [
        'admin.menu-items.index'   => null,
        'admin.menu-items.create'  => null,
        'admin.menu-items.edit'    => null,
        'admin.menu-items.show'    => null,
        'admin.orders.index'       => null,
        'admin.invoices.index'     => null,
        'admin.expenses.index'     => null,
        'employee.menu-items.index' => null,
        'employee.orders.index'     => null,
        'employee.orders.create'    => null,
    ];
@endphp

<nav class="flex items-center gap-2 text-sm">
    @foreach($segments as $index => $segment)
        @php
            $url .= '/' . $segment;
            $isLast = $index === count($segments) - 1;
            
            // إذا كان رقم (id)، نعرضه #ID
            $label = is_numeric($segment) 
                ? '#' . $segment 
                : ($labels[$segment] ?? ucfirst(str_replace('-', ' ', $segment)));
        @endphp

        {{-- Separator --}}
        <x-lucide-chevron-right class="w-4 h-4 text-red-700/50 flex-shrink-0" />

        {{-- Item --}}
        @if($isLast)
            <span class="font-bold text-amber-100">
                {{ $label }}
            </span>
        @else
            <a href="{{ $url }}"
               class="text-amber-200/60 hover:text-amber-100 transition-colors">
                {{ $label }}
            </a>
        @endif
    @endforeach
</nav>
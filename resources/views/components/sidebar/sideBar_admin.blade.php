@props([
    'userName' => 'المدير',
    'restaurantName' => 'مطعم',
    'active' => 'dashboard',
])

@php
    $menuItems = [
        ['key' => 'dashboard', 'label' => 'الرئيسية', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['key' => 'orders', 'label' => 'الطلبات', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['key' => 'menu', 'label' => 'قائمة الطعام', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ['key' => 'invoices', 'label' => 'الفواتير', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['key' => 'expenses', 'label' => 'المصاريف', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['key' => 'users', 'label' => 'المستخدمون', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ['key' => 'reports', 'label' => 'التقارير', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
        ['key' => 'settings', 'label' => 'الإعدادات', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
    ];
@endphp

<aside class="fixed top-0 right-0 z-40 w-64 h-screen 
              bg-gradient-to-b from-gray-900 via-gray-800 to-black
              border-l-2 border-red-800/50
              shadow-2xl shadow-red-900/30
              overflow-y-auto">

    {{-- الشعار --}}
    <div class="flex items-center gap-3 px-6 py-5 
                border-b-2 border-red-800/40
                bg-gradient-to-r from-red-900/30 to-transparent">
        <div class="w-10 h-10 rounded-xl 
                    bg-gradient-to-br from-red-600 to-red-800
                    flex items-center justify-center
                    shadow-lg shadow-red-900/50">
            <svg class="w-6 h-6 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold text-amber-100">{{ $restaurantName }}</h1>
            <p class="text-xs text-amber-200/60">لوحة المدير</p>
        </div>
    </div>

    {{-- المستخدم --}}
    <div class="px-6 py-4 border-b-2 border-red-800/30">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full 
                        bg-gradient-to-br from-red-600 to-red-800
                        flex items-center justify-center
                        border-2 border-amber-400/30">
                <span class="text-amber-100 font-bold">
                    {{ mb_substr($userName, 0, 1) }}
                </span>
            </div>
            <div>
                <p class="text-sm font-bold text-amber-100">{{ $userName }}</p>
                <p class="text-xs text-amber-200/60">مدير المطعم</p>
            </div>
        </div>
    </div>

    {{-- القائمة --}}
    <nav class="px-4 py-4">
        <ul class="space-y-1">
            @foreach($menuItems as $item)
                <li>
                    <a href="#"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl
                              transition-all duration-200
                              {{ $active === $item['key'] 
                                  ? 'bg-gradient-to-r from-red-700/60 to-red-900/40 
                                     text-amber-100 border-r-4 border-amber-400
                                     shadow-lg shadow-red-900/30' 
                                  : 'text-amber-200/70 hover:text-amber-100 
                                     hover:bg-red-900/20' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="{{ $item['icon'] }}"/>
                        </svg>
                        <span class="font-semibold text-sm">{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    {{-- تسجيل خروج --}}
    <div class="px-4 py-4 mt-auto border-t-2 border-red-800/30">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                           text-red-300 hover:text-red-200
                           hover:bg-red-900/30
                           transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="font-semibold text-sm">تسجيل الخروج</span>
            </button>
        </form>
    </div>

</aside>
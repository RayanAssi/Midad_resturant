@props([
    'userName' => 'الكاشير',
    'restaurantName' => 'مطعم',
])

<nav class="fixed top-0 right-0 left-0 z-50 
            bg-gradient-to-r from-gray-900 via-gray-800 to-black
            border-b-2 border-red-800/50
            shadow-2xl shadow-red-900/30
            backdrop-blur-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- الشعار --}}
            <div class="flex items-center gap-3">
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
                    <p class="text-xs text-amber-200/60">لوحة الكاشير</p>
                </div>
            </div>

            {{-- الروابط --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="#" class="px-4 py-2 rounded-lg text-sm font-semibold
                                   text-amber-100 hover:text-amber-300
                                   hover:bg-red-900/30
                                   transition-all duration-200">
                    الطلبات الجديدة
                </a>
                <a href="#" class="px-4 py-2 rounded-lg text-sm font-semibold
                                   text-amber-100 hover:text-amber-300
                                   hover:bg-red-900/30
                                   transition-all duration-200">
                    الطلبات الحالية
                </a>
                <a href="#" class="px-4 py-2 rounded-lg text-sm font-semibold
                                   text-amber-100 hover:text-amber-300
                                   hover:bg-red-900/30
                                   transition-all duration-200">
                    الفواتير
                </a>
            </div>

            {{-- المستخدم --}}
            <div class="flex items-center gap-3">
                <div class="text-left hidden sm:block">
                    <p class="text-sm font-bold text-amber-100">{{ $userName }}</p>
                    <p class="text-xs text-amber-200/60">كاشير</p>
                </div>
                <div class="w-10 h-10 rounded-full 
                            bg-gradient-to-br from-red-600 to-red-800
                            flex items-center justify-center
                            border-2 border-amber-400/30
                            shadow-lg shadow-red-900/50">
                    <span class="text-amber-100 font-bold">
                        {{ mb_substr($userName, 0, 1) }}
                    </span>
                </div>
            </div>

        </div>
    </div>
</nav>
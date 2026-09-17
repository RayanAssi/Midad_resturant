@props([
    'headers' => [],
    'rows' => [],
    'striped' => true,
    'hover' => true,
    'emptyMessage' => 'لا توجد بيانات للعرض',
])

<div class="overflow-hidden rounded-2xl 
            bg-gradient-to-br from-gray-900 via-gray-800 to-black
            border-2 border-red-800/30
            shadow-2xl shadow-red-900/20">

    <div class="overflow-x-auto">
        <table class="w-full text-center">

            {{-- رأس الجدول --}}
            <thead>
                <tr class="bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                           border-b-2 border-red-700/50">
                    @foreach($headers as $header)
                        <th class="px-6 py-4 
                                   text-sm font-bold text-amber-100 
                                   tracking-wider uppercase
                                   whitespace-nowrap">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            {{-- جسم الجدول --}}
            <tbody class="divide-y divide-red-900/30">
                @if(count($rows) > 0)
                    @foreach($rows as $row)
                        <tr class="transition-all duration-200
                                   {{ $hover ? 'hover:bg-gradient-to-r hover:from-red-900/30 hover:to-transparent' : '' }}
                                   {{ $striped ? 'even:bg-gray-900/40' : '' }}">
                            @foreach($row as $cell)
                                <td class="px-6 py-4 text-sm text-amber-50 whitespace-nowrap">
                                    {!! $cell !!}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="{{ count($headers) }}" 
                            class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full 
                                            bg-gradient-to-br from-red-900/40 to-red-800/20
                                            flex items-center justify-center
                                            border-2 border-red-800/40">
                                    <svg class="w-8 h-8 text-red-400" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                              stroke-width="2" 
                                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                </div>
                                <p class="text-amber-200/60 text-sm font-medium">
                                    {{ $emptyMessage }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- تذييل الجدول (اختياري) --}}
    @if(isset($footer) && $footer->isNotEmpty())
        <div class="px-6 py-4 
                    bg-gradient-to-r from-transparent to-red-900/20
                    border-t-2 border-red-800/40">
            {{ $footer }}
        </div>
    @endif
</div>
<div class="flex items-center gap-2">
    @foreach (config('laravellocalization.supportedLocales') as $code => $locale)
        <a href="{{ route('locale.switch', $code) }}"
        class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200
                {{ app()->getLocale() === $code
                    ? 'bg-red-600 text-white'
                    : 'bg-white/5 text-gray-400 hover:bg-white/10 hover:text-white' }}">
            {{ $locale['native'] }}
        </a>
    @endforeach
</div>
@props(['href', 'active' => false, 'icon' => '', 'badge' => null])

<a href="{{ $href }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group border-l-2 {{ $active ? 'bg-green-600/15 text-green-300 border-green-400 shadow-sm' : 'border-transparent text-slate-400 hover:text-white hover:bg-slate-800/50 hover:border-slate-600' }}">
    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
    </svg>
    <span>{{ $slot }}</span>
    @if($badge && $badge > 0)
        <span class="ml-auto inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[10px] font-bold text-white bg-rose-500 rounded-full shadow-sm shadow-rose-500/30 animate-pulse">{{ $badge }}</span>
    @endif
</a>

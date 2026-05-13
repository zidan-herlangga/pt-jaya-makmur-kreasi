@props(['label', 'icon' => '', 'active' => false, 'defaultOpen' => false])

<div x-data="{ open: {{ $defaultOpen ? 'true' : 'false' }} }" class="space-y-0.5">
    <button @click="open = !open"
            class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group text-slate-400 hover:text-white hover:bg-slate-800/50">
        @if($icon)
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
        </svg>
        @endif
        <span class="flex-1 text-left">{{ $label }}</span>
        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
    </button>

    <div x-show="open" x-transition:enter="transition-all duration-200 ease-out"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-0.5 pl-4 border-l-2 border-slate-700/50 ml-3">
        {{ $slot }}
    </div>
</div>

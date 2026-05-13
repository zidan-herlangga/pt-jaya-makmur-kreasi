@props(['items' => []])

<nav class="flex items-center gap-2 text-sm text-slate-400 mb-4" aria-label="Breadcrumb">
    <a href="{{ url('/') }}" class="hover:text-green-400 transition-colors flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
        </svg>
        Beranda
    </a>
    @foreach($items as $label => $url)
        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
        @if(is_string($label) && $loop->remaining > 0)
            <a href="{{ $url }}" class="hover:text-green-400 transition-colors">{{ $label }}</a>
        @else
            <span class="text-slate-600 font-medium">{{ is_string($label) ? $label : $url }}</span>
        @endif
    @endforeach
</nav>

@props(['point', 'aos' => null, 'aosDelay' => 0])

<article {{ $aos ? 'data-aos=' . $aos . ' data-aos-delay=' . $aosDelay : '' }}
    class="group flex flex-col bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
    {{-- Image Section --}}
    <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
        @if ($point->thumbnail)
            <img src="{{ Storage::url($point->thumbnail) }}" alt="{{ $point->title }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center bg-slate-100">
                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
        @endif

        {{-- Status Badge --}}
        <div class="absolute top-3 left-3">
            <span
                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                {{ $point->status === 'available' ? 'bg-emerald-500 text-white' : '' }}
                {{ $point->status === 'booked' ? 'bg-amber-500 text-white' : '' }}
                {{ $point->status === 'maintenance' ? 'bg-rose-500 text-white' : '' }}">
                {{ $point->status_label }}
            </span>
        </div>

        {{-- Category Badge --}}
        @if ($point->category)
            <div class="absolute top-3 right-3">
                <span class="bg-slate-900/80 backdrop-blur-sm text-white text-xs font-medium px-2.5 py-1 rounded-full">
                    {{ $point->category->name }}
                </span>
            </div>
        @endif
    </div>

    {{-- Content Section --}}
    <div class="flex flex-col flex-1 p-5">
        <h3 class="font-bold text-slate-900 text-lg leading-tight mb-2 group-hover:text-green-600 transition-colors">
            <a href="{{ route('catalog.show', $point) }}">{{ $point->title }}</a>
        </h3>

        <div class="flex items-center gap-1.5 text-slate-500 text-sm mb-3">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="truncate">{{ $point->location_name }}, {{ $point->city }}</span>
        </div>

        {{-- Specs Grid --}}
        <div class="grid grid-cols-2 gap-2 mb-4">
            @if ($point->size_dimension)
                <div class="flex items-center gap-1.5 text-xs text-slate-600 bg-slate-50 rounded-lg px-2.5 py-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                        </path>
                    </svg>
                    {{ $point->size_dimension }}
                </div>
            @endif
            @if ($point->orientation)
                <div class="flex items-center gap-1.5 text-xs text-slate-600 bg-slate-50 rounded-lg px-2.5 py-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2">
                        </path>
                    </svg>
                    {{ ucfirst($point->orientation) }}
                </div>
            @endif
            @if ($point->light_type)
                <div class="flex items-center gap-1.5 text-xs text-slate-600 bg-slate-50 rounded-lg px-2.5 py-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                        </path>
                    </svg>
                    {{ $point->light_type }}
                </div>
            @endif
        </div>

        {{-- Footer: Price & CTA --}}
        <div class="mt-auto pt-4 border-t border-slate-100">
            <div class="flex items-baseline gap-1.5 mb-3">
                <p class="text-sm font-bold text-green-600">{{ $point->formatted_price }}</p>
                {{-- <span class="text-xs text-slate-400">/bln</span> --}}
            </div>
            <a href="{{ route('catalog.show', $point) }}"
                class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-all duration-300 shadow-md shadow-green-500/20 hover:shadow-green-500/40 hover:-translate-y-0.5">
                Lihat Detail
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</article>

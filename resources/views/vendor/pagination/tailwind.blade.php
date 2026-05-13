@if ($paginator->hasPages())
    <nav class="flex items-center justify-between" aria-label="Pagination">
        <p class="text-sm text-slate-500">
            Menampilkan
            <span class="font-medium text-slate-700">{{ $paginator->firstItem() }}</span>
            -
            <span class="font-medium text-slate-700">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-medium text-slate-700">{{ $paginator->total() }}</span>
        </p>

        <div class="flex items-center gap-1.5">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 text-sm text-slate-300 bg-slate-50 rounded-lg border border-slate-200 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-sm text-slate-600 bg-white hover:bg-slate-50 rounded-lg border border-slate-200 hover:border-blue-300 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                    </svg>
                </a>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                {{-- Separator --}}
                @if (is_string($element))
                    <span class="px-3 py-2 text-sm text-slate-400">...</span>
                @endif

                {{-- Page Numbers --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3.5 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow-sm shadow-blue-500/20">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3.5 py-2 text-sm text-slate-600 bg-white hover:bg-slate-50 rounded-lg border border-slate-200 hover:border-blue-300 transition-all">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-sm text-slate-600 bg-white hover:bg-slate-50 rounded-lg border border-slate-200 hover:border-blue-300 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                    </svg>
                </a>
            @else
                <span class="px-3 py-2 text-sm text-slate-300 bg-slate-50 rounded-lg border border-slate-200 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif

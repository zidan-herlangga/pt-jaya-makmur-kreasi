@extends('layouts.app', ['seo' => $seo])

@section('content')
    <div class="page-header py-16 lg:py-20  bg-slate-900 text-white overflow-hidden">
        <div class="page-header-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <x-breadcrumbs :items="['Katalog' => '']" />
            <h1 class="text-3xl lg:text-4xl font-bold text-white mb-3">Katalog Billboard & Reklame</h1>
            <p class="text-slate-400 text-lg max-w-2xl">Temukan titik reklame terbaik untuk bisnis Anda di berbagai lokasi
                strategis.</p>
        </div>
    </div>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Filters --}}
        <form method="GET" class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-8 dark:bg-slate-800 dark:border-slate-700" x-data="{ showFilters: false }">
            <div class="p-5 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                    </svg>
                    <span class="font-semibold text-slate-900 dark:text-white">Filter</span>
                </div>
                <button type="button" @click="showFilters = !showFilters"
                    class="lg:hidden text-sm text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 font-medium flex items-center gap-1">
                    <span x-text="showFilters ? 'Sembunyikan' : 'Tampilkan'"></span>
                    <svg class="w-4 h-4 transition-transform" :class="showFilters && 'rotate-180'" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>
            <div class="p-5" :class="{ 'hidden lg:block': !showFilters }">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Cari</label>
                        <div class="relative">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nama atau lokasi..."
                                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-400">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kota</label>
                        <select name="city"
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                            <option value="">Semua Kota</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kategori</label>
                        <select name="category"
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Orientasi</label>
                        <select name="orientation"
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                            <option value="">Semua</option>
                            <option value="horizontal" {{ request('orientation') == 'horizontal' ? 'selected' : '' }}>
                                Horizontal</option>
                            <option value="vertical" {{ request('orientation') == 'vertical' ? 'selected' : '' }}>Vertikal
                            </option>
                            <option value="rooftop" {{ request('orientation') == 'rooftop' ? 'selected' : '' }}>Rooftop
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Pencahayaan</label>
                        <select name="light_type"
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                            <option value="">Semua</option>
                            <option value="LED" {{ request('light_type') == 'LED' ? 'selected' : '' }}>LED</option>
                            <option value="Neon" {{ request('light_type') == 'Neon' ? 'selected' : '' }}>Neon</option>
                            <option value="Frontlit" {{ request('light_type') == 'Frontlit' ? 'selected' : '' }}>Frontlit
                            </option>
                            <option value="Backlit" {{ request('light_type') == 'Backlit' ? 'selected' : '' }}>Backlit
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Min. Harga</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-sm font-medium">Rp</span>
                            <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="0"
                                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Max. Harga</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-sm font-medium">Rp</span>
                            <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="0"
                                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Urutkan</label>
                        <select name="sort"
                            class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah
                            </option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga
                                Tertinggi</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg text-sm font-semibold transition-all shadow-md shadow-green-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                        </svg>
                        Terapkan Filter
                    </button>
                    @if (request()->hasAny(['search', 'city', 'category', 'orientation', 'light_type', 'price_min', 'price_max', 'sort']))
                        <a href="{{ route('catalog.index') }}"
                            class="inline-flex items-center gap-2 px-6 py-2.5 border border-slate-300 text-slate-600 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-all dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Results Header --}}
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Menampilkan <span class="font-semibold text-slate-900 dark:text-white">{{ $points->firstItem() ?? 0 }}</span>-<span
                    class="font-semibold text-slate-900 dark:text-white">{{ $points->lastItem() ?? 0 }}</span>
                dari <span class="font-semibold text-slate-900 dark:text-white">{{ $points->total() }}</span> titik reklame
            </p>
        </div>

        {{-- Results --}}
        @if ($points->isEmpty())
            <div class="text-center py-20">
                <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">Tidak Ditemukan</h3>
                <p class="text-slate-500 dark:text-slate-400">Tidak ada titik reklame yang sesuai dengan filter Anda.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($points as $index => $point)
                    <x-product-card :point="$point" aos="aos-fade-up" :aosDelay="$index * 100" />
                @endforeach
            </div>

            @if ($points->hasPages())
                <div class="mt-8">
                    {{ $points->links() }}
                </div>
            @endif
        @endif
    </section>
@endsection

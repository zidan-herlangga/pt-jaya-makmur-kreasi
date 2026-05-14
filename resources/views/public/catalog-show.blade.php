@extends('layouts.app', ['seo' => $seo])

@section('content')
    <div class="page-header py-12">
        <div class="page-header-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <x-breadcrumbs :items="['Katalog' => route('catalog.index'), $point->title => '']" />
        </div>
    </div>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden dark:bg-slate-800 dark:border-slate-700">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                {{-- Image --}}
                <div class="relative aspect-[4/3] lg:aspect-auto bg-slate-100 dark:bg-slate-700">
                    @if ($point->thumbnail)
                        <img src="{{ Storage::url($point->thumbnail) }}" alt="{{ $point->title }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-20 h-20 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span
                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold
                        {{ $point->status === 'available' ? 'bg-emerald-500 text-white' : '' }}
                        {{ $point->status === 'booked' ? 'bg-amber-500 text-white' : '' }}
                        {{ $point->status === 'maintenance' ? 'bg-rose-500 text-white' : '' }}">
                            {{ $point->status_label }}
                        </span>
                    </div>
                </div>

                {{-- Details --}}
                <div class="p-8 lg:p-10 flex flex-col">
                    <div class="mb-2">
                        @if ($point->category)
                            <span
                                class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full dark:text-green-400 dark:bg-green-900/30">{{ $point->category->name }}</span>
                        @endif
                    </div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white mb-4">{{ $point->title }}</h1>

                    <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 mb-6">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $point->location_name }}, {{ $point->city }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        @if ($point->size_dimension)
                            <div class="bg-slate-50 rounded-xl p-4 dark:bg-slate-700/50">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Ukuran</p>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $point->size_dimension }}</p>
                            </div>
                        @endif
                        @if ($point->orientation)
                            <div class="bg-slate-50 rounded-xl p-4 dark:bg-slate-700/50">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Orientasi</p>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ ucfirst($point->orientation) }}</p>
                            </div>
                        @endif
                        @if ($point->light_type)
                            <div class="bg-slate-50 rounded-xl p-4 dark:bg-slate-700/50">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Pencahayaan</p>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $point->light_type }}</p>
                            </div>
                        @endif
                        @if ($point->lat && $point->long)
                            <div class="bg-slate-50 rounded-xl p-4 dark:bg-slate-700/50">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Koordinat</p>
                                <p class="font-semibold text-slate-900 dark:text-white text-sm">{{ $point->lat }}, {{ $point->long }}
                                </p>
                            </div>
                        @endif
                    </div>

                    @if ($point->description)
                        <div class="mb-8">
                            <h2 class="font-semibold text-slate-900 dark:text-white mb-2">Deskripsi</h2>
                            <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">{{ $point->description }}</p>
                        </div>
                    @endif

                    <div class="mt-auto pt-6 border-t border-slate-200 dark:border-slate-700">
                        <div class="flex items-baseline gap-2 mb-5">
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Harga</p>
                            <p class="text-3xl font-bold text-green-600">{{ $point->formatted_price }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('inquiry.create', ['product' => $point->id]) }}"
                                class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3.5 rounded-xl font-semibold transition-all duration-300 shadow-lg shadow-green-500/20 hover:shadow-green-500/40 hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Ajukan Inquiry
                            </a>
                            <a href="{{ $whatsappLink }}" target="_blank" rel="noopener noreferrer"
                                class="flex-1 inline-flex items-center justify-center gap-2 border-2 border-green-500 text-green-600 hover:bg-green-50 dark:text-green-400 dark:border-green-400 dark:hover:bg-green-900/20 px-6 py-3.5 rounded-xl font-semibold transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                Tanya via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gallery --}}
        @if ($point->gallery)
            <div class="my-8" x-data="{ lightbox: null }">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Galeri</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($point->gallery as $img)
                        @if (is_string($img))
                            <button @click="lightbox = '{{ Storage::url($img) }}'"
                                class="rounded-xl overflow-hidden focus:outline-none focus:ring-2 focus:ring-green-500 group">
                                <img src="{{ Storage::url($img) }}" alt="Gallery image"
                                    class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300 cursor-pointer">
                            </button>
                        @endif
                    @endforeach
                </div>

                {{-- Lightbox Modal --}}
                <div x-show="lightbox" x-transition.opacity
                    class="fixed inset-0 z-[60] bg-slate-900/90 backdrop-blur-sm flex items-center justify-center p-4 dark:bg-slate-950/95"
                    @click="lightbox = null">
                    <button @click="lightbox = null"
                        class="absolute top-4 right-4 p-2 text-white hover:text-green-400 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <img :src="lightbox" alt="Gallery preview"
                        class="max-w-full max-h-[90vh] object-contain rounded-2xl" @click.stop>
                </div>
            </div>
        @endif

        {{-- Related --}}
        @if ($relatedPoints->isNotEmpty())
            <div class="mt-16 mb-12">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Titik Reklame Lainnya di {{ $point->city }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedPoints as $related)
                        <x-product-card :point="$related" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection

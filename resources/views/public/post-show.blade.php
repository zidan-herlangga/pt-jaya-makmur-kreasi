@extends('layouts.app', ['seo' => $seo])

@section('content')
    <div class="page-header py-12">
        <div class="page-header-pattern"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <x-breadcrumbs :items="['Berita' => route('posts.index'), $post->title => '']" />
        </div>
    </div>

    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 mb-16" x-data="{ copied: false }">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden">
            @if ($post->featured_image)
                <div class="relative overflow-hidden">
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                        class="w-full h-64 sm:h-80 lg:h-96 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
            @endif
            <div class="p-6 sm:p-8 lg:p-12">
                {{-- Meta --}}
                <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500 mb-5">
                    @if ($post->category)
                        <span class="badge-green">{{ $post->category->name }}</span>
                    @endif
                    <span>{{ $post->published_at?->format('d F Y') }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span>{{ $post->reading_time }} min read</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span>{{ number_format($post->view_count) }} views</span>
                </div>

                {{-- Title --}}
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 mb-6 leading-tight">{{ $post->title }}
                </h1>

                {{-- Author --}}
                @if ($post->author)
                    <div class="flex items-center gap-3 mb-8 pb-6 border-b border-slate-100">
                        <div
                            class="w-11 h-11 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white font-bold shadow-md">
                            {{ strtoupper(substr($post->author->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">{{ $post->author->name }}</p>
                            <p class="text-xs text-slate-500">Penulis</p>
                        </div>
                    </div>
                @endif

                {{-- Content --}}
                <div class="max-w-2xl mx-auto">
                    @php
                        $hasHtml = $post->content_body !== strip_tags($post->content_body);
                    @endphp

                    @if ($hasHtml)
                        <div
                            class="prose prose-lg max-w-none prose-slate prose-headings:font-display prose-headings:font-black prose-headings:tracking-tight prose-a:text-primary-600 prose-img:rounded-3xl prose-blockquote:border-primary-500 prose-blockquote:bg-primary-50 prose-blockquote:py-1 prose-blockquote:px-6">
                            {!! $post->content_body !!}
                        </div>
                    @else
                        <div class="text-slate-600 leading-relaxed space-y-4" style="white-space: pre-wrap;">
                            {{ $post->content_body }}
                        </div>
                    @endif
                </div>

                {{-- Tags / Share --}}
                <div class="mt-10 pt-6 border-t border-slate-200">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-slate-700 mb-2">Bagikan artikel ini:</p>
                        </div>
                        <div class="flex items-center gap-2">
                            {{-- WhatsApp --}}
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . route('posts.show', $post)) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 bg-green-50 hover:bg-green-500 rounded-xl flex items-center justify-center text-green-600 hover:text-white transition-all duration-300 group"
                                aria-label="Bagikan WhatsApp">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                            </a>

                            {{-- X (Twitter) --}}
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title . ' ' . route('posts.show', $post)) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 bg-slate-100 hover:bg-slate-900 rounded-xl flex items-center justify-center text-slate-600 hover:text-white transition-all duration-300 group"
                                aria-label="Bagikan X">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>

                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post)) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 bg-green-50 hover:bg-green-600 rounded-xl flex items-center justify-center text-green-600 hover:text-white transition-all duration-300 group"
                                aria-label="Bagikan Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>

                            {{-- LinkedIn --}}
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('posts.show', $post)) }}&title={{ urlencode($post->title) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 bg-green-50 hover:bg-green-700 rounded-xl flex items-center justify-center text-green-700 hover:text-white transition-all duration-300 group"
                                aria-label="Bagikan LinkedIn">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>

                            {{-- Copy Link --}}
                            <button
                                @click="
                            navigator.clipboard.writeText('{{ route('posts.show', $post) }}');
                            copied = true;
                            setTimeout(() => copied = false, 2000);
                        "
                                class="w-10 h-10 bg-slate-100 hover:bg-slate-900 rounded-xl flex items-center justify-center text-slate-600 hover:text-white transition-all duration-300 group relative"
                                aria-label="Salin Link">
                                <svg x-show="!copied" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                </svg>
                                <svg x-show="copied" class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <span
                                    class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-xs px-2 py-1 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"
                                    x-text="copied ? 'Tersalin!' : 'Salin Link'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Posts --}}
        @if ($relatedPosts->isNotEmpty())
            <div class="mt-16">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Artikel Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($relatedPosts as $related)
                        <article
                            class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            @if ($related->featured_image)
                                <div class="relative overflow-hidden">
                                    <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}"
                                        class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-bold text-slate-900">
                                    <a href="{{ route('posts.show', $related) }}"
                                        class="hover:text-green-600 transition-colors">{{ $related->title }}</a>
                                </h3>
                                <p class="text-xs text-slate-500 mt-2">{{ $related->published_at?->format('d M Y') }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </article>
@endsection

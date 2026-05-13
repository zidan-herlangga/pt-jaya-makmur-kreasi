@extends('layouts.app', ['seo' => $seo])

@section('content')
    <div class="page-header py-16 lg:py-20 bg-slate-900 text-white overflow-hidden">
        <div class="page-header-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <x-breadcrumbs :items="['Berita' => '']" />
            <h1 class="text-3xl lg:text-4xl font-bold text-white mb-3">Berita & Artikel</h1>
            <p class="text-slate-400 text-lg">Informasi dan wawasan seputar dunia reklame dan billboard.</p>
        </div>
    </div>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Categories --}}
        @if ($categories->isNotEmpty())
            <div class="flex flex-wrap gap-2 mb-10">
                <a href="{{ route('posts.index') }}"
                    class="px-4 py-2 rounded-full text-sm font-medium transition-colors
               {{ !request('category') ? 'bg-green-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('posts.index', ['category' => $category->id]) }}"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                   {{ request('category') == $category->id ? 'bg-green-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Posts Grid --}}
        @if ($posts->isEmpty())
            <div class="text-center py-20">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Belum Ada Artikel</h3>
                <p class="text-slate-500">Belum ada berita yang diterbitkan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $index => $post)
                    <article data-aos="aos-fade-up" data-aos-delay="{{ $index * 100 }}"
                        class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all hover:-translate-y-1">
                        @if ($post->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-slate-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-5">
                            @if ($post->category)
                                <span
                                    class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">{{ $post->category->name }}</span>
                            @endif
                            <h2 class="font-bold text-slate-900 mt-2 mb-2 leading-tight">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="hover:text-green-600 transition-colors">{{ $post->title }}</a>
                            </h2>
                            <p class="text-sm text-slate-500 line-clamp-2">{{ $post->excerpt }}</p>
                            <div
                                class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100 text-xs text-slate-400">
                                <span>{{ $post->published_at?->format('d M Y') }}</span>
                                <div class="flex items-center gap-3">
                                    <span>{{ $post->reading_time }} min read</span>
                                    <span>{{ number_format($post->view_count) }} views</span>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($posts->hasPages())
                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
            @endif
        @endif
    </section>
@endsection

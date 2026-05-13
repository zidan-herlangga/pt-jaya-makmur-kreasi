@extends('layouts.app', ['seo' => $seo])

@section('content')
<div class="page-header py-12">
    <div class="page-header-pattern"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <x-breadcrumbs :items="['Portofolio' => route('portofolio.index'), $portfolio->title => '']" />
    </div>
</div>

<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden">
        @if($portfolio->thumbnail)
            <img src="{{ Storage::url($portfolio->thumbnail) }}" alt="{{ $portfolio->title }}" class="w-full h-72 lg:h-96 object-cover">
        @endif
        <div class="p-8 lg:p-12">
            <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500 mb-4">
                @if($portfolio->category)
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">{{ $portfolio->category->name }}</span>
                @endif
                @if($portfolio->client_name)
                    <span>Klien: <strong>{{ $portfolio->client_name }}</strong></span>
                    <span>&middot;</span>
                @endif
                <span>{{ $portfolio->published_at?->format('d F Y') }}</span>
                <span>&middot;</span>
                <span>{{ number_format($portfolio->view_count) }} views</span>
            </div>

            <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-6 leading-tight">{{ $portfolio->title }}</h1>

            <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed">
                {!! nl2br(e($portfolio->description)) !!}
            </div>

            @if($portfolio->images)
                <hr class="border-slate-200 my-8">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Galeri Proyek</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($portfolio->images as $image)
                        <div class="rounded-xl overflow-hidden">
                            <img src="{{ Storage::url($image) }}" alt="" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if($relatedPortfolios->isNotEmpty())
        <div class="mt-16 mb-12">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Proyek Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPortfolios as $related)
                    <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all hover:-translate-y-1">
                        @if($related->thumbnail)
                            <img src="{{ Storage::url($related->thumbnail) }}" alt="{{ $related->title }}" class="w-full h-40 object-cover">
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold text-slate-900">
                                <a href="{{ route('portofolio.show', $related) }}" class="hover:text-green-600 transition-colors">{{ $related->title }}</a>
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

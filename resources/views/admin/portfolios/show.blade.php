@extends('layouts.admin', ['seo' => $seo ?? ['title' => $portfolio->title]])

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.portfolios.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">&larr; Kembali</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $portfolio->title }}</h1>
        </div>
        <a href="{{ route('admin.portfolios.edit', $portfolio) }}"
           class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-semibold transition-colors">
            Edit
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        @if($portfolio->thumbnail)
            <img src="{{ Storage::url($portfolio->thumbnail) }}" class="w-full h-64 object-cover">
        @endif
        <div class="p-6">
            <div class="flex items-center gap-3 text-sm text-slate-500 mb-4">
                @if($portfolio->client_name)
                    <span>Klien: <strong>{{ $portfolio->client_name }}</strong></span>
                    <span>&middot;</span>
                @endif
                <span>{{ $portfolio->published_at?->format('d M Y') ?? 'Draft' }}</span>
                @if($portfolio->category)
                    <span>&middot;</span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded-full">{{ $portfolio->category->name }}</span>
                @endif
                <span>&middot;</span>
                <span>{{ number_format($portfolio->view_count) }} views</span>
            </div>
            <div class="prose prose-sm max-w-none text-slate-600">
                {!! nl2br(e($portfolio->description)) !!}
            </div>

            @if($portfolio->images)
                <hr class="border-slate-200 my-6">
                <h3 class="font-semibold text-slate-900 mb-4">Galeri</h3>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($portfolio->images as $image)
                        <img src="{{ Storage::url($image) }}" class="w-full h-40 object-cover rounded-lg">
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

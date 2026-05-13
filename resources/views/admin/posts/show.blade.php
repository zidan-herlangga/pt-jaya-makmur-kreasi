@extends('layouts.admin', ['seo' => $seo ?? ['title' => $post->title]])

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.posts.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">&larr; Kembali</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $post->title }}</h1>
        </div>
        <a href="{{ route('admin.posts.edit', $post) }}"
           class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-semibold transition-colors">
            Edit
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        @if($post->featured_image)
            <img src="{{ Storage::url($post->featured_image) }}" class="w-full h-64 object-cover">
        @endif
        <div class="p-6">
            <div class="flex items-center gap-3 text-sm text-slate-500 mb-4">
                <span>{{ $post->author?->name ?? '-' }}</span>
                <span>&middot;</span>
                <span>{{ $post->published_at?->format('d M Y') ?? 'Draft' }}</span>
                @if($post->category)
                    <span>&middot;</span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded-full">{{ $post->category->name }}</span>
                @endif
                <span>&middot;</span>
                <span>{{ number_format($post->view_count) }} views</span>
                <span>&middot;</span>
                <span>{{ $post->reading_time }} min read</span>
            </div>
            <div class="prose prose-sm max-w-none prose-headings:text-slate-900 prose-a:text-green-600 prose-img:rounded-lg prose-blockquote:border-green-500 prose-blockquote:bg-green-50 prose-blockquote:py-1 prose-blockquote:px-4 prose-blockquote:rounded-r-xl prose-code:text-green-700 prose-code:bg-green-50 prose-code:px-1 prose-code:rounded prose-pre:bg-slate-900 prose-pre:rounded-lg">
                {!! $post->content_body !!}
            </div>
        </div>
    </div>
</div>
@endsection

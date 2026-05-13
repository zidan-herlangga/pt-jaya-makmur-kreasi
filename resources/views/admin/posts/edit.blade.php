@extends('layouts.admin', ['seo' => $seo ?? ['title' => 'Edit Berita']])

@push('styles')
    <style>
        .tox-tinymce {
            border-radius: 0.75rem !important;
            border-color: #e2e8f0 !important;
        }

        .tox .tox-toolbar__primary {
            background: #f8fafc !important;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.posts.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">&larr;
                Kembali</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">Edit Berita</h1>
        </div>

        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-xl border border-slate-200 p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ autoSlug: true }">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul <span
                            class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" required x-ref="title"
                        @input="if (autoSlug) { $refs.slug.value = $refs.title.value.toLowerCase().replace(/[^\w\s-]/g, '').replace(/[\s_]+/g, '-').replace(/^-+|-+$/g, '') }"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Slug</label>
                    <input type="text" name="slug" x-ref="slug" value="{{ old('slug', $post->slug) }}"
                        @input="autoSlug = false"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                    <select name="category_id"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status <span
                            class="text-rose-500">*</span></label>
                    <select name="status" required
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft
                        </option>
                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>
                            Published</option>
                        <option value="archived" {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>Archived
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Publikasi</label>
                    <input type="datetime-local" name="published_at"
                        value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Featured Image</label>
                    @if ($post->featured_image)
                        <div class="mb-2"><img src="{{ Storage::url($post->featured_image) }}"
                                class="w-32 h-24 object-cover rounded-lg"></div>
                    @endif
                    <input type="file" name="featured_image" accept="image/jpeg,image/png,image/webp"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Konten <span
                            class="text-rose-500">*</span></label>
                    <textarea id="editor" name="content_body" rows="12"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">{{ old('content_body', $post->content_body) }}</textarea>
                </div>

                {{-- <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Konten Berita</label>
                    <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                        <textarea id="editor" name="content_body">{{ old('content_body', $post->content_body ?? '') }}</textarea>
                    </div>
                </div> --}}
            </div>

            <hr class="border-slate-200">
            <h3 class="font-semibold text-slate-900">SEO Settings</h3>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Meta Description</label>
                    <textarea name="meta_description" rows="2"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">{{ old('meta_description', $post->meta_description) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $post->meta_keywords) }}"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg font-semibold text-sm transition-all shadow-md shadow-green-500/20">Perbarui</button>
                <a href="{{ route('admin.posts.index') }}"
                    class="px-6 py-2.5 border border-slate-300 text-slate-600 rounded-lg font-semibold text-sm hover:bg-slate-50 transition-colors">Batal</a>
            </div>
        </form>
    </div>
@endsection

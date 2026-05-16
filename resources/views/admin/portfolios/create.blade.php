@extends('layouts.admin', ['seo' => $seo ?? ['title' => 'Tambah Portfolio']])

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.portfolios.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">&larr; Kembali</a>
        <h1 class="text-2xl font-bold text-slate-900 mt-2">Tambah Portfolio Baru</h1>
        <p class="text-slate-500 mt-1">Tambahkan proyek portofolio reklame baru.</p>
    </div>

    <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-xl border border-slate-200 p-6 space-y-6"
          x-data="galleryManager()" @submit="beforeSubmit">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ autoSlug: true }">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul <span class="text-rose-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required x-ref="title"
                       @input="if (autoSlug) { $refs.slug.value = $refs.title.value.toLowerCase().replace(/[^\w\s-]/g, '').replace(/[\s_]+/g, '-').replace(/^-+|-+$/g, '') }"
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Slug</label>
                <input type="text" name="slug" x-ref="slug" value="{{ old('slug') }}"
                       @input="autoSlug = false"
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                <p class="text-xs text-slate-400 mt-1">Kosongi untuk auto-generate</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Klien</label>
                <input type="text" name="client_name" value="{{ old('client_name') }}"
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                <select name="category_id"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status <span class="text-rose-500">*</span></label>
                <select name="status" required
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Publikasi</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at') }}"
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp"
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <p class="text-xs text-slate-400 mt-1">Maks. 5MB, format: JPG/PNG/WEBP</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Galeri <span class="text-xs text-slate-400">(Maks. 4 gambar)</span></label>
                <input type="hidden" name="deleted_images" value="[]">

                <div class="grid grid-cols-4 gap-3 mt-2" x-show="newFiles.length > 0">
                    <template x-for="(file, index) in newFiles" :key="index">
                        <div class="relative aspect-square rounded-lg overflow-hidden group border border-slate-200 bg-slate-50">
                            <img :src="file.preview" class="w-full h-full object-cover">
                            <button type="button" @click="removeNew(index)"
                                    class="absolute top-1.5 right-1.5 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all shadow-lg">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                </div>

                <div x-show="canAddMore" class="mt-2">
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" @change="addFiles($event)"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>
                <p class="text-xs text-slate-400 mt-1" x-text="statusText"></p>
            </div>
        </div>

        <hr class="border-slate-200">
        <h3 class="font-semibold text-slate-900">SEO Settings</h3>
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Meta Description</label>
                <textarea name="meta_description" rows="2"
                          class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">{{ old('meta_description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Meta Keywords</label>
                <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}"
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg font-semibold text-sm transition-all shadow-md shadow-green-500/20">Simpan</button>
            <a href="{{ route('admin.portfolios.index') }}" class="px-6 py-2.5 border border-slate-300 text-slate-600 rounded-lg font-semibold text-sm hover:bg-slate-50 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection

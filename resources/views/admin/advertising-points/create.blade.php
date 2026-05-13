@extends('layouts.admin', ['seo' => $seo ?? ['title' => 'Tambah Titik Reklame']])

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.advertising-points.index') }}"
                class="text-sm text-green-600 hover:text-green-700 font-medium">&larr; Kembali</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">Tambah Titik Reklame</h1>
            <p class="text-slate-500 mt-1">Lengkapi data billboard atau titik reklame baru.</p>
        </div>

        <form action="{{ route('admin.advertising-points.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-xl border border-slate-200 p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ autoSlug: true }">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul <span
                            class="text-rose-500">*</span></label>
                    <input type="text" name="title" x-ref="title" value="{{ old('title') }}" required
                        @input="if (autoSlug) { $refs.slug.value = $refs.title.value.toLowerCase().replace(/[^\w\s-]/g, '').replace(/[\s_]+/g, '-').replace(/^-+|-+$/g, '') }"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                    @error('title')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Slug</label>
                    <input type="text" name="slug" x-ref="slug" value="{{ old('slug') }}"
                        @input="autoSlug = false"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                    <p class="text-xs text-slate-400 mt-1">Kosongi untuk auto-generate</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kategori <span
                            class="text-rose-500">*</span></label>
                    <select name="category_id" required
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lokasi</label>
                    <input type="text" name="location_name" value="{{ old('location_name') }}"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kota</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Harga</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm">Rp</span>
                        <input type="text" name="price" value="{{ old('price') }}"
                            class="w-full pl-10 pr-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Ukuran (Dimensi)</label>
                    <input type="text" name="size_dimension" value="{{ old('size_dimension') }}"
                        placeholder="cth: 10m x 5m"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Orientasi</label>
                    <select name="orientation"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="">Pilih Orientasi</option>
                        <option value="horizontal" {{ old('orientation') == 'horizontal' ? 'selected' : '' }}>Horizontal
                        </option>
                        <option value="vertical" {{ old('orientation') == 'vertical' ? 'selected' : '' }}>Vertikal</option>
                        <option value="rooftop" {{ old('orientation') == 'rooftop' ? 'selected' : '' }}>Rooftop</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tipe Pencahayaan</label>
                    <select name="light_type"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="">Pilih Tipe</option>
                        <option value="LED" {{ old('light_type') == 'LED' ? 'selected' : '' }}>LED</option>
                        <option value="Neon" {{ old('light_type') == 'Neon' ? 'selected' : '' }}>Neon</option>
                        <option value="Frontlit" {{ old('light_type') == 'Frontlit' ? 'selected' : '' }}>Frontlit</option>
                        <option value="Backlit" {{ old('light_type') == 'Backlit' ? 'selected' : '' }}>Backlit</option>
                        <option value="None" {{ old('light_type') == 'None' ? 'selected' : '' }}>Tanpa Lampu</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status <span
                            class="text-rose-500">*</span></label>
                    <select name="status" required
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Dipesan</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Perawatan
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Publikasi</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at') }}"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Latitude</label>
                    <input type="text" name="lat" value="{{ old('lat') }}"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Longitude</label>
                    <input type="text" name="long" value="{{ old('long') }}"
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
                    <label class="block text-sm font-medium text-slate-700 mb-1">OG Image</label>
                    <input type="file" name="og_image" accept="image/jpeg,image/png,image/webp"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Galeri</label>
                    <input type="file" name="gallery[]" multiple accept="image/jpeg,image/png,image/webp"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>
            </div>

            <hr class="border-slate-200">

            <h3 class="font-semibold text-slate-900">SEO Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Meta Description</label>
                    <textarea name="meta_description" rows="2"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">{{ old('meta_description') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg font-semibold text-sm transition-all shadow-md shadow-green-500/20">
                    Simpan
                </button>
                <a href="{{ route('admin.advertising-points.index') }}"
                    class="px-6 py-2.5 border border-slate-300 text-slate-600 rounded-lg font-semibold text-sm hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

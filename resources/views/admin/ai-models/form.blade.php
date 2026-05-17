@php
    $isEdit = isset($aiModel);
    $title = $isEdit ? 'Edit Model AI' : 'Tambah Model AI';
@endphp

@extends('layouts.admin', ['seo' => ['title' => $title]])

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.ai-models.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7l-7-7 7-7"></path></svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $title }}</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1">{{ $isEdit ? 'Ubah konfigurasi model AI.' : 'Tambahkan model AI baru dari berbagai provider.' }}</p>
    </div>

    <form action="{{ $isEdit ? route('admin.ai-models.update', $aiModel) : route('admin.ai-models.store') }}"
          method="POST" class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-6 space-y-6">
        @csrf
        @if($isEdit) @method('PUT') @endif

        {{-- Provider --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5" for="provider">Provider</label>
            <select name="provider" id="provider" required
                class="input-field dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-400">
                <option value="">Pilih Provider</option>
                @foreach($providers as $value => $label)
                    <option value="{{ $value }}" {{ old('provider', $aiModel->provider ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('provider') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Label --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5" for="label">Label <span class="text-rose-500">*</span></label>
            <input type="text" name="label" id="label" required placeholder="Contoh: OpenAI GPT-4o"
                value="{{ old('label', $aiModel->label ?? '') }}"
                class="input-field dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-400">
            @error('label') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Model ID --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5" for="model">Model ID <span class="text-rose-500">*</span></label>
            <input type="text" name="model" id="model" required placeholder="Contoh: gpt-4o, gemini-2.0-flash"
                value="{{ old('model', $aiModel->model ?? '') }}"
                class="input-field dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-400">
            <p class="text-xs text-slate-400 mt-1">Nama model yang digunakan oleh provider (contoh: <code class="text-xs bg-slate-100 dark:bg-slate-700 px-1 rounded">gpt-4o</code>, <code class="text-xs bg-slate-100 dark:bg-slate-700 px-1 rounded">gemini-2.0-flash</code>)</p>
            @error('model') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- API Key --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5" for="api_key">
                API Key
                @if($isEdit && $aiModel->api_key)
                    <span class="text-xs text-amber-600 dark:text-amber-400 font-normal">(biarkan kosong jika tidak ingin mengubah)</span>
                @endif
            </label>
            <div class="relative" x-data="{ show: false }">
                <input :type="show ? 'text' : 'password'" name="api_key" id="api_key"
                    placeholder="{{ $isEdit && $aiModel->api_key ? '•••••••• (biarkan kosong jika tidak diubah)' : 'sk-...' }}"
                    value="{{ old('api_key') }}"
                    class="input-field pr-10 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-400">
                <button type="button" @click="show = !show"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                </button>
            </div>
            @error('api_key') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Base URL --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5" for="base_url">Base URL <span class="text-xs text-slate-400 font-normal">(opsional)</span></label>
            <input type="url" name="base_url" id="base_url" placeholder="https://api.openai.com/v1"
                value="{{ old('base_url', $aiModel->base_url ?? '') }}"
                class="input-field dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-400">
            <p class="text-xs text-slate-400 mt-1">Kosongkan untuk menggunakan endpoint default provider.</p>
            @error('base_url') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Advanced Settings Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Max Tokens --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5" for="max_tokens">Max Tokens <span class="text-xs text-slate-400 font-normal">(opsional)</span></label>
                <input type="number" name="max_tokens" id="max_tokens" min="1" max="999999" placeholder="4096"
                    value="{{ old('max_tokens', $aiModel->max_tokens ?? '') }}"
                    class="input-field dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-400">
                @error('max_tokens') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Temperature --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5" for="temperature">Temperature <span class="text-xs text-slate-400 font-normal">(opsional)</span></label>
                <input type="number" name="temperature" id="temperature" min="0" max="2" step="0.01" placeholder="0.7"
                    value="{{ old('temperature', $aiModel->temperature ?? '') }}"
                    class="input-field dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-400">
                @error('temperature') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Sort Order --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5" for="sort_order">Urutan <span class="text-xs text-slate-400 font-normal">(opsional)</span></label>
            <input type="number" name="sort_order" id="sort_order" min="0" max="999" placeholder="0"
                value="{{ old('sort_order', $aiModel->sort_order ?? '0') }}"
                class="input-field w-32 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:placeholder:text-slate-400">
            @error('sort_order') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Active Toggle --}}
        <div class="flex items-center gap-3">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" role="switch"
                    {{ old('is_active', $aiModel->is_active ?? false) ? 'checked' : '' }}
                    class="sr-only peer">
                <div class="w-11 h-6 bg-slate-300 dark:bg-slate-600 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-green-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
            </label>
            <div>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Aktifkan Model</span>
                <p class="text-xs text-slate-400">Model yang aktif akan tersedia untuk digunakan di chatbot dan fitur AI lainnya.</p>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
            <button type="submit" class="btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Model' }}
            </button>
            <a href="{{ route('admin.ai-models.index') }}" class="btn-secondary btn-sm">Batal</a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.admin', ['seo' => ['title' => 'Model AI']])

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Model AI</h1>
            <p class="text-slate-500 mt-1">Kelola model AI yang tersedia untuk chatbot dan fitur lainnya. Opsional — cukup aktifkan model yang ingin digunakan.</p>
        </div>
        <a href="{{ route('admin.ai-models.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-4 py-2.5 rounded-lg font-semibold text-sm transition-all shadow-md shadow-green-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Model AI
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4">
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Model</p>
            <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $aiModels->count() }}</p>
        </div>
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/30 rounded-xl p-4">
            <p class="text-sm text-green-700 dark:text-green-400 font-medium">Aktif</p>
            <p class="text-2xl font-bold text-green-800 dark:text-green-300 mt-1">{{ $aiModels->where('is_active', true)->count() }}</p>
        </div>
        <div class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4">
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Nonaktif</p>
            <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $aiModels->where('is_active', false)->count() }}</p>
        </div>
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800/30 rounded-xl p-4">
            <p class="text-sm text-amber-700 dark:text-amber-400 font-medium">Provider</p>
            <p class="text-2xl font-bold text-amber-800 dark:text-amber-300 mt-1">{{ $aiModels->groupBy('provider')->count() }}</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 font-medium">
                    <tr>
                        <th class="px-6 py-4">Provider</th>
                        <th class="px-6 py-4">Label</th>
                        <th class="px-6 py-4">Model</th>
                        <th class="px-6 py-4">API Key</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Urutan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($aiModels as $model)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                                    @switch($model->provider)
                                        @case('openai')
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M22.2819 9.8211a5.9847 5.9847 0 0 0-.5157-4.9108 6.0462 6.0462 0 0 0-6.5095-2.9A6.0651 6.0651 0 0 0 4.9807 4.1818a5.9847 5.9847 0 0 0-3.9977 2.9 6.0462 6.0462 0 0 0 .7427 7.0966 5.9847 5.9847 0 0 0 .5157 4.9107 6.0462 6.0462 0 0 0 6.5095 2.9 6.0651 6.0651 0 0 0 5.1275 3.5456 5.9847 5.9847 0 0 0 3.9977-2.9 6.0462 6.0462 0 0 0-.7427-7.0966zM12.0001 15.75a3.75 3.75 0 1 1 0-7.5 3.75 3.75 0 0 1 0 7.5z"/></svg>
                                        @break
                                        @case('google')
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                                        @break
                                        @case('anthropic')
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0zm5.5 18H14l-2-5.6L10 18H6.5l4.5-12h2l4.5 12z"/></svg>
                                        @break
                                        @default
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    @endswitch
                                    {{ $providers[$model->provider] ?? $model->provider }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-900 dark:text-white">{{ $model->label }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-xs bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded text-slate-600 dark:text-slate-400 font-mono">{{ $model->model }}</code>
                            </td>
                            <td class="px-6 py-4">
                                @if($model->api_key)
                                    <span class="text-xs font-mono text-slate-400 dark:text-slate-500">{{ substr($model->api_key, 0, 8) }}••••••••</span>
                                @else
                                    <span class="text-xs text-amber-600 dark:text-amber-400">Belum diisi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.ai-models.toggle-active', $model) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800"
                                        :class="{{ $model->is_active ? "'bg-green-500'" : "'bg-slate-300 dark:bg-slate-600'" }}">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200"
                                            :class="{{ $model->is_active ? "'translate-x-6'" : "'translate-x-1'" }}"></span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400 text-xs">{{ $model->sort_order }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.ai-models.edit', $model) }}"
                                       class="p-2 text-slate-400 hover:text-green-600 dark:hover:text-green-400 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.ai-models.destroy', $model) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus model AI \"{{ $model->label }}\"?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 dark:text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <p class="mb-1">Belum ada model AI.</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Tambahkan model AI dari berbagai provider untuk digunakan di chatbot dan fitur lainnya.</p>
                                <a href="{{ route('admin.ai-models.create') }}" class="text-green-600 hover:underline font-medium text-sm">Tambah model AI</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

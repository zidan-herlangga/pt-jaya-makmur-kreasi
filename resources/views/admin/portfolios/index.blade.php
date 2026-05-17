@extends('layouts.admin', ['seo' => ['title' => 'Manajemen Portfolio']])

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Portfolio</h1>
            <p class="text-slate-500 mt-1">Kelola portofolio proyek reklame.</p>
        </div>
        <a href="{{ route('admin.portfolios.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-4 py-2.5 rounded-lg font-semibold text-sm transition-all shadow-md shadow-green-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Portfolio
        </a>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div class="bg-green-50 border border-green-100 rounded-xl p-4">
            <p class="text-sm text-green-700 font-medium">Published</p>
            <p class="text-2xl font-bold text-green-800 mt-1">{{ $stats['published'] }}</p>
        </div>
        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
            <p class="text-sm text-amber-700 font-medium">Draft</p>
            <p class="text-2xl font-bold text-amber-800 mt-1">{{ $stats['draft'] }}</p>
        </div>
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
            <p class="text-sm text-slate-600 font-medium">Total</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-4">
        <form method="GET" x-data="{ search: '{{ request('search') }}', status: '{{ request('status') }}', category_id: '{{ request('category_id') }}' }" x-ref="filterForm" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" x-model="search" @input.debounce.500ms="$refs.filterForm.submit()" placeholder="Cari portfolio..."
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
            </div>
            <select name="status" x-model="status" @change="$refs.filterForm.submit()" class="px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                <option value="">Semua Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
            <select name="category_id" x-model="category_id" @change="$refs.filterForm.submit()" class="px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @if(request()->hasAny(['search', 'status', 'category_id']))
                <a href="{{ route('admin.portfolios.index') }}" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden"
         x-data="{
             selectedIds: [],
             get count() { return this.selectedIds.length; },
             toggleSelectAll() {
                 const cbs = document.querySelectorAll('.row-checkbox');
                 if (this.selectedIds.length === cbs.length) { this.selectedIds = []; }
                 else { this.selectedIds = Array.from(cbs).map(cb => cb.value); }
             },
             showBulkDeleteModal: false
         }">
        <div x-show="selectedIds.length > 0" x-cloak
             class="flex items-center justify-between px-6 py-3 bg-green-50 border-b border-green-200">
            <span class="text-sm font-medium text-green-800" x-text="count + ' item dipilih'"></span>
            <div class="flex gap-2">
                <button @click="selectedIds = []" class="px-3 py-1.5 border border-slate-300 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-50 transition-colors">Batal</button>
                <button @click="showBulkDeleteModal = true" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-medium transition-colors">Hapus Massal</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
                        <th class="px-6 py-4 w-12">
                            <input type="checkbox" @click="toggleSelectAll()" :checked="selectedIds.length > 0 && selectedIds.length === document.querySelectorAll('.row-checkbox').length"
                                   class="rounded border-slate-300 text-green-600 focus:ring-green-500">
                        </th>
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">Klien</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Views</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($portfolios as $portfolio)
                        <tr class="hover:bg-slate-50 transition-colors" :class="selectedIds.includes('{{ $portfolio->id }}') && 'bg-green-50'">
                            <td class="px-6 py-4">
                                <input type="checkbox" value="{{ $portfolio->id }}" x-model="selectedIds" class="row-checkbox rounded border-slate-300 text-green-600 focus:ring-green-500">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden shrink-0">
                                        @if($portfolio->thumbnail)
                                            <img src="{{ Storage::url($portfolio->thumbnail) }}" alt="" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-900">{{ $portfolio->title }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $portfolio->client_name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-full">{{ $portfolio->category?->name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $portfolio->status === 'published' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $portfolio->status === 'draft' ? 'bg-amber-50 text-amber-700' : '' }}">
                                    {{ ucfirst($portfolio->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ number_format($portfolio->view_count) }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $portfolio->published_at?->format('d M Y') ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('portofolio.show', $portfolio) }}" target="_blank" class="p-2 text-slate-400 hover:text-green-600 transition-colors" title="Preview">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="p-2 text-slate-400 hover:text-green-600 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                <p>Tidak ada data portfolio.</p>
                                <a href="{{ route('admin.portfolios.create') }}" class="text-green-600 hover:underline mt-1 inline-block">Tambah portfolio baru</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($portfolios->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">{{ $portfolios->links() }}</div>
        @endif

        <div x-show="showBulkDeleteModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center"
             @keydown.window.escape="showBulkDeleteModal = false">
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showBulkDeleteModal = false"></div>
            <div class="relative bg-white rounded-xl shadow-xl p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus</h3>
                <p class="text-sm text-slate-500 mt-2" x-text="'Anda akan menghapus ' + count + ' portfolio. Tindakan ini tidak dapat dibatalkan.'"></p>
                <div class="flex justify-end gap-3 mt-6">
                    <button @click="showBulkDeleteModal = false" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</button>
                    <form method="POST" action="{{ route('admin.portfolios.bulk-destroy') }}">
                        @csrf
                        <template x-for="id in selectedIds" :key="id">
                            <input type="hidden" name="ids[]" :value="id">
                        </template>
                        <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-medium transition-colors">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

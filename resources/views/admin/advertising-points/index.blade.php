@extends('layouts.admin', ['seo' => ['title' => 'Manajemen Titik Reklame']])

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Titik Reklame</h1>
            <p class="text-slate-500 mt-1">Kelola data billboard dan titik reklame Anda.</p>
        </div>
        <a href="{{ route('admin.advertising-points.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-4 py-2.5 rounded-lg font-semibold text-sm transition-all shadow-md shadow-green-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Titik
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-green-50 border border-green-100 rounded-xl p-4">
            <p class="text-sm text-green-700 font-medium">Tersedia</p>
            <p class="text-2xl font-bold text-green-800 mt-1">{{ $stats['available'] }}</p>
        </div>
        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
            <p class="text-sm text-amber-700 font-medium">Dipesan</p>
            <p class="text-2xl font-bold text-amber-800 mt-1">{{ $stats['booked'] }}</p>
        </div>
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
            <p class="text-sm text-slate-600 font-medium">Total</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total'] }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-slate-200 p-4">
        <form method="GET" x-data="{ search: '{{ request('search') }}', city: '{{ request('city') }}', status: '{{ request('status') }}', category_id: '{{ request('category_id') }}' }" x-ref="filterForm" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" x-model="search" @input.debounce.500ms="$refs.filterForm.submit()" placeholder="Cari titik atau lokasi..."
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
            </div>
            <select name="city" x-model="city" @change="$refs.filterForm.submit()" class="px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                <option value="">Semua Kota</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}">{{ $city }}</option>
                @endforeach
            </select>
            <select name="status" x-model="status" @change="$refs.filterForm.submit()" class="px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                <option value="">Semua Status</option>
                <option value="available">Tersedia</option>
                <option value="booked">Dipesan</option>
                <option value="maintenance">Perawatan</option>
            </select>
            <select name="category_id" x-model="category_id" @change="$refs.filterForm.submit()" class="px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @if(request()->hasAny(['search', 'city', 'status', 'category_id']))
                <a href="{{ route('admin.advertising-points.index') }}" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden"
         x-data="{
             selectedIds: [],
             get count() { return this.selectedIds.length; },
             toggleSelectAll() {
                 const cbs = document.querySelectorAll('.row-checkbox');
                 if (this.selectedIds.length === cbs.length) {
                     this.selectedIds = [];
                 } else {
                     this.selectedIds = Array.from(cbs).map(cb => cb.value);
                 }
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
                        <th class="px-6 py-4">Titik</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Views</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($points as $point)
                        <tr class="hover:bg-slate-50 transition-colors" :class="selectedIds.includes('{{ $point->id }}') && 'bg-green-50'">
                            <td class="px-6 py-4">
                                <input type="checkbox" value="{{ $point->id }}" x-model="selectedIds" class="row-checkbox rounded border-slate-300 text-green-600 focus:ring-green-500">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden shrink-0">
                                        @if($point->thumbnail)
                                            <img src="{{ Storage::url($point->thumbnail) }}" alt="" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-900">{{ $point->title }}</p>
                                        <p class="text-xs text-slate-500">{{ $point->category?->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-900">{{ $point->location_name }}</p>
                                <p class="text-xs text-slate-500">{{ $point->city }}</p>
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $point->formatted_price }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.advertising-points.toggle-status', $point) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium transition-colors
                                        {{ $point->status === 'available' ? 'bg-green-50 text-green-700 hover:bg-green-100' : '' }}
                                        {{ $point->status === 'booked' ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : '' }}
                                        {{ $point->status === 'maintenance' ? 'bg-rose-50 text-rose-700 hover:bg-rose-100' : '' }}">
                                        {{ $point->status_label }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ number_format($point->view_count) }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('catalog.show', $point) }}" target="_blank" class="p-2 text-slate-400 hover:text-green-600 transition-colors" title="Preview">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.advertising-points.edit', $point) }}" class="p-2 text-slate-400 hover:text-green-600 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.advertising-points.destroy', $point) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
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
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <p>Tidak ada data titik reklame.</p>
                                <a href="{{ route('admin.advertising-points.create') }}" class="text-green-600 hover:underline mt-1 inline-block">Tambah baru</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($points->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $points->links() }}
            </div>
        @endif

        {{-- Bulk Delete Modal --}}
        <div x-show="showBulkDeleteModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center"
             @keydown.window.escape="showBulkDeleteModal = false">
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showBulkDeleteModal = false"></div>
            <div class="relative bg-white rounded-xl shadow-xl p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus</h3>
                <p class="text-sm text-slate-500 mt-2" x-text="'Anda akan menghapus ' + count + ' titik reklame. Tindakan ini tidak dapat dibatalkan.'"></p>
                <div class="flex justify-end gap-3 mt-6">
                    <button @click="showBulkDeleteModal = false" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</button>
                    <form method="POST" action="{{ route('admin.advertising-points.bulk-destroy') }}">
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

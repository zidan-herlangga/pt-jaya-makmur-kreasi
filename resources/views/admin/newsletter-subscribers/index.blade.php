@extends('layouts.admin', ['seo' => ['title' => 'Newsletter Subscribers']])

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Newsletter Subscribers</h1>
            <p class="text-slate-500 mt-1">Daftar email yang berlangganan newsletter.</p>
        </div>
        <a href="{{ route('admin.newsletter-subscribers.export') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold transition-all shadow-md shadow-green-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
            Export CSV
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <p class="text-sm text-slate-500 font-medium">Total</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-green-50 border border-green-100 rounded-xl p-4">
            <p class="text-sm text-green-700 font-medium">Hari Ini</p>
            <p class="text-2xl font-bold text-green-800 mt-1">{{ $stats['today'] }}</p>
        </div>
        <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4">
            <p class="text-sm text-emerald-700 font-medium">Bulan Ini</p>
            <p class="text-2xl font-bold text-emerald-800 mt-1">{{ $stats['this_month'] }}</p>
        </div>
    </div>

    {{-- Search --}}
    <div class="bg-white rounded-xl border border-slate-200 p-4">
        <form method="GET" x-data="{ search: '{{ request('search') }}' }" x-ref="filterForm" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" x-model="search" @input.debounce.500ms="$refs.filterForm.submit()" placeholder="Cari email..."
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
            </div>
            @if(request()->has('search'))
                <a href="{{ route('admin.newsletter-subscribers.index') }}" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Reset</a>
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
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Tanggal Subscribe</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($subscribers as $i => $subscriber)
                        <tr class="hover:bg-slate-50 transition-colors" :class="selectedIds.includes('{{ $subscriber->id }}') && 'bg-green-50'">
                            <td class="px-6 py-4">
                                <input type="checkbox" value="{{ $subscriber->id }}" x-model="selectedIds" class="row-checkbox rounded border-slate-300 text-green-600 focus:ring-green-500">
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $subscribers->firstItem() + $i }}</td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-900">{{ $subscriber->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-sm">{{ $subscriber->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.newsletter-subscribers.destroy', $subscriber) }}" method="POST"
                                      onsubmit="return confirm('Hapus subscriber ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada subscriber.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($subscribers->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">{{ $subscribers->links() }}</div>
        @endif

        <div x-show="showBulkDeleteModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center"
             @keydown.window.escape="showBulkDeleteModal = false">
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showBulkDeleteModal = false"></div>
            <div class="relative bg-white rounded-xl shadow-xl p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus</h3>
                <p class="text-sm text-slate-500 mt-2" x-text="'Anda akan menghapus ' + count + ' subscriber. Tindakan ini tidak dapat dibatalkan.'"></p>
                <div class="flex justify-end gap-3 mt-6">
                    <button @click="showBulkDeleteModal = false" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</button>
                    <form method="POST" action="{{ route('admin.newsletter-subscribers.bulk-destroy') }}">
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

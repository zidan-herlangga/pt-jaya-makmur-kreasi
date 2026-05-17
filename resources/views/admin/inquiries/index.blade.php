@extends('layouts.admin', ['seo' => ['title' => 'Manajemen Inquiry']])

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Inquiry</h1>
            <p class="text-slate-500 mt-1">Kelola permintaan dan pertanyaan dari pengunjung.</p>
        </div>

        <div class="grid grid-cols-4 gap-4">
            <div class="bg-white border border-slate-200 rounded-xl p-4">
                <p class="text-sm text-slate-500 font-medium">Total</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                <p class="text-sm text-amber-700 font-medium">Pending</p>
                <p class="text-2xl font-bold text-amber-800 mt-1">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-green-50 border border-green-100 rounded-xl p-4">
                <p class="text-sm text-green-700 font-medium">Processed</p>
                <p class="text-2xl font-bold text-green-800 mt-1">{{ $stats['processed'] }}</p>
            </div>
            <div class="bg-rose-50 border border-rose-100 rounded-xl p-4">
                <p class="text-sm text-rose-700 font-medium">Spam</p>
                <p class="text-2xl font-bold text-rose-800 mt-1">{{ $stats['spam'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <form method="GET" x-data="{ search: '{{ request('search') }}', status: '{{ request('status') }}' }" x-ref="filterForm" class="flex flex-wrap gap-3">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" x-model="search" @input.debounce.500ms="$refs.filterForm.submit()"
                        placeholder="Cari nama, email, perusahaan..."
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>
                <select name="status" x-model="status" @change="$refs.filterForm.submit()"
                    class="px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="processed">Processed</option>
                    <option value="spam">Spam</option>
                    <option value="archived">Archived</option>
                </select>
                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.inquiries.index') }}"
                        class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Reset</a>
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
                            <th class="px-6 py-4">Pengirim</th>
                            <th class="px-6 py-4">Produk</th>
                            <th class="px-6 py-4">Pesan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($inquiries as $inquiry)
                            <tr
                                class="hover:bg-slate-50 transition-colors {{ $inquiry->status === 'spam' ? 'opacity-60' : '' }}"
                                :class="selectedIds.includes('{{ $inquiry->id }}') && 'bg-green-50'">
                                <td class="px-6 py-4">
                                    <input type="checkbox" value="{{ $inquiry->id }}" x-model="selectedIds" class="row-checkbox rounded border-slate-300 text-green-600 focus:ring-green-500">
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-slate-900">{{ $inquiry->sender_name }}</p>
                                    <p class="text-xs text-slate-500">{{ $inquiry->sender_email }}</p>
                                    @if ($inquiry->sender_phone)
                                        <p class="text-xs text-slate-400">{{ $inquiry->sender_phone }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($inquiry->product)
                                        <a href="{{ route('admin.advertising-points.show', $inquiry->product) }}"
                                            class="text-green-600 hover:underline">{{ $inquiry->product->title }}</a>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-slate-600 max-w-xs truncate">{{ str($inquiry->message)->limit(80) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $inquiry->status === 'pending' ? 'bg-amber-50 text-amber-700' : '' }}
                                    {{ $inquiry->status === 'processed' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $inquiry->status === 'spam' ? 'bg-rose-50 text-rose-700' : '' }}
                                    {{ $inquiry->status === 'archived' ? 'bg-slate-50 text-slate-600' : '' }}">
                                        {{ ucfirst($inquiry->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-sm">{{ $inquiry->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                                            class="p-2 text-slate-400 hover:text-green-600 transition-colors"
                                            title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </a>
                                        @if ($inquiry->status === 'pending')
                                            <form action="{{ route('admin.inquiries.process', $inquiry) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-green-600 transition-colors"
                                                    title="Tandai diproses">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-rose-600 transition-colors"
                                                title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-400">Tidak ada data inquiry.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($inquiries->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">{{ $inquiries->links() }}</div>
            @endif

            <div x-show="showBulkDeleteModal" x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center"
                 @keydown.window.escape="showBulkDeleteModal = false">
                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showBulkDeleteModal = false"></div>
                <div class="relative bg-white rounded-xl shadow-xl p-6 max-w-md w-full mx-4">
                    <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus</h3>
                    <p class="text-sm text-slate-500 mt-2" x-text="'Anda akan menghapus ' + count + ' inquiry. Tindakan ini tidak dapat dibatalkan.'"></p>
                    <div class="flex justify-end gap-3 mt-6">
                        <button @click="showBulkDeleteModal = false" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</button>
                        <form method="POST" action="{{ route('admin.inquiries.bulk-destroy') }}">
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

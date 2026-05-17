@extends('layouts.admin', ['seo' => ['title' => 'Manajemen Pengguna']])

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Pengguna</h1>
                <p class="text-slate-500 mt-1">Kelola pengguna dan hak akses.</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-4 py-2.5 rounded-lg font-semibold text-sm transition-all shadow-md shadow-green-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pengguna
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <form method="GET" x-data="{ search: '{{ request('search') }}', role: '{{ request('role') }}' }" x-ref="filterForm" class="flex flex-wrap gap-3">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" x-model="search" @input.debounce.500ms="$refs.filterForm.submit()"
                        placeholder="Cari nama atau email..."
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                </div>
                <select name="role" x-model="role" @change="$refs.filterForm.submit()"
                    class="px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                    <option value="">Semua Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
                @if (request()->hasAny(['search', 'role']))
                    <a href="{{ route('admin.users.index') }}"
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
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Terakhir Login</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50 transition-colors" :class="selectedIds.includes('{{ $user->id }}') && 'bg-green-50'">
                                <td class="px-6 py-4">
                                    <input type="checkbox" value="{{ $user->id }}" x-model="selectedIds" class="row-checkbox rounded border-slate-300 text-green-600 focus:ring-green-500">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-semibold text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-slate-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-full">{{ ucfirst($role->name) }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->is_active)
                                        <span class="text-green-600 text-xs font-medium">Aktif</span>
                                    @else
                                        <span class="text-rose-600 text-xs font-medium">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-xs">
                                    {{ $user->last_login_at?->diffForHumans() ?? '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="p-2 text-slate-400 hover:text-green-600 transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-rose-600 transition-colors"
                                                    title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-400">Tidak ada data pengguna.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">{{ $users->links() }}</div>
            @endif

            <div x-show="showBulkDeleteModal" x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center"
                 @keydown.window.escape="showBulkDeleteModal = false">
                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showBulkDeleteModal = false"></div>
                <div class="relative bg-white rounded-xl shadow-xl p-6 max-w-md w-full mx-4">
                    <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus</h3>
                    <p class="text-sm text-slate-500 mt-2" x-text="'Anda akan menghapus ' + count + ' pengguna. Tindakan ini tidak dapat dibatalkan.'"></p>
                    <div class="flex justify-end gap-3 mt-6">
                        <button @click="showBulkDeleteModal = false" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</button>
                        <form method="POST" action="{{ route('admin.users.bulk-destroy') }}">
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

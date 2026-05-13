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
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, perusahaan..."
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
            </div>
            <select name="status" class="px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                <option value="spam" {{ request('status') == 'spam' ? 'selected' : '' }}>Spam</option>
                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm font-medium hover:bg-slate-800 transition-colors">Filter</button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.inquiries.index') }}" class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
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
                        <tr class="hover:bg-slate-50 transition-colors {{ $inquiry->status === 'spam' ? 'opacity-60' : '' }}">
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-900">{{ $inquiry->sender_name }}</p>
                                <p class="text-xs text-slate-500">{{ $inquiry->sender_email }}</p>
                                @if($inquiry->sender_phone)
                                    <p class="text-xs text-slate-400">{{ $inquiry->sender_phone }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($inquiry->product)
                                    <a href="{{ route('admin.advertising-points.show', $inquiry->product) }}" class="text-green-600 hover:underline">{{ $inquiry->product->title }}</a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-600 max-w-xs truncate">{{ str($inquiry->message)->limit(80) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $inquiry->status === 'pending' ? 'bg-amber-50 text-amber-700' : '' }}
                                    {{ $inquiry->status === 'processed' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $inquiry->status === 'spam' ? 'bg-rose-50 text-rose-700' : '' }}
                                    {{ $inquiry->status === 'archived' ? 'bg-slate-50 text-slate-600' : '' }}">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-sm">{{ $inquiry->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="p-2 text-slate-400 hover:text-green-600 transition-colors" title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </a>
                                    @if($inquiry->status === 'pending')
                                        <form action="{{ route('admin.inquiries.process', $inquiry) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-green-600 transition-colors" title="Tandai diproses">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">Tidak ada data inquiry.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($inquiries->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">{{ $inquiries->links() }}</div>
        @endif
    </div>
</div>
@endsection

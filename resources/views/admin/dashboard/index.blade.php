@extends('layouts.admin', ['seo' => ['title' => 'Dashboard']])

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
            <p class="text-slate-500 mt-1 text-sm">Ringkasan aktivitas dan performa sistem.</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ now()->format('l, d F Y') }}</span>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Titik Reklame</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total_points'] }}</p>
                </div>
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-1 text-xs text-green-600">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                <span>{{ $stats['total_points'] }} titik tersedia</span>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Tersedia</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['available_points'] }}</p>
                </div>
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100">
                <div class="w-full bg-slate-100 rounded-full h-1.5">
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $stats['total_points'] > 0 ? round(($stats['available_points'] / $stats['total_points']) * 100) : 0 }}%"></div>
                </div>
                <p class="text-xs text-slate-400 mt-1">{{ $stats['total_points'] > 0 ? round(($stats['available_points'] / $stats['total_points']) * 100) : 0 }}% dari total</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Dipesan</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">{{ $stats['booked_points'] }}</p>
                </div>
                <div class="w-11 h-11 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100">
                <div class="w-full bg-slate-100 rounded-full h-1.5">
                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $stats['total_points'] > 0 ? round(($stats['booked_points'] / $stats['total_points']) * 100) : 0 }}%"></div>
                </div>
                <p class="text-xs text-slate-400 mt-1">{{ $stats['total_points'] > 0 ? round(($stats['booked_points'] / $stats['total_points']) * 100) : 0 }}% dari total</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Inquiry Baru</p>
                    <p class="text-2xl font-bold text-rose-600 mt-1">{{ $stats['pending_inquiries'] }}</p>
                </div>
                <div class="w-11 h-11 bg-rose-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100">
                <a href="{{ route('admin.inquiries.index') }}" class="inline-flex items-center gap-1 text-xs text-rose-600 hover:text-rose-700 font-medium">
                    Lihat semua inquiry
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Inquiries --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <h2 class="font-semibold text-slate-900">Inquiry Terbaru</h2>
                </div>
                <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium transition-colors">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentInquiries as $inquiry)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors group">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-sm shrink-0">
                                {{ strtoupper(substr($inquiry->sender_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900 group-hover:text-green-600 transition-colors">{{ $inquiry->sender_name }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ str($inquiry->message)->limit(60) }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400 whitespace-nowrap">{{ $inquiry->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        <p class="text-sm text-slate-400">Belum ada inquiry</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Popular Points --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                    <h2 class="font-semibold text-slate-900">Titik Populer</h2>
                </div>
                <a href="{{ route('admin.advertising-points.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium transition-colors">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($popularPoints as $point)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors group">
                        <div>
                            <p class="text-sm font-medium text-slate-900 group-hover:text-green-600 transition-colors">{{ $point->title }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $point->location_name }}, {{ $point->city }}</p>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            {{ number_format($point->view_count) }}
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <p class="text-sm text-slate-400">Belum ada data</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

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

    {{-- Welcome Card with Last Login --}}
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg shadow-green-500/20 p-6 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold">Selamat datang, {{ auth()->user()->name }}!</h2>
                @if(auth()->user()->last_login_at)
                    <p class="text-green-100 text-sm mt-1">
                        Terakhir login
                        <span class="font-medium text-white">{{ auth()->user()->last_login_at->diffForHumans() }}</span>
                        @if(auth()->user()->last_login_ip)
                            dari IP <span class="font-medium text-white">{{ auth()->user()->last_login_ip }}</span>
                        @endif
                    </p>
                @else
                    <p class="text-green-100 text-sm mt-1">Ini adalah pertama kalinya Anda login.</p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white/15 backdrop-blur-sm rounded-xl px-4 py-2.5 text-center">
                    <p class="text-2xl font-bold">{{ $stats['pending_inquiries'] }}</p>
                    <p class="text-xs text-green-100">Inquiry Baru</p>
                </div>
            </div>
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

    {{-- Activity Log --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                <h2 class="font-semibold text-slate-900">Aktivitas Terbaru</h2>
            </div>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($recentActivities as $log)
                <div class="px-6 py-3.5 flex items-start gap-3 hover:bg-slate-50 transition-colors">
                    <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center shrink-0 mt-0.5">
                        @if($log->action === 'login')
                            <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                        @elseif($log->action === 'logout')
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                        @elseif($log->action === 'created')
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        @elseif($log->action === 'updated')
                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        @elseif($log->action === 'deleted')
                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        @else
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-slate-900">
                            <span class="font-medium">{{ $log->user?->name }}</span>
                            {{ $log->description }}
                        </p>
                        <p class="text-xs text-slate-400 mt-0.5 flex items-center gap-2">
                            <span>{{ $log->created_at->diffForHumans() }}</span>
                            @if($log->ip_address)
                                <span>&middot;</span>
                                <span>{{ $log->ip_address }}</span>
                            @endif
                        </p>
                    </div>
                    @if($log->action === 'login')
                        <span class="text-[10px] font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full shrink-0">Login</span>
                    @elseif($log->action === 'logout')
                        <span class="text-[10px] font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full shrink-0">Logout</span>
                    @endif
                </div>
            @empty
                <div class="px-6 py-10 text-center">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm text-slate-400">Belum ada aktivitas</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

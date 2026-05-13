@extends('layouts.admin', ['seo' => $seo ?? ['title' => $advertisingPoint->title]])

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.advertising-points.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">&larr; Kembali</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $advertisingPoint->title }}</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('catalog.show', $advertisingPoint) }}" target="_blank"
               class="px-4 py-2 border border-slate-300 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                Lihat Publik
            </a>
            <a href="{{ route('admin.advertising-points.edit', $advertisingPoint) }}"
               class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-semibold transition-colors">
                Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Image --}}
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                @if($advertisingPoint->thumbnail)
                    <img src="{{ Storage::url($advertisingPoint->thumbnail) }}" alt="{{ $advertisingPoint->title }}" class="w-full h-72 object-cover">
                @else
                    <div class="w-full h-72 bg-slate-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
            </div>

            {{-- Description --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h2 class="font-semibold text-slate-900 mb-3">Deskripsi</h2>
                <p class="text-slate-600 text-sm leading-relaxed">{{ $advertisingPoint->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>

            {{-- Gallery --}}
            @if($advertisingPoint->gallery)
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h2 class="font-semibold text-slate-900 mb-3">Galeri</h2>
                <div class="grid grid-cols-3 gap-3">
                    @foreach($advertisingPoint->gallery as $img)
                        @if (is_string($img))
                            <img src="{{ Storage::url($img) }}" class="w-full h-32 object-cover rounded-lg">
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 p-5 space-y-4">
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">Status</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium mt-1
                        {{ $advertisingPoint->status === 'available' ? 'bg-green-50 text-green-700' : '' }}
                        {{ $advertisingPoint->status === 'booked' ? 'bg-amber-50 text-amber-700' : '' }}
                        {{ $advertisingPoint->status === 'maintenance' ? 'bg-rose-50 text-rose-700' : '' }}">
                        {{ $advertisingPoint->status_label }}
                    </span>
                </div>

                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">Harga</p>
                    <p class="text-lg font-bold text-slate-900 mt-1">{{ $advertisingPoint->formatted_price }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">Kategori</p>
                    <p class="text-sm text-slate-900 mt-1">{{ $advertisingPoint->category?->name ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">Lokasi</p>
                    <p class="text-sm text-slate-900 mt-1">{{ $advertisingPoint->location_name }}</p>
                    <p class="text-sm text-slate-500">{{ $advertisingPoint->city }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">Dimensi</p>
                    <p class="text-sm text-slate-900 mt-1">{{ $advertisingPoint->size_dimension ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">Orientasi</p>
                    <p class="text-sm text-slate-900 mt-1">{{ ucfirst($advertisingPoint->orientation ?? '-') }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">Pencahayaan</p>
                    <p class="text-sm text-slate-900 mt-1">{{ $advertisingPoint->light_type ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">Dilihat</p>
                    <p class="text-sm text-slate-900 mt-1">{{ number_format($advertisingPoint->view_count) }} kali</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">Dibuat</p>
                    <p class="text-sm text-slate-900 mt-1">{{ $advertisingPoint->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            {{-- Inquiries --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <h3 class="font-semibold text-slate-900 mb-3">Inquiry Terkait</h3>
                @forelse($advertisingPoint->inquiries as $inquiry)
                    <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ $inquiry->sender_name }}</p>
                            <p class="text-xs text-slate-500">{{ $inquiry->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $inquiry->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700' }}">
                            {{ $inquiry->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">Belum ada inquiry</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

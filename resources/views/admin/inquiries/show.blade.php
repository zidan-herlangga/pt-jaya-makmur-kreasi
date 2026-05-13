@extends('layouts.admin', ['seo' => ['title' => 'Detail Inquiry']])

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">&larr; Kembali</a>
        <h1 class="text-2xl font-bold text-slate-900 mt-2">Detail Inquiry</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h2 class="font-semibold text-slate-900 mb-4">Pesan</h2>
                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-wrap">{{ $inquiry->message }}</p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h2 class="font-semibold text-slate-900 mb-4">Admin Notes</h2>
                <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <textarea name="admin_notes" rows="3"
                              class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none mb-3">{{ old('admin_notes', $inquiry->admin_notes) }}</textarea>
                    <div class="flex items-center gap-3">
                        <select name="status"
                                class="px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                            <option value="pending" {{ $inquiry->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processed" {{ $inquiry->status === 'processed' ? 'selected' : '' }}>Processed</option>
                            <option value="spam" {{ $inquiry->status === 'spam' ? 'selected' : '' }}>Spam</option>
                            <option value="archived" {{ $inquiry->status === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-semibold transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 p-5 space-y-4">
                <h3 class="font-semibold text-slate-900">Info Pengirim</h3>
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium">Nama</p>
                    <p class="text-sm text-slate-900 mt-0.5">{{ $inquiry->sender_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium">Email</p>
                    <a href="mailto:{{ $inquiry->sender_email }}" class="text-sm text-green-600 hover:underline mt-0.5 block">{{ $inquiry->sender_email }}</a>
                </div>
                @if($inquiry->sender_phone)
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium">Telepon</p>
                    <a href="tel:{{ $inquiry->sender_phone }}" class="text-sm text-slate-900 mt-0.5 block">{{ $inquiry->sender_phone }}</a>
                </div>
                @endif
                @if($inquiry->company_name)
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium">Perusahaan</p>
                    <p class="text-sm text-slate-900 mt-0.5">{{ $inquiry->company_name }}</p>
                </div>
                @endif
                <hr>
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium">Status</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium mt-1
                        {{ $inquiry->status === 'pending' ? 'bg-amber-50 text-amber-700' : '' }}
                        {{ $inquiry->status === 'processed' ? 'bg-green-50 text-green-700' : '' }}
                        {{ $inquiry->status === 'spam' ? 'bg-rose-50 text-rose-700' : '' }}
                        {{ $inquiry->status === 'archived' ? 'bg-slate-50 text-slate-600' : '' }}">
                        {{ ucfirst($inquiry->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium">Dikirim</p>
                    <p class="text-sm text-slate-900 mt-0.5">{{ $inquiry->created_at->format('d M Y H:i') }}</p>
                </div>
                @if($inquiry->handled_at)
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium">Diproses</p>
                    <p class="text-sm text-slate-900 mt-0.5">{{ $inquiry->handled_at->format('d M Y H:i') }}</p>
                </div>
                @endif
                @if($inquiry->product)
                <div>
                    <p class="text-xs text-slate-500 uppercase font-medium">Produk Terkait</p>
                    <a href="{{ route('admin.advertising-points.show', $inquiry->product) }}" class="text-sm text-green-600 hover:underline mt-0.5 block">{{ $inquiry->product->title }}</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

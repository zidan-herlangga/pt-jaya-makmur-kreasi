@extends('layouts.app', ['seo' => ['title' => 'Oops! Halaman Hilang']])

@section('content')
    <div class="relative min-h-screen flex items-center justify-center px-4 overflow-hidden bg-slate-50">
        {{-- Elemen Dekoratif Background --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div
                class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-green-200/40 rounded-full blur-[120px] animate-pulse">
            </div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-emerald-200/40 rounded-full blur-[120px] animate-pulse"
                style="animation-delay: 2s"></div>
        </div>

        <div class="relative text-center max-w-2xl z-10">
            {{-- Bagian Visual 404 --}}
            <div class="relative inline-block">
                <div
                    class="text-[120px] md:text-[180px] font-black leading-none tracking-tighter text-slate-200 select-none opacity-50">
                    404
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div
                        class="text-[80px] md:text-[120px] font-black leading-none bg-clip-text text-transparent bg-gradient-to-b from-green-500 to-emerald-700 drop-shadow-2xl animate-bounce">
                        ?
                    </div>
                </div>
            </div>

            {{-- Pesan Kesalahan --}}
            <div class="mt-2 space-y-4">
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Waduh! Halaman "Nyasar".
                </h1>
                <p class="text-slate-500 text-lg max-w-md mx-auto leading-relaxed">
                    Sepertinya halaman yang Anda tuju sudah pindah alamat atau sedang bersembunyi. Jangan khawatir, yuk
                    balik ke jalan yang benar.
                </p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('home') }}"
                    class="group relative inline-flex items-center gap-3 bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold text-base transition-all hover:bg-slate-800 hover:-translate-y-1 active:scale-95 shadow-xl shadow-slate-200">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali Ke Beranda
                </a>

                <a href="{{ route('catalog.index') }}"
                    class="inline-flex items-center gap-3 bg-white border-2 border-slate-200 text-slate-700 hover:border-green-500 hover:text-green-600 px-8 py-4 rounded-2xl font-bold text-base transition-all hover:-translate-y-1 active:scale-95 shadow-sm">
                    Jelajahi Katalog
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </a>
            </div>

            {{-- Support Link (Opsional) --}}
            <div class="mt-12 pt-8 border-t border-slate-200">
                <p class="text-sm text-slate-400">
                    Mengalami kendala teknis? <a href="{{ route('inquiry.create') }}"
                        class="text-green-600 hover:underline font-medium">Laporkan Masalah</a>
                </p>
            </div>
        </div>
    </div>
@endsection

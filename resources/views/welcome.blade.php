@extends('layouts.app', ['seo' => ['title' => config('app.name'), 'description' => 'PT. Jaya Makmur - Jasa reklame profesional untuk branding bisnis Anda. Tersedia billboard, neon box, dan media luar ruang di berbagai kota besar Indonesia.']])

@section('content')
    <div class="bg-slate-900 text-white min-h-screen flex items-center">
        <div class="max-w-3xl mx-auto text-center px-6">
            <div
                class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-blue-500/20">
                <span class="text-white font-bold text-2xl">JM</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-extrabold mb-4">PT. Jaya Makmur</h1>
            <p class="text-xl text-slate-400 mb-8">Solusi Reklame Profesional & Terpercaya</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('catalog.index') }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-blue-500/20">
                    Lihat Katalog
                </a>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-semibold border border-white/20 backdrop-blur-sm transition-all">
                    Admin Login
                </a>
            </div>
        </div>
    </div>
@endsection

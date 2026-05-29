@extends('layouts.app', ['seo' => $seo ?? null])

@section('content')
<section class="py-20 lg:py-28">
    <div class="max-w-lg mx-auto px-4 text-center" data-aos="fade-up">
        <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>
        <h1 class="text-2xl lg:text-3xl font-bold text-slate-900 mb-3">Berhasil Berhenti Berlangganan</h1>
        <p class="text-slate-500 leading-relaxed mb-8">Anda telah berhasil berhenti berlangganan newsletter kami. Jika ini adalah kesalahan, Anda dapat mendaftar kembali kapan saja melalui website kami.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-all">
            Kembali ke Beranda
        </a>
    </div>
</section>
@endsection
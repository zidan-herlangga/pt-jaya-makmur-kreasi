@extends('layouts.app', ['seo' => $seo])

@section('content')
    @php
        $aboutBanners = collect([setting('about_banner_1'), setting('about_banner_2')])
            ->filter()
            ->values();
    @endphp

    {{-- Banner Section --}}
    <section class="relative bg-slate-900 text-white overflow-hidden" x-data="{
        current: 0,
        banners: @json($aboutBanners->map(fn($b) => Storage::url($b))),
        get hasBanners() { return this.banners.length > 0 },
        timer: null,
        start() {
            if (!this.hasBanners || this.banners.length < 2) return;
            this.timer = setInterval(() => { this.current = (this.current + 1) % this.banners.length }, 5000)
        },
        stop() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null
            }
        },
        goTo(i) {
            this.stop();
            this.current = i;
            this.start()
        }
    }" x-init="start()">
        <div class="relative h-[40vh] lg:h-[50vh] min-h-[320px] flex items-center">
            {{-- Banner Images --}}
            <template x-if="hasBanners">
                <div class="absolute inset-0">
                    <template x-for="(banner, i) in banners" :key="i">
                        <div x-show="current === i" x-transition:enter="transition-all duration-700"
                            x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
                            class="absolute inset-0 bg-cover bg-center" :style="'background-image: url(' + banner + ')'">
                        </div>
                    </template>
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/70 via-slate-900/50 to-slate-900/70">
                    </div>
                </div>
            </template>
            {{-- Fallback --}}
            <template x-if="!hasBanners">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-10 right-10 w-80 h-80 bg-green-500 rounded-full blur-[120px]"></div>
                        <div class="absolute bottom-10 left-10 w-60 h-60 bg-emerald-500 rounded-full blur-[100px]"></div>
                    </div>
                </div>
            </template>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-3xl" data-aos="fade-up">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-full text-green-400 text-sm font-medium mb-4">
                        Tentang Kami
                    </span>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight">
                        Mitra Reklame <br>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400">Terpercaya
                            Anda</span>
                    </h1>
                </div>
            </div>
        </div>

        {{-- Banner Dots --}}
        <div x-show="hasBanners && banners.length > 1"
            class="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 flex items-center gap-2">
            <template x-for="(banner, i) in banners" :key="i">
                <button @click="goTo(i)" class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                    :class="current === i ? 'bg-white w-8' : 'bg-white/40 hover:bg-white/60'"></button>
            </template>
        </div>
    </section>

    {{-- Company Profile --}}
    <section class="py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div data-aos="fade-right">
                    <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Profil Perusahaan</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mt-2 mb-6">
                        {{ setting('site_name', 'PT. Jaya Makmur') }}
                    </h2>
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        <p>
                            {{ setting('site_name', 'PT. Jaya Makmur Kreasi') }} adalah perusahaan yang bergerak di bidang
                            Advertising,
                            Packaging, dan Warehousing
                        </p>
                        <p>
                            PT Jaya Makmur Kreasi adalah berkomitmen memberikan solusi profesional
                            sesuai dengan kebutuhan setiap klien. Dengan didukung oleh tim yang
                            berpengalaman, kami menghadirkan layanan yang inovatif, efisien, dan
                            berkualitas untuk membantu meningkatkan nilai serta pertumbuhan bisnis klien.
                        </p>
                        <p>
                            Kami percaya bahwa kemitraan jangka panjang dan kepuasan pelanggan
                            merupakan kunci utama dalam menciptakan hasil terbaik, karena bagi kami
                            keberhasilan Anda adalah keberhasilan kami.
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
                    <div class="bg-green-50 rounded-2xl p-6 lg:p-8 text-center">
                        <p class="text-3xl lg:text-4xl font-bold text-green-600">{{ $pointCount }}+</p>
                        <p class="text-sm text-slate-500 mt-1">Titik Reklame</p>
                    </div>
                    <div class="bg-emerald-50 rounded-2xl p-6 lg:p-8 text-center">
                        <p class="text-3xl lg:text-4xl font-bold text-emerald-600">{{ $portfolioCount }}+</p>
                        <p class="text-sm text-slate-500 mt-1">Proyek Selesai</p>
                    </div>
                    <div class="bg-emerald-50 rounded-2xl p-6 lg:p-8 text-center">
                        <p class="text-3xl lg:text-4xl font-bold text-emerald-600">{{ count($cities) }}</p>
                        <p class="text-sm text-slate-500 mt-1">Kota Tersedia</p>
                    </div>
                    <div class="bg-green-50 rounded-2xl p-6 lg:p-8 text-center">
                        <p class="text-3xl lg:text-4xl font-bold text-green-600">{{ $postCount }}+</p>
                        <p class="text-sm text-slate-500 mt-1">Artikel & Berita</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Visi Misi --}}
    <section class="bg-slate-50 py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-aos="fade-up">
                <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Visi & Misi</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mt-2">Komitmen Kami</h2>
                <p class="text-slate-500 mt-2 max-w-2xl mx-auto">Nilai-nilai yang menjadi fondasi setiap langkah kami.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl p-8 lg:p-10 border border-slate-200 shadow-sm" data-aos="fade-up">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Visi</h3>
                    <p class="text-slate-500 leading-relaxed">Menjadi penyedia solusi kebutuhan rumah tangga, perlengkapan
                        interior, dan kerajinan tangan yang terpercaya dengan mengutamakan kualitas produk lokal dan
                        kemudahan akses bagi pelanggan di seluruh Indonesia.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 lg:p-10 border border-slate-200 shadow-sm" data-aos="fade-up"
                    data-aos-delay="100">
                    <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Misi</h3>
                    <ul class="space-y-3 text-slate-500">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <span><b>Kualitas Terjamin:</b> Menyediakan produk-produk berkualitas, mulai dari kerajinan
                                bambu
                                tradisional
                                hingga sistem dekorasi jendela modern (blinds), yang memiliki daya tahan tinggi.
                            </span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <span><b>Pelayanan Profesional:</b> Memberikan pengalaman belanja yang mudah dan responsif
                                melalui
                                berbagai
                                kanal digital (Marketplace dan Landing Page).
                            </span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <span><b>Dukungan Produk Lokal:</b> Memberdayakan potensi kerajinan lokal (seperti besek dan
                                perabotan
                                kayu) untuk bersaing di pasar modern.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <span><b>Inovasi Layanan:</b> Terus memperbarui sistem pemesanan dan pembayaran agar
                                lebih praktis dan aman bagi pembeli.
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Why Choose Us --}}
    <section class="py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-aos="fade-up">
                <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Keunggulan</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mt-2">Mengapa Memilih Kami?</h2>
                <p class="text-slate-500 mt-2 max-w-2xl mx-auto">Kami berkomitmen memberikan yang terbaik untuk setiap
                    klien.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ([['icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'title' => 'Terpercaya & Profesional', 'desc' => 'Berpengalaman dalam industri reklame dengan ribuan proyek sukses di seluruh Indonesia.'], ['icon' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z', 'title' => 'Lokasi Strategis', 'desc' => 'Titik reklame di lokasi premium dengan trafik tinggi di berbagai kota besar Indonesia.'], ['icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Proses Cepat', 'desc' => 'Dari konsultasi hingga pemasangan, tim kami siap membantu dengan proses yang cepat dan efisien.']] as $item)
                    <div class="group bg-white rounded-2xl p-8 lg:p-10 border border-slate-200 hover:border-green-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
                        data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                        <div
                            class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center mb-5 group-hover:bg-gradient-to-br group-hover:from-green-600 group-hover:to-emerald-600 transition-all duration-300">
                            <svg class="w-7 h-7 text-green-600 group-hover:text-white transition-all duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $item['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $item['title'] }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Latest Portfolios --}}
    @if ($latestPortfolios->isNotEmpty())
        <section class="bg-slate-50 py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10" data-aos="fade-up">
                    <div>
                        <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Karya Terbaru</span>
                        <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mt-1">Portofolio Terkini</h2>
                        <p class="text-slate-500 mt-2">Proyek reklame yang telah kami kerjakan.</p>
                    </div>
                    <a href="{{ route('portofolio.index') }}"
                        class="hidden sm:inline-flex items-center gap-1 text-green-600 hover:text-green-700 font-semibold text-sm transition-colors mt-2">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($latestPortfolios as $index => $portfolio)
                        <article data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                            class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="relative aspect-[4/3] overflow-hidden">
                                @if ($portfolio->thumbnail)
                                    <img src="{{ Storage::url($portfolio->thumbnail) }}" alt="{{ $portfolio->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                @if ($portfolio->category)
                                    <div class="absolute top-3 left-3">
                                        <span
                                            class="bg-slate-900/80 backdrop-blur-sm text-white text-xs font-medium px-2.5 py-1 rounded-full">{{ $portfolio->category->name }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-slate-900 text-lg leading-tight mb-1">
                                    <a href="{{ route('portofolio.show', $portfolio) }}"
                                        class="hover:text-green-600 transition-colors">{{ $portfolio->title }}</a>
                                </h3>
                                @if ($portfolio->client_name)
                                    <p class="text-sm text-slate-500">Klien: {{ $portfolio->client_name }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800 py-20 lg:py-28 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-10 w-80 h-80 bg-green-500 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-10 left-10 w-60 h-60 bg-emerald-500 rounded-full blur-[100px]"></div>
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative" data-aos="fade-up">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Siap Bekerja Sama dengan Kami?</h2>
            <p class="text-slate-400 text-lg mb-10 max-w-2xl mx-auto">Konsultasikan kebutuhan reklame Anda dengan tim
                profesional kami. Gratis!</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('inquiry.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-2xl shadow-green-500/20 hover:shadow-green-500/40">
                    Konsultasi Gratis
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                <a href="{{ route('catalog.index') }}"
                    class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-xl font-bold text-lg backdrop-blur-sm transition-all duration-300 border border-white/20 hover:border-white/30">
                    Jelajahi Katalog
                </a>
            </div>
        </div>
    </section>
@endsection

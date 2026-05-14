@extends('layouts.app', ['seo' => $seo])

@section('content')
    @php
        $heroBanners = collect([setting('home_banner_1'), setting('home_banner_2'), setting('home_banner_3')])
            ->filter()
            ->values();
    @endphp

    {{-- Hero / Banner Carousel --}}
    <section class="relative bg-slate-900 text-white min-h-screen flex items-center overflow-hidden" x-data="{
        current: 0,
        banners: {{ \Illuminate\Support\Js::from($heroBanners->map(fn($b) => Storage::url($b))) }},
        get hasBanners() { return this.banners.length > 0 },
        autoplayTimer: null,
    
        init() {
            if (this.hasBanners && this.banners.length > 1) {
                this.startAutoplay();
            }
        },
    
        startAutoplay() {
            this.stopAutoplay();
            this.autoplayTimer = setInterval(() => {
                this.next(false);
            }, 5000);
        },
    
        stopAutoplay() {
            if (this.autoplayTimer) clearInterval(this.autoplayTimer);
            this.autoplayTimer = null;
        },
    
        goTo(i) {
            this.current = i;
            this.startAutoplay();
        },
    
        next(reset = true) {
            this.current = (this.current + 1) % this.banners.length;
            if (reset) this.startAutoplay();
        },
    
        prev() {
            this.current = (this.current - 1 + this.banners.length) % this.banners.length;
            this.startAutoplay();
        }
    }">
        {{-- Banner Images --}}
        <template x-if="hasBanners">
            <div class="absolute inset-0">
                <template x-for="(banner, i) in banners" :key="i">
                    <div x-show="current === i" x-transition:enter="transition-all duration-700"
                        x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
                        class="absolute inset-0 bg-cover bg-center" :style="'background-image: url(' + banner + ')'">
                    </div>
                </template>
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900/70 via-slate-900/50 to-slate-900/70"></div>
            </div>
        </template>
        {{-- Fallback decorative background --}}
        <template x-if="!hasBanners">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-br from-green-900/40 via-slate-900 to-slate-900"></div>
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-20 left-10 w-72 h-72 bg-green-500 rounded-full blur-[100px]"></div>
                    <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-500 rounded-full blur-[120px]"></div>
                </div>
            </div>
        </template>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 lg:py-40 w-full">
            <div class="max-w-3xl" data-aos="fade-up">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-full text-green-400 text-sm font-medium mb-6">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    Solusi Reklame Profesional
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold leading-[1.1] mb-6">
                    Solusi Reklame <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400">Terbaik untuk
                        Brand</span> Anda
                </h1>
                <p class="text-lg sm:text-xl text-slate-300 mb-10 max-w-2xl leading-relaxed">
                    Jadikan bisnis Anda lebih dikenal dengan billboard dan media reklame premium di lokasi strategis seluruh
                    Indonesia.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('catalog.index') }}"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 hover:shadow-2xl hover:shadow-green-500/30 hover:-translate-y-0.5 shadow-xl shadow-green-500/20">
                        Jelajahi Katalog
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <a href="{{ route('inquiry.create') }}"
                        class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-xl font-bold text-lg backdrop-blur-sm transition-all duration-300 border border-white/20 hover:border-white/30">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>

        {{-- Banner Navigation Dots --}}
        <div x-show="hasBanners && banners.length > 1"
            class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex items-center gap-2">
            <template x-for="(banner, i) in banners" :key="i">
                <button @click="goTo(i)" class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                    :class="current === i ? 'bg-white w-8' : 'bg-white/40 hover:bg-white/60'"></button>
            </template>
        </div>

        {{-- Navigation Arrows --}}
        <div x-show="hasBanners && banners.length > 1"
            class="absolute inset-x-0 top-1/2 -translate-y-1/2 z-10 flex items-center justify-between px-4 lg:px-8">
            <button @click="prev()"
                class="p-2 lg:p-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-full transition-all hover:scale-110">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <button @click="next()"
                class="p-2 lg:p-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-full transition-all hover:scale-110">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-slate-50 to-transparent"></div>
    </section>

    {{-- Stats / Counters --}}
    <section class="relative -mt-20 z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
            class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8 lg:p-10 grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">
            <div class="text-center">
                <p class="text-3xl lg:text-4xl font-bold text-green-600">{{ $featuredPoints->count() }}+</p>
                <p class="text-sm text-slate-500 mt-1">Titik Reklame</p>
            </div>
            <div class="text-center">
                <p class="text-3xl lg:text-4xl font-bold text-green-600">{{ count($cities) }}</p>
                <p class="text-sm text-slate-500 mt-1">Kota Tersedia</p>
            </div>
            <div class="text-center">
                <p class="text-3xl lg:text-4xl font-bold text-green-600">100+</p>
                <p class="text-sm text-slate-500 mt-1">Klien Puas</p>
            </div>
            <div class="text-center">
                <p class="text-3xl lg:text-4xl font-bold text-green-600">24/7</p>
                <p class="text-sm text-slate-500 mt-1">Dukungan</p>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="py-20 lg:py-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-aos="fade-up">
            <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Bagaimana Cara Kerjanya</span>
            <h2 class="section-title mt-2 dark:text-white">Mudah & Cepat</h2>
            <p class="section-subtitle mx-auto text-slate-500 dark:text-slate-400">Dapatkan titik reklame impian Anda dalam
                beberapa langkah mudah.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 relative">
            <div
                class="hidden lg:block absolute top-12 left-[12%] right-[12%] h-0.5 bg-gradient-to-r from-green-200 via-green-300 to-green-200">
            </div>
            @foreach ([['num' => '1', 'title' => 'Jelajahi Katalog', 'desc' => 'Cari titik reklame berdasarkan lokasi, harga, dan spesifikasi yang Anda butuhkan.'], ['num' => '2', 'title' => 'Pilih Titik', 'desc' => 'Pilih titik reklame yang sesuai dengan kebutuhan branding dan anggaran Anda.'], ['num' => '3', 'title' => 'Ajukan Inquiry', 'desc' => 'Kirim pertanyaan atau permintaan melalui form kontak atau WhatsApp.'], ['num' => '4', 'title' => 'Pasang & Go', 'desc' => 'Tim kami akan menangani pemasangan, Anda tinggal menikmati hasilnya.']] as $step)
                <div class="text-center" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-xl shadow-green-500/20">
                        <span class="text-2xl font-bold text-white">{{ $step['num'] }}</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-2 dark:text-white">{{ $step['title'] }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed dark:text-slate-400">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Featured Points --}}
    @if ($featuredPoints->isNotEmpty())
        <section class="bg-slate-50 py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10" data-aos="fade-up">
                    <div>
                        <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Populer</span>
                        <h2 class="section-title mt-1">Titik Reklame Populer</h2>
                        <p class="section-subtitle">Lokasi dengan trafik tertinggi untuk brand Anda.</p>
                    </div>
                    <a href="{{ route('catalog.index') }}"
                        class="hidden sm:inline-flex items-center gap-1 text-green-600 hover:text-green-700 font-semibold text-sm transition-colors mt-2">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($featuredPoints as $index => $point)
                        <x-product-card :point="$point" aos="fade-up" :aosDelay="$index * 100" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Why Choose Us --}}
    <section class="py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-aos="fade-up">
                <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Keunggulan Kami</span>
                <h2 class="section-title mt-2 dark:text-white">Mengapa Memilih Kami?</h2>
                <p class="section-subtitle mx-auto text-slate-500 dark:text-slate-400">Kami berkomitmen memberikan solusi
                    reklame terbaik untuk bisnis Anda.
                </p>
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

    {{-- Testimonials --}}
    <section class="bg-slate-900 py-20 lg:py-28 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-green-500 rounded-full blur-[100px]"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative" x-data="{
            active: 0,
            testimonials: [
                { name: 'Budi Santoso', role: 'CEO, PT. Maju Jaya', text: 'Pelayanan sangat profesional! Billboard kami terpasang tepat waktu dan hasilnya melebihi ekspektasi. Trafik ke toko meningkat signifikan.' },
                { name: 'Siti Rahmawati', role: 'Marketing Manager, Fashion Brand', text: 'Lokasi reklame yang ditawarkan sangat strategis. Tim Jaya Makmur membantu kami memilih titik terbaik untuk brand kami.' },
                { name: 'Andi Wijaya', role: 'Owner, Resto Group', text: 'Sudah 3 tahun bekerja sama dan tidak pernah kecewa. Proses cepat, harga kompetitif, dan hasil berkualitas. Highly recommended!' }
            ]
        }">
            <div class="text-center mb-14" data-aos="fade-up">
                <span class="text-green-400 font-semibold text-sm uppercase tracking-wider">Testimonial</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-white mt-2">Apa Kata Klien Kami</h2>
                <p class="text-slate-400 mt-2 max-w-2xl mx-auto">Kepercayaan klien adalah prioritas utama kami.</p>
            </div>
            <div class="relative max-w-3xl mx-auto">
                <template x-for="(t, i) in testimonials" :key="i">
                    <div x-show="active === i" x-transition:enter="transition-all duration-500 ease-out"
                        x-transition:enter-start="opacity-0 translate-x-8"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 lg:p-12 text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-green-500/20">
                            <span class="text-2xl font-bold text-white" x-text="t.name.charAt(0)"></span>
                        </div>
                        <p class="text-slate-300 text-lg lg:text-xl leading-relaxed mb-8 italic" x-text="t.text"></p>
                        <div>
                            <p class="text-white font-bold text-lg" x-text="t.name"></p>
                            <p class="text-green-400 text-sm" x-text="t.role"></p>
                        </div>
                    </div>
                </template>
                <div class="flex items-center justify-center gap-3 mt-8">
                    <template x-for="(t, i) in testimonials" :key="i">
                        <button @click="active = i" class="w-3 h-3 rounded-full transition-all duration-300"
                            :class="active === i ? 'bg-green-500 w-8' : 'bg-slate-600 hover:bg-slate-500'"></button>
                    </template>
                </div>
                <button @click="active = (active - 1 + testimonials.length) % testimonials.length"
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-12 p-2 text-slate-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <button @click="active = (active + 1) % testimonials.length"
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-12 p-2 text-slate-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    {{-- Portfolio Highlights --}}
    @if (isset($latestPortfolios) && $latestPortfolios->isNotEmpty())
        <section class="py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10" data-aos="fade-up">
                    <div>
                        <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Karya Terbaru</span>
                        <h2 class="section-title mt-1 dark:text-white">Portofolio Terkini</h2>
                        <p class="section-subtitle text-slate-500 dark:text-slate-400">Proyek reklame yang telah kami
                            kerjakan.</p>
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

    {{-- Cities / Coverage --}}
    <section class="bg-slate-50 py-20 lg:py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-aos="fade-up">
                <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Jangkauan</span>
                <h2 class="section-title mt-2">Kota Tersedia</h2>
                <p class="section-subtitle mx-auto">Kami hadir di berbagai kota besar Indonesia.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-3" data-aos="fade-up">
                @foreach ($cities as $city)
                    <a href="{{ route('catalog.index', ['city' => $city]) }}"
                        class="px-5 py-3 bg-white hover:bg-green-50 border border-slate-200 hover:border-green-200 rounded-xl text-slate-700 hover:text-green-700 font-medium text-sm transition-all shadow-sm hover:shadow-md">
                        {{ $city }}
                    </a>
                @endforeach
                <a href="{{ route('catalog.index') }}"
                    class="px-5 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl font-medium text-sm transition-all shadow-lg shadow-green-500/20">
                    Semua Kota
                </a>
            </div>
        </div>
    </section>

    {{-- Latest Posts --}}
    @if ($latestPosts->isNotEmpty())
        <section class="py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10" data-aos="fade-up">
                    <div>
                        <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Update</span>
                        <h2 class="section-title mt-1 dark:text-white">Berita & Artikel</h2>
                        <p class="section-subtitle text-slate-500 dark:text-slate-400">Informasi terbaru seputar dunia
                            reklame.</p>
                    </div>
                    <a href="{{ route('posts.index') }}"
                        class="hidden sm:inline-flex items-center gap-1 text-green-600 hover:text-green-700 font-semibold text-sm transition-colors mt-2">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($latestPosts as $index => $post)
                        <article data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                            class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                            <div class="relative aspect-[4/3] overflow-hidden">
                                @if ($post->featured_image)
                                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                @if ($post->category)
                                    <div class="absolute top-3 left-3">
                                        <span
                                            class="bg-slate-900/80 backdrop-blur-sm text-white text-xs font-medium px-2.5 py-1 rounded-full">{{ $post->category->name }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-slate-900 text-lg leading-tight mb-2">
                                    <a href="{{ route('posts.show', $post) }}"
                                        class="hover:text-green-600 transition-colors">{{ $post->title }}</a>
                                </h3>
                                <p class="text-sm text-slate-500 line-clamp-2">{{ $post->excerpt }}</p>
                                <div
                                    class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100 text-xs text-slate-400">
                                    <span>{{ $post->published_at?->format('d M Y') }}</span>
                                    <span>{{ $post->reading_time }} min read</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Trust Badges --}}
    <section class="bg-white border-y border-slate-100 py-16" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs text-slate-400 uppercase tracking-widest font-bold mb-12">
                Dipercaya oleh perusahaan ternama
            </p>

            <div class="flex flex-wrap items-center justify-center gap-6 md:gap-10">

                {{-- Item Logo --}}
                <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center p-2 group">
                    <img src="{{ asset('images/garuda-indonesia.png') }}" alt="Garuda Indonesia"
                        class="max-h-full max-w-full object-contain filter grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                </div>

                <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center p-2 group">
                    <img src="{{ asset('images/authenticity.png') }}" alt="Authenticity"
                        class="max-h-full max-w-full object-contain filter grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                </div>

                <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center p-2 group">
                    <img src="{{ asset('images/gojek.png') }}" alt="Gojek"
                        class="max-h-full max-w-full object-contain filter grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                </div>

                <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center p-2 group">
                    <img src="{{ asset('images/bank-bjb.png') }}" alt="Bank BJB"
                        class="max-h-full max-w-full object-contain filter grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                </div>

                <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center p-2 group">
                    <img src="{{ asset('images/vivo.png') }}" alt="Vivo"
                        class="max-h-full max-w-full object-contain filter grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                </div>

                <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center p-2 group">
                    <img src="{{ asset('images/astra-honda-motor.png') }}" alt="Astra Honda Motor"
                        class="max-h-full max-w-full object-contain filter grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                </div>

                <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center p-2 group">
                    <img src="{{ asset('images/MR-DIY.png') }}" alt="MR DIY"
                        class="max-h-full max-w-full object-contain filter grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                </div>

                <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center p-2 group">
                    <img src="{{ asset('images/fore.png') }}" alt="Fore Coffee"
                        class="max-h-full max-w-full object-contain filter grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                </div>

                <div class="w-32 h-16 md:w-40 md:h-20 flex items-center justify-center p-2 group">
                    <img src="{{ asset('images/ms-beauty.png') }}" alt="MS Beauty"
                        class="max-h-full max-w-full object-contain filter grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                </div>

            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800 py-20 lg:py-28 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-10 w-80 h-80 bg-green-500 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-10 left-10 w-60 h-60 bg-emerald-500 rounded-full blur-[100px]"></div>
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative" data-aos="fade-up">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Siap Meningkatkan Brand Anda?</h2>
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

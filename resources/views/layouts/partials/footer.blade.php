<footer class="bg-slate-900 text-slate-400 relative">
    {{-- Decorative top border --}}
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-500 via-green-400 to-green-500"></div>

    {{-- Newsletter --}}
    <div class="border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-white font-bold text-lg">Dapatkan Update Terbaru</h3>
                    <p class="text-slate-400 text-sm mt-1">Berita terbaru seputar dunia reklame dan penawaran spesial.
                    </p>
                </div>
                <form class="flex w-full lg:w-auto gap-3"
                    x-data="{ email: '', loading: false, message: '', error: '' }"
                    @submit.prevent="
                        loading = true; error = ''; message = '';
                        fetch('{{ route('newsletter.subscribe') }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ email })
                        }).then(r => r.json()).then(d => {
                            if (d.message) { message = d.message; email = ''; setTimeout(() => message = '', 4000) }
                        }).catch(e => error = 'Terjadi kesalahan. Coba lagi.')
                        .finally(() => loading = false)
                    ">
                    <div class="relative flex-1 lg:w-72">
                        <input type="email" x-model="email" required placeholder="Masukkan email Anda"
                            class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white text-sm placeholder-slate-400 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all">
                        <p x-show="message" x-text="message"
                            class="absolute -bottom-6 left-0 text-xs text-green-400 whitespace-nowrap"></p>
                        <p x-show="error" x-text="error"
                            class="absolute -bottom-6 left-0 text-xs text-red-400"></p>
                    </div>
                    <button type="submit" :disabled="loading"
                        class="px-6 py-3 bg-green-500 hover:bg-green-600 disabled:bg-green-500/50 text-white rounded-xl text-sm font-semibold transition-all whitespace-nowrap shadow-lg shadow-green-500/20">
                        <span x-show="!loading">Berlangganan</span>
                        <span x-show="loading" class="inline-block w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            {{-- Company Info --}}
            <div class="lg:col-span-1">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 mb-5 group">
                    @php($logo = setting('logo'))
                    @if ($logo)
                        <img src="{{ Storage::url($logo) }}" alt="{{ setting('site_name', 'PT. Jaya Makmur') }}"
                            class="h-12 lg:h-14 w-auto object-contain">
                        <div class="flex flex-col leading-tight">
                            <span
                                class="text-white font-bold text-lg">{{ setting('site_name', 'PT. Jaya Makmur') }}</span>
                            <span class="text-green-400 text-[10px] font-medium tracking-wider uppercase">Solusi Reklame
                                Terpercaya</span>
                        </div>
                    @else
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/20 group-hover:shadow-green-500/40 transition-all">
                            <span class="text-white font-bold text-sm">JM</span>
                        </div>
                        <div class="flex flex-col leading-tight">
                            <span
                                class="text-white font-bold text-lg">{{ setting('site_name', 'PT. Jaya Makmur') }}</span>
                            <span class="text-green-400 text-[10px] font-medium tracking-wider uppercase">Solusi Reklame
                                Terpercaya</span>
                        </div>
                    @endif
                </a>
                <p class="text-sm leading-relaxed text-slate-400">
                    {{ setting('site_description', 'Perusahaan penyedia jasa reklame dan billboard profesional. Melayani pemasangan media promosi luar ruang di berbagai kota besar Indonesia dengan kualitas terbaik.') }}
                </p>
                {{-- Social Media --}}
                <div class="flex items-center gap-3 mt-6">
                    <a href="{{ setting('facebook_url', '#') }}"
                        class="w-9 h-9 bg-slate-800 hover:bg-green-600 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all duration-300"
                        aria-label="Facebook" target="_blank" rel="noopener">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="{{ setting('instagram_url', '#') }}"
                        class="w-9 h-9 bg-slate-800 hover:bg-pink-600 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all duration-300"
                        aria-label="Instagram" target="_blank" rel="noopener">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                        </svg>
                    </a>
                    <a href="{{ setting('linkedin_url', '#') }}"
                        class="w-9 h-9 bg-slate-800 hover:bg-green-700 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all duration-300"
                        aria-label="LinkedIn" target="_blank" rel="noopener">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-5">Menu Cepat</h3>
                <ul class="space-y-3">
                    <li><a href="{{ url('/') }}"
                            class="text-sm text-slate-400 hover:text-green-400 transition-colors flex items-center gap-2 group"><span
                                class="w-1 h-1 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Beranda</a>
                    </li>
                    <li><a href="{{ route('about') }}"
                            class="text-sm text-slate-400 hover:text-green-400 transition-colors flex items-center gap-2 group"><span
                                class="w-1 h-1 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Tentang
                            Kami</a></li>
                    <li><a href="{{ route('catalog.index') }}"
                            class="text-sm text-slate-400 hover:text-green-400 transition-colors flex items-center gap-2 group"><span
                                class="w-1 h-1 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Katalog
                            Billboard</a></li>
                    <li><a href="{{ route('posts.index') }}"
                            class="text-sm text-slate-400 hover:text-green-400 transition-colors flex items-center gap-2 group"><span
                                class="w-1 h-1 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Berita
                            & Artikel</a></li>
                    <li><a href="{{ route('inquiry.create') }}"
                            class="text-sm text-slate-400 hover:text-green-400 transition-colors flex items-center gap-2 group"><span
                                class="w-1 h-1 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Hubungi
                            Kami</a></li>
                </ul>
            </div>

            {{-- Services --}}
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-5">Layanan</h3>
                <ul class="space-y-3">
                    <li class="text-sm text-slate-400">Billboard & Baliho</li>
                    <li class="text-sm text-slate-400">Neon Box & LED Display</li>
                    <li class="text-sm text-slate-400">Rooftop Signage</li>
                    <li class="text-sm text-slate-400">Media Luar Ruang</li>
                    <li class="text-sm text-slate-400">Konsultasi Branding</li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-5">Kontak</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-400 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div>
                            <p class="text-sm text-slate-400">{{ setting('address', 'Jl. Sudirman No. 123') }}</p>
                            <p class="text-sm text-slate-400">{{ setting('address2', 'Jakarta Pusat, Indonesia') }}</p>
                        </div>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-sm text-slate-400">{{ setting('phone', '+62 812-3456-7890') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm text-slate-400">{{ setting('email', 'info@jayamakmur.com') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500">&copy; {{ date('Y') }}
                {{ setting('site_name', 'PT. Jaya Makmur') }}. All rights reserved.</p>
            <div class="flex items-center gap-6 text-sm text-slate-500">
                <a href="{{ route('privacy') }}" class="hover:text-green-400 transition-colors">Kebijakan Privasi</a>
                <a href="{{ route('terms') }}" class="hover:text-green-400 transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>

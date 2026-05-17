<nav class="fixed top-0 w-full z-50 h-16 lg:h-20 bg-slate-900/95 backdrop-blur-md border-b border-slate-800/50 shadow-lg shadow-slate-900/20 dark:bg-slate-950/95 dark:border-slate-700/50"
    x-data="{ offcanvas: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between items-center h-full">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group shrink-0">
                @php($logo = setting('logo'))
                @if ($logo)
                    <img src="{{ Storage::url($logo) }}" alt="{{ setting('site_name', 'PT. Jaya Makmur') }}"
                        class="h-10 lg:h-12 w-auto object-contain">
                    <div class="flex flex-col leading-tight">
                        <span
                            class="text-white font-bold text-base lg:text-lg tracking-tight">{{ setting('site_name', 'PT. Jaya Makmur') }}</span>
                        <span
                            class="text-green-400 text-[10px] font-medium tracking-wider uppercase leading-none mt-0.5">{{ setting('site_description', 'Solusi Reklame Terpercaya') }}</span>
                    </div>
                @else
                    <div
                        class="w-9 h-9 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/20 group-hover:shadow-green-500/40 transition-all duration-300">
                        <span class="text-white font-bold text-sm">JM</span>
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span
                            class="text-white font-bold text-base lg:text-lg tracking-tight">{{ setting('site_name', 'PT. Jaya Makmur') }}</span>
                        <span
                            class="text-green-400 text-[10px] font-medium tracking-wider uppercase leading-none mt-0.5">{{ setting('site_description', 'Solusi Reklame Terpercaya') }}</span>
                    </div>
                @endif
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden lg:flex items-center space-x-1">
                <a href="{{ url('/') }}"
                    class="px-4 py-2 text-slate-300 hover:text-white hover:bg-white/5 rounded-lg transition-all text-sm font-medium {{ request()->is('/') ? 'text-green-400 bg-green-500/10' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('about') }}"
                    class="px-4 py-2 text-slate-300 hover:text-white hover:bg-white/5 rounded-lg transition-all text-sm font-medium {{ request()->routeIs('about') ? 'text-green-400 bg-green-500/10' : '' }}">
                    Tentang
                </a>
                <a href="{{ route('catalog.index') }}"
                    class="px-4 py-2 text-slate-300 hover:text-white hover:bg-white/5 rounded-lg transition-all text-sm font-medium {{ request()->routeIs('catalog.*') ? 'text-green-400 bg-green-500/10' : '' }}">
                    Katalog
                </a>
                <a href="{{ route('portofolio.index') }}"
                    class="px-4 py-2 text-slate-300 hover:text-white hover:bg-white/5 rounded-lg transition-all text-sm font-medium {{ request()->routeIs('portofolio.*') ? 'text-green-400 bg-green-500/10' : '' }}">
                    Portofolio
                </a>
                <a href="{{ route('posts.index') }}"
                    class="px-4 py-2 text-slate-300 hover:text-white hover:bg-white/5 rounded-lg transition-all text-sm font-medium {{ request()->routeIs('posts.*') ? 'text-green-400 bg-green-500/10' : '' }}">
                    Berita
                </a>
                <a href="{{ route('inquiry.create') }}"
                    class="px-4 py-2 text-slate-300 hover:text-white hover:bg-white/5 rounded-lg transition-all text-sm font-medium {{ request()->routeIs('inquiry.*') ? 'text-green-400 bg-green-500/10' : '' }}">
                    Kontak
                </a>
            </div>

            {{-- Right Section --}}
            <div class="hidden lg:flex items-center gap-2">
                {{-- Dark Mode Toggle --}}
                <button @click="toggleDark()"
                    class="p-2.5 text-slate-400 hover:text-white hover:bg-white/5 rounded-xl transition-all"
                    :title="darkMode ? 'Mode Terang' : 'Mode Gelap'" aria-label="Toggle dark mode">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21.752 15.002A9.72 9.72 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </button>
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-slate-300 hover:text-white text-sm font-medium transition-colors px-3 py-2">Dashboard</a>
                @endauth
                <a href="{{ route('catalog.index') }}"
                    class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 shadow-lg shadow-green-500/20 hover:shadow-green-500/40 hover:-translate-y-0.5">
                    Lihat Katalog
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <button @click="offcanvas = true"
                class="lg:hidden p-2.5 text-slate-300 hover:text-white hover:bg-white/5 rounded-xl transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Offcanvas Overlay --}}
    <div x-show="offcanvas" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:leave="transition-opacity ease-linear duration-300"
        class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm dark:bg-slate-950/80 lg:hidden"
        @click="offcanvas = false"></div>

    {{-- Offcanvas Panel --}}
    <div x-show="offcanvas" x-transition:enter="transition-transform ease-out duration-300"
        x-transition:leave="transition-transform ease-in duration-200"
        class="fixed top-0 right-0 z-50 h-screen w-72 max-w-[85vw] bg-slate-900 border-l border-slate-800 shadow-2xl dark:bg-slate-950 dark:border-slate-700 lg:hidden overflow-y-auto z-50"
        @click.away="offcanvas = false">
        <div class="flex flex-col min-h-full">
            {{-- Offcanvas Header --}}
            <div class="flex items-center justify-between px-5 h-16 border-b border-slate-800 shrink-0">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    @php($logo = setting('logo'))
                    @if ($logo)
                        <img src="{{ Storage::url($logo) }}" alt="{{ setting('site_name', 'PT. Jaya Makmur') }}"
                            class="h-8 w-auto object-contain">
                        <div class="flex flex-col leading-tight">
                            <span
                                class="text-white font-bold text-sm tracking-tight">{{ setting('site_name', 'PT. Jaya Makmur') }}</span>
                            <span
                                class="text-green-400 text-[10px] font-medium tracking-wider uppercase leading-none mt-0.5">{{ setting('site_description', 'Solusi Reklame Terpercaya') }}</span>
                        </div>
                    @else
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xs">JM</span>
                        </div>
                        <span class="text-white font-bold text-sm">{{ setting('site_name', 'PT. Jaya Makmur') }}</span>
                    @endif
                </a>
                <button @click="offcanvas = false"
                    class="p-2 text-slate-400 hover:text-white hover:bg-white/5 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Offcanvas Navigation --}}
            <div class="flex-1 px-3 py-6 space-y-1">
                <div class="px-3 pb-3 mb-3 border-b border-slate-800">
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Menu</p>
                </div>
                <a href="{{ url('/') }}" @click="offcanvas = false"
                    class="flex items-center gap-3 px-3 py-3 text-slate-300 hover:text-white hover:bg-white/5 rounded-xl transition-all text-sm font-medium {{ request()->is('/') ? 'text-green-400 bg-green-500/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Beranda
                </a>
                <a href="{{ route('about') }}" @click="offcanvas = false"
                    class="flex items-center gap-3 px-3 py-3 text-slate-300 hover:text-white hover:bg-white/5 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('about') ? 'text-green-400 bg-green-500/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    Tentang
                </a>
                <a href="{{ route('catalog.index') }}" @click="offcanvas = false"
                    class="flex items-center gap-3 px-3 py-3 text-slate-300 hover:text-white hover:bg-white/5 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('catalog.*') ? 'text-green-400 bg-green-500/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    Katalog
                </a>
                <a href="{{ route('portofolio.index') }}" @click="offcanvas = false"
                    class="flex items-center gap-3 px-3 py-3 text-slate-300 hover:text-white hover:bg-white/5 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('portofolio.*') ? 'text-green-400 bg-green-500/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5M3.75 3h16.5v13.5H3.75V3z" />
                    </svg>
                    Portofolio
                </a>
                <a href="{{ route('posts.index') }}" @click="offcanvas = false"
                    class="flex items-center gap-3 px-3 py-3 text-slate-300 hover:text-white hover:bg-white/5 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('posts.*') ? 'text-green-400 bg-green-500/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                    </svg>
                    Berita
                </a>
                <a href="{{ route('inquiry.create') }}" @click="offcanvas = false"
                    class="flex items-center gap-3 px-3 py-3 text-slate-300 hover:text-white hover:bg-white/5 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('inquiry.*') ? 'text-green-400 bg-green-500/10' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    Kontak
                </a>
            </div>

            {{-- Offcanvas Footer --}}
            <div class="px-4 py-5 border-t border-slate-800 space-y-3 shrink-0">
                {{-- Dark Mode Toggle (Mobile) --}}
                <button @click="toggleDark()"
                    class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-white/5 text-slate-300 hover:bg-white/10 rounded-xl text-sm font-semibold transition-all">
                    <template x-if="!darkMode">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21.752 15.002A9.72 9.72 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                        </svg>
                    </template>
                    <template x-if="darkMode">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                    </template>
                    <span x-text="darkMode ? 'Mode Terang' : 'Mode Gelap'"></span>
                </button>
                @auth
                    <a href="{{ route('admin.dashboard') }}" @click="offcanvas = false"
                        class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-green-500/10 text-green-400 hover:bg-green-500/20 rounded-xl text-sm font-semibold transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" @click="offcanvas = false"
                        class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-white/5 text-slate-300 hover:bg-white/10 rounded-xl text-sm font-semibold transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        Login Admin
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

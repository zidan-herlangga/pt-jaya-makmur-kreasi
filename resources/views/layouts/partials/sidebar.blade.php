<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen bg-slate-900 border-r border-slate-800/50 transition-transform duration-300 lg:translate-x-0 shadow-xl"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <div class="h-full flex flex-col">
        {{-- Logo --}}
        <div class="flex items-center h-16 px-6 border-b border-slate-800/50 shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logo-pt-jaya-makmur-kreasi.png') }}"
                    alt="{{ setting('site_name', 'PT. Jaya Makmur') }}" class="h-10 lg:h-12 w-auto object-contain">
                <div class="flex flex-col leading-tight">
                    <span
                        class="text-white font-bold text-sm tracking-tight">{{ setting('site_name', 'PT. Jaya Makmur') }}</span>
                    <span class="text-green-300 text-[9px] font-medium tracking-wider uppercase">Admin Panel</span>
                </div>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto overflow-x-hidden">
            {{-- Dashboard --}}
            <x-admin-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')"
                icon="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                Dashboard
            </x-admin-nav-link>

            {{-- Konten --}}
            @php
                $kontenActive =
                    request()->routeIs('admin.portfolios.*') ||
                    request()->routeIs('admin.posts.*') ||
                    request()->routeIs('admin.categories.*');
            @endphp
            <x-admin-nav-dropdown label="Konten" :active="$kontenActive" :defaultOpen="$kontenActive"
                icon="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                @can('portfolios.view')
                    <x-admin-nav-link href="{{ route('admin.portfolios.index') }}" :active="request()->routeIs('admin.portfolios.*')"
                        icon="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        Portfolio
                    </x-admin-nav-link>
                @endcan
                @can('posts.view')
                    <x-admin-nav-link href="{{ route('admin.posts.index') }}" :active="request()->routeIs('admin.posts.*')"
                        icon="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                        Berita / Artikel
                    </x-admin-nav-link>
                @endcan
                @can('categories.view')
                    <x-admin-nav-link href="{{ route('admin.categories.index') }}" :active="request()->routeIs('admin.categories.*')"
                        icon="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z">
                        Kategori
                    </x-admin-nav-link>
                @endcan
            </x-admin-nav-dropdown>

            {{-- Reklame --}}
            @php
                $reklameActive =
                    request()->routeIs('admin.advertising-points.*') || request()->routeIs('admin.inquiries.*');
            @endphp
            <x-admin-nav-dropdown label="Reklame" :active="$reklameActive" :defaultOpen="$reklameActive"
                icon="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                @can('advertising_points.view')
                    <x-admin-nav-link href="{{ route('admin.advertising-points.index') }}" :active="request()->routeIs('admin.advertising-points.*')"
                        icon="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        Titik Reklame
                    </x-admin-nav-link>
                @endcan
                @can('inquiries.view')
                    <x-admin-nav-link href="{{ route('admin.inquiries.index') }}" :active="request()->routeIs('admin.inquiries.*')"
                        icon="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                        :badge="\App\Models\Inquiry::pending()->notSpam()->count()">
                        Inquiry
                    </x-admin-nav-link>
                @endcan
            </x-admin-nav-dropdown>

            {{-- Sistem --}}
            @php
                $sistemActive = request()->routeIs('admin.users.*') || request()->routeIs('admin.settings.*');
            @endphp
            <x-admin-nav-dropdown label="Sistem" :active="$sistemActive" :defaultOpen="$sistemActive"
                icon="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281zM15 12a3 3 0 11-6 0 3 3 0 016 0z">
                @can('users.view')
                    <x-admin-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')"
                        icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        Pengguna
                    </x-admin-nav-link>
                @endcan
                <x-admin-nav-link href="{{ route('admin.settings.index') }}" :active="request()->routeIs('admin.settings.*')"
                    icon="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281zM15 12a3 3 0 11-6 0 3 3 0 016 0z">
                    Pengaturan
                </x-admin-nav-link>
                <x-admin-nav-link href="{{ route('admin.newsletter-subscribers.index') }}" :active="request()->routeIs('admin.newsletter-subscribers.*')"
                    icon="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.981l7.5-4.039a2.25 2.25 0 012.134 0l7.5 4.039a2.25 2.25 0 011.183 1.98V19.5z">
                    Newsletter
                </x-admin-nav-link>
            </x-admin-nav-dropdown>
        </nav>

        {{-- User Profile --}}
        <div class="border-t border-slate-800/50 p-4 shrink-0">
            <div class="flex items-center gap-3">
                <div
                    class="w-9 h-9 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-green-500/20">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()?->name ?? 'Admin' }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()?->email ?? '' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="p-2 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition-all"
                        title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

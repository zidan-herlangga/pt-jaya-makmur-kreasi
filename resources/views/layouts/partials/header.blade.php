<header class="bg-white/80 backdrop-blur-md border-b border-slate-200 h-16 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-30 shadow-sm">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        <div class="hidden sm:flex items-center gap-2 text-sm text-slate-500">
            <span class="text-slate-300">/</span>
            <span class="font-medium text-slate-700">{{ $seo['title'] ?? 'Dashboard' }}</span>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ url('/') }}" target="_blank"
           class="hidden sm:inline-flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Lihat Website
        </a>
        <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-xs">
                {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}
            </div>
            <span class="hidden sm:inline font-medium text-slate-700">{{ auth()->user()?->name }}</span>
        </div>
    </div>
</header>

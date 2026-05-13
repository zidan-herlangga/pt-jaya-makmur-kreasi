<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $seo['title'] ?? 'Dashboard' }} | {{ config('app.name') }} Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900" x-data="{ sidebarOpen: false, darkMode: localStorage.getItem('darkMode') === 'true' }" :class="darkMode && 'dark'">

    {{-- Mobile Sidebar Overlay --}}
    <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"
        @click="sidebarOpen = false" x-transition.opacity></div>

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    {{-- Main Content Area --}}
    <div class="lg:ml-64 min-h-screen flex flex-col bg-slate-50">
        {{-- Top Header --}}
        @include('layouts.partials.header')

        {{-- Page Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            {{-- Toast Notifications --}}
            <div class="fixed top-4 right-4 z-50 space-y-3">
                @if (session('success'))
                    <div class="bg-white rounded-xl border border-green-200 shadow-lg shadow-green-500/10 p-4 min-w-[320px] flex items-start gap-3"
                        x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)">
                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-900 text-sm">Berhasil!</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false"
                            class="text-slate-400 hover:text-slate-600 shrink-0">&times;</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-white rounded-xl border border-red-200 shadow-lg shadow-red-500/10 p-4 min-w-[320px] flex items-start gap-3"
                        x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)">
                        <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-900 text-sm">Oops!</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false"
                            class="text-slate-400 hover:text-slate-600 shrink-0">&times;</button>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>

        {{-- Footer --}}
        <div class="border-t border-slate-200 px-6 py-4 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: '#editor',
                    height: 700,
                    menubar: false,
                    branding: false,
                    promotion: false,
                    statusbar: false, // Hapus bar bawah yang mengganggu
                    plugins: 'quickbars lists link image code wordcount',
                    toolbar: 'undo redo | blocks | bold italic | bullist numlist | link image | fullscreen',
                    // Fitur Quickbars membuat toolbar muncul saat teks diblok (ala Medium)
                    quickbars_selection_toolbar: 'bold italic | h2 h3 | blockquote quicklink',
                    quickbars_insert_toolbar: 'quickimage bullist numlist',
                    toolbar_location: 'top',
                    // Skin & Content Style
                    content_style: `
                        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap');
                        body { 
                            font-family: 'Plus Jakarta Sans', sans-serif; 
                            font-size: 18px; 
                            line-height: 1.8; 
                            color: #334155; 
                            max-width: 750px; 
                            margin: 40px auto; 
                            padding: 20px;
                            background-color: #ffffff;
                        }
                        h2, h3 { color: #0f172a; margin-top: 2em; font-weight: 700; }
                        blockquote { border-left: 4px solid #3b82f6; padding-left: 20px; font-style: italic; color: #64748b; }
                    `,
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>

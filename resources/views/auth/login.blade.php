<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-900">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/20">
                    <span class="text-white font-bold text-lg">R</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900">Admin Login</h1>
                <p class="text-slate-500 mt-1">Masuk ke panel administrasi</p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-8">
                @if($errors->any())
                    <div class="mb-4 rounded-lg bg-rose-50 border border-rose-200 p-4 text-sm text-rose-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                        <div class="relative password-toggle">
                            <input type="password" name="password" required
                                   class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all">
                            <button type="button" onclick="togglePassword(this)"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600">
                                <svg class="password-eye w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg class="password-eye-off w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember"
                                   class="rounded border-slate-300 text-green-600 focus:ring-green-500">
                            <span class="text-sm text-slate-600">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white py-3 rounded-xl font-semibold transition-all hover:shadow-lg hover:shadow-green-500/20">
                        Masuk
                    </button>
                </form>
            </div>

            <p class="text-center mt-6 text-sm text-slate-500">
                <a href="{{ url('/') }}" class="text-green-600 hover:underline">&larr; Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</body>
</html>

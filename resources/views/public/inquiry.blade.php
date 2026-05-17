@extends('layouts.app', ['seo' => $seo])

@section('content')
    <div class="page-header py-16 lg:py-20 bg-slate-900 text-white overflow-hidden">
        <div class="page-header-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <x-breadcrumbs :items="['Kontak' => '']" />
            <h1 class="text-3xl lg:text-4xl font-bold text-white mb-3">Hubungi Kami</h1>
            <p class="text-slate-400 text-lg">Silakan isi form di bawah untuk konsultasi gratis.</p>
        </div>
    </div>

    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 mb-16">
        <div
            class="bg-white rounded-2xl border border-slate-200 shadow-xl p-8 lg:p-10 dark:bg-slate-800 dark:border-slate-700">
            @if (session('success'))
                <div class="mb-6 rounded-xl bg-green-50 border border-green-200 p-6 text-center">
                    <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-green-800 mb-1">Terima Kasih!</h3>
                    <p class="text-green-600">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Honeypot --}}
                <div class="hidden" aria-hidden="true">
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                @if (request('product'))
                    <input type="hidden" name="product_id" value="{{ request('product') }}">
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1 dark:text-slate-300">Nama Lengkap <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="sender_name" value="{{ old('sender_name') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        @error('sender_name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1 dark:text-slate-300">Email <span
                                class="text-rose-500">*</span></label>
                        <input type="email" name="sender_email" value="{{ old('sender_email') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        @error('sender_email')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1 dark:text-slate-300">Nomor
                            Telepon</label>
                        <input type="text" name="sender_phone" value="{{ old('sender_phone') }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1 dark:text-slate-300">Nama
                            Perusahaan</label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1 dark:text-slate-300">Pesan <span
                                class="text-rose-500">*</span></label>
                        <textarea name="message" rows="5" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all bg-white dark:bg-slate-700 dark:border-slate-600 dark:text-white">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg shadow-green-500/20 hover:shadow-green-500/40">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Kirim Pesan
                </button>
            </form>
        </div>
    </section>

    {{-- Contact Info --}}
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl border border-slate-200 p-6 text-center">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                        </path>
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-900 mb-1">Telepon</h3>
                <p class="text-sm text-slate-500">+62 812-3456-7890</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 p-6 text-center">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-900 mb-1">Email</h3>
                <p class="text-sm text-slate-500">{{ setting('email', 'contact.email') }}</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 p-6 text-center">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-900 mb-1">Alamat</h3>
                <p class="text-sm text-slate-500">{{ setting('address', 'contact.address') }}</p>
            </div>
        </div>

        {{-- map iframe --}}
        <div class="mt-10">
            <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden">
                @if (!setting('map_iframe', 'contact.map_iframe'))
                    <div
                        class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-sm dark:bg-slate-700 dark:text-slate-500">
                        Map iframe belum disetting
                    </div>
                @else
                    {!! setting('map_iframe', 'contact.map_iframe') !!}
                @endif
                {{-- {!! setting('map_iframe', 'contact.map_iframe') !!} --}}
            </div>
        </div>
    </section>
@endsection

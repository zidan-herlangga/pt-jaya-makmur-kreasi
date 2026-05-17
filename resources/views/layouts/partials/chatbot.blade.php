<div x-data="chatbot({
    siteName: '{{ setting('site_name', 'PT. Jaya Makmur Kreasi') }}',
    whatsapp: '{{ setting('whatsapp_number', '6281234567890') }}',
    waText: '{{ urlencode(setting('whatsapp_text', 'Halo saya tertarik dengan layanan reklame')) }}',
    address: '{{ setting('company_address', 'Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota, Provinsi 12345') }}',
    phone: '{{ setting('phone', '(021) 1234-5678') }}',
    email: '{{ setting('email', 'info@jayamakmur.com') }}'
})"
    x-init="init()"
    @keydown.escape.window="open = false"
    class="fixed bottom-6 left-6 z-50 sm:bottom-8 sm:left-8">

    {{-- Toggle Button --}}
    <button @click="toggle()"
        x-show="!open"
        x-transition:enter="transition-all duration-300 ease-out"
        x-transition:leave="transition-all duration-200 ease-in"
        class="relative w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-full shadow-xl shadow-green-500/30 hover:shadow-green-500/50 hover:scale-110 active:scale-95 transition-all duration-300 chat-pulse group"
        aria-label="Buka Chatbot">

        {{-- Chat icon --}}
        <svg x-show="!open" class="w-6 h-6 sm:w-7 sm:h-7 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
        </svg>

        <span class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 dark:bg-slate-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-lg pointer-events-none">
            Chat dengan kami
        </span>
    </button>

    {{-- Chat Panel --}}
    <div x-show="open"
        x-transition:enter="transition-all duration-300 ease-out"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition-all duration-200 ease-in"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        x-cloak
        @click.away="open = false"
        class="absolute bottom-20 left-0 w-[calc(100vw-2.5rem)] sm:w-[380px] max-h-[580px] h-[520px] sm:h-[560px] bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 flex flex-col overflow-hidden origin-bottom-left">

        {{-- Header --}}
        <div class="flex-shrink-0 bg-gradient-to-r from-green-600 to-emerald-600 p-4 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm leading-tight">CS Jaya Makmur</h3>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="w-2 h-2 rounded-full bg-green-300 animate-pulse"></span>
                            <span class="text-xs text-white/80">Online</span>
                        </div>
                    </div>
                </div>
                <button @click="open = false" class="w-8 h-8 rounded-full hover:bg-white/10 flex items-center justify-center transition-colors" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Messages --}}
        <div x-ref="messages"
            class="flex-1 overflow-y-auto px-4 py-4 space-y-3 scroll-smooth bg-slate-50 dark:bg-slate-850"
            :class="{ 'flex items-end': messages.length === 0 }">

            <template x-if="messages.length === 0 && !isLoading">
                <div class="flex flex-col items-center justify-center w-full py-8 text-center">
                    <div class="w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </div>
                    <p class="text-slate-400 dark:text-slate-500 text-sm">Mulai percakapan...</p>
                </div>
            </template>

            <template x-for="(msg, idx) in messages" :key="idx">
                <div>
                    {{-- Bot message --}}
                    <div x-show="msg.type === 'bot'"
                        x-transition:enter="transition-all duration-300 ease-out"
                        x-transition:enter-start="opacity-0 translate-x-[-8px]"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="flex items-start gap-2.5 max-w-[85%]">
                        <div class="w-7 h-7 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-3.5 h-3.5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="bg-white dark:bg-slate-700 rounded-2xl rounded-tl-sm px-4 py-2.5 shadow-sm border border-slate-100 dark:border-slate-600">
                            <p class="text-sm text-slate-700 dark:text-slate-200 leading-relaxed" x-html="msg.text"></p>
                        </div>
                    </div>

                    {{-- User message --}}
                    <div x-show="msg.type === 'user'"
                        x-transition:enter="transition-all duration-300 ease-out"
                        x-transition:enter-start="opacity-0 translate-x-[8px]"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="flex justify-end max-w-[85%] ml-auto">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl rounded-tr-sm px-4 py-2.5 shadow-sm">
                            <p class="text-sm text-white leading-relaxed" x-text="msg.text"></p>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Quick Replies --}}
            <div x-show="showQuickReplies && filteredQuickReplies.length > 0"
                x-transition:enter="transition-all duration-300 ease-out"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="flex flex-wrap gap-2 pt-1">
                <template x-for="(reply, idx) in filteredQuickReplies" :key="idx">
                    <button @click="handleQuickReply(reply)"
                        class="text-xs font-medium px-3.5 py-2 rounded-xl border border-green-200 dark:border-green-700 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 hover:bg-green-100 dark:hover:bg-green-900/40 hover:border-green-300 dark:hover:border-green-600 hover:shadow-sm active:scale-95 transition-all duration-200"
                        x-text="reply.text">
                    </button>
                </template>
            </div>

            {{-- Typing indicator --}}
            <div x-show="isLoading"
                x-transition:enter="transition-all duration-200"
                class="flex items-start gap-2.5 max-w-[85%]">
                <div class="w-7 h-7 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="bg-white dark:bg-slate-700 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm border border-slate-100 dark:border-slate-600">
                    <div class="flex gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-slate-400 dark:bg-slate-500 typing-dot"></span>
                        <span class="w-2 h-2 rounded-full bg-slate-400 dark:bg-slate-500 typing-dot"></span>
                        <span class="w-2 h-2 rounded-full bg-slate-400 dark:bg-slate-500 typing-dot"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- WhatsApp CTA --}}
        <div x-show="messages.length > 1" x-transition class="flex-shrink-0 px-4 pb-2 border-t border-slate-100 dark:border-slate-700">
            <a href="https://wa.me/{{ setting('whatsapp_number', '6281234567890') }}?text={{ urlencode(setting('whatsapp_text', 'Halo saya tertarik dengan layanan reklame')) }}"
                target="_blank" rel="noopener noreferrer"
                class="flex items-center justify-center gap-2 w-full py-2.5 mt-2 text-xs font-medium text-green-700 dark:text-green-300 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-xl border border-green-200 dark:border-green-700/50 transition-all duration-200 group">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                Hubungi via WhatsApp
                <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 -translate-x-1 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        {{-- Input --}}
        <div class="flex-shrink-0 p-3 border-t border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-800">
            <div class="flex items-center gap-2">
                <div class="flex-1 relative">
                    <input x-model="input"
                        @keydown="handleKeydown"
                        type="text"
                        placeholder="Ketik pesan..."
                        class="w-full px-4 py-2.5 pr-10 text-sm bg-slate-100 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-green-500/40 focus:border-green-500 outline-none transition-all text-slate-700 dark:text-slate-200 placeholder:text-slate-400 dark:placeholder:text-slate-500">
                </div>
                <button @click="sendMessage"
                    :disabled="!input.trim() || isLoading"
                    :class="input.trim() && !isLoading ? 'bg-gradient-to-r from-green-500 to-emerald-600 hover:shadow-lg hover:shadow-green-500/25' : 'bg-slate-300 dark:bg-slate-600 cursor-not-allowed'"
                    class="w-10 h-10 flex items-center justify-center rounded-xl text-white transition-all duration-200 active:scale-95 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

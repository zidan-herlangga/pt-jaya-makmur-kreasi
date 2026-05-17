import './bootstrap';

window.togglePassword = function (btn) {
    const wrapper = btn.closest('.password-toggle');
    const input = wrapper.querySelector('input');
    const showIcon = wrapper.querySelector('.password-eye');
    const hideIcon = wrapper.querySelector('.password-eye-off');

    if (input.type === 'password') {
        input.type = 'text';
        showIcon?.classList.add('hidden');
        hideIcon?.classList.remove('hidden');
    } else {
        input.type = 'password';
        showIcon?.classList.remove('hidden');
        hideIcon?.classList.add('hidden');
    }
};

document.addEventListener('alpine:init', () => {
    Alpine.data('galleryManager', (config = {}) => ({
        existingImages: config.existingImages ?? [],
        newFiles: [],
        deletedImages: [],
        maxFiles: config.maxFiles ?? 4,

        get totalCount() {
            return this.existingImages.length + this.newFiles.length;
        },

        get canAddMore() {
            return this.totalCount < this.maxFiles;
        },

        get statusText() {
            const sisa = this.maxFiles - this.totalCount;
            if (sisa <= 0) return 'Galeri penuh (maks. ' + this.maxFiles + ' gambar)';
            return sisa + ' dari ' + this.maxFiles + ' slot tersisa';
        },

        addFiles(event) {
            const files = Array.from(event.target.files);
            const remaining = this.maxFiles - this.totalCount;

            files.slice(0, remaining).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.newFiles.push({ file, preview: e.target.result });
                };
                reader.readAsDataURL(file);
            });

            event.target.value = '';
        },

        removeNew(index) {
            this.newFiles.splice(index, 1);
        },

        removeExisting(index) {
            this.deletedImages.push(this.existingImages[index].path);
            this.existingImages.splice(index, 1);
        },

        beforeSubmit() {
            try {
                const input = document.querySelector('input[name="images[]"]');

                if (this.newFiles.length > 0 && input) {
                    const dt = new DataTransfer();
                    this.newFiles.forEach(f => dt.items.add(f.file));
                    input.files = dt.files;
                } else if (input) {
                    input.value = '';
                }

                const deletedInput = document.querySelector('input[name="deleted_images"]');
                if (deletedInput) deletedInput.value = JSON.stringify(this.deletedImages);
            } catch (e) {
                console.error('Gallery beforeSubmit error:', e);
            }
        }
    }));

    Alpine.data('chatbot', (config = {}) => ({
        open: false,
        messages: [],
        input: '',
        isLoading: false,
        showQuickReplies: true,
        apiFailed: false,

        siteName: config.siteName || 'PT. Jaya Makmur Kreasi',
        whatsapp: config.whatsapp || '6281234567890',
        waText: config.waText || 'Halo%20saya%20ingin%20bertanya%20tentang%20layanan%20reklame',
        address: config.address || '',
        phone: config.phone || '',
        email: config.email || '',

        quickReplies: [
            { text: 'Apa saja layanannya?', key: 'services' },
            { text: 'Bagaimana cara order?', key: 'order' },
            { text: 'Kisaran harga?', key: 'pricing' },
            { text: 'Lihat portofolio', key: 'portfolio' },
            { text: 'Lokasi kantor', key: 'location' },
        ],

        get filteredQuickReplies() {
            const usedKeys = this.messages.filter(m => m.type === 'bot' && m.key && m.key !== 'greeting').map(m => m.key);
            return this.quickReplies.filter(q => !usedKeys.includes(q.key));
        },

        get localResponses() {
            return {
                greeting: `Halo! Selamat datang di ${this.siteName} ✨<br><br>Ada yang bisa kami bantu? Silakan pilih pertanyaan di bawah atau ketik pesan langsung.`,
                services: 'Kami menyediakan berbagai layanan reklame unggulan:<br><br>🏢 <b>Billboard & Megatron</b> — Papan reklame ukuran besar di lokasi strategis<br>📍 <b>Baliho & Spanduk</b> — Fleksibel untuk berbagai kebutuhan promosi<br>🖨️ <b>Cetak Digital</b> — Print berkualitas tinggi untuk indoor & outdoor<br>💡 <b>Neon Box & Signage</b> — Branding yang terang dan menarik<br>📱 <b>Advertising Kreatif</b> — Solusi periklanan inovatif<br><br>Kunjungi halaman <a href="/katalog" class="text-green-600 underline font-medium">Katalog</a> kami untuk detail selengkapnya!',
                order: 'Proses pemesanan sangat mudah:<br><br>1️⃣ <b>Pilih Titik</b> — Telusuri titik reklame di halaman Katalog<br>2️⃣ <b>Konsultasi</b> — Hubungi tim kami untuk diskusi kebutuhan<br>3️⃣ <b>Konfirmasi</b> — Sepakati harga & jadwal pemasangan<br>4️⃣ <b>Pasang & Pantau</b> — Tim kami pasang reklame Anda<br><br>Tim sales kami siap membantu Anda! 🚀',
                pricing: 'Harga sewa reklame bervariasi tergantung beberapa faktor:<br><br>📍 <b>Lokasi</b> — Titik strategis vs area biasa<br>📐 <b>Ukuran & Spesifikasi</b> — Semakin besar, semakin menonjol<br>⏳ <b>Durasi Sewa</b> — Harga spesial untuk jangka panjang<br>💡 <b>Jenis Reklame</b> — Billboard, baliho, neon box, dll.<br><br>Untuk info harga terbaru dan <b>diskusi kebutuhan</b>, silakan hubungi tim kami via WhatsApp 😊',
                location: `Kantor kami berlokasi di:<br><br>📍 <b>${this.siteName}</b><br>${this.address ? this.address.replace(/\n/g, '<br>') : 'Jl. Contoh No. 123'}<br><br>🕐 <b>Jam Operasional:</b><br>Senin - Jumat: 08.00 - 17.00<br>Sabtu: 08.00 - 14.00<br><br>Atau hubungi kami via WhatsApp untuk janji temu.`,
                portfolio: 'Kami telah mengerjakan berbagai proyek reklame untuk klien ternama! 🏆<br><br>Lihat portofolio lengkap kami di halaman <a href="/portofolio" class="text-green-600 underline font-medium">Portofolio</a> 📸',
                contact: `Anda bisa menghubungi kami melalui:<br><br>📞 <b>Telepon:</b> ${this.phone || '(021) 1234-5678'}<br>✉️ <b>Email:</b> ${this.email || 'info@jayamakmur.com'}<br>💬 <b>WhatsApp:</b> <a href="https://wa.me/${this.whatsapp}?text=${this.waText}" target="_blank" class="text-green-600 underline font-medium">Klik di sini</a><br><br>Atau kunjungi halaman <a href="/kontak" class="text-green-600 underline font-medium">Kontak</a> kami.`,
                fallback: 'Maaf, saya belum bisa menjawab pertanyaan tersebut. Silakan hubungi tim kami langsung melalui WhatsApp atau telepon untuk bantuan lebih lanjut 🙏<br><br>Atau Anda bisa menghubungi kami melalui halaman <a href="/kontak" class="text-green-600 underline font-medium">Kontak</a>.',
                irrelevant: 'Maaf, saya adalah asisten virtual ' + this.siteName + ' yang khusus membantu pertanyaan seputar <b>layanan reklame dan periklanan</b> 📢. Saat ini saya belum bisa menjawab pertanyaan di luar topik tersebut. Silakan tanyakan hal lain terkait layanan kami ya 😊',
                catalog: 'Kami memiliki berbagai titik reklame strategis yang tersedia. Silakan kunjungi halaman <a href="/katalog" class="text-green-600 underline font-medium">Katalog</a> untuk melihat daftar lengkap titik reklame beserta harga dan spesifikasinya 📍',
                about: `<b>${this.siteName}</b> adalah perusahaan yang bergerak di bidang <b>jasa periklanan dan reklame</b> terpercaya. Kami menyediakan berbagai solusi advertising mulai dari billboard, baliho, megatron, neon box, hingga cetak digital.<br><br>Kunjungi halaman <a href="/tentang" class="text-green-600 underline font-medium">Tentang Kami</a> untuk informasi lebih lanjut. 🚀`,
            };
        },

        init() {
            this.$watch('open', (val) => {
                if (val && this.messages.length === 0) {
                    this.$nextTick(() => {
                        setTimeout(() => {
                            this.addBotMessage('greeting');
                        }, 400);
                    });
                }
            });
        },

        toggle() {
            this.open = !this.open;
        },

        addBotMessage(key) {
            const text = this.localResponses[key] || this.localResponses.fallback;
            this.messages.push({ type: 'bot', text, key });
            this.$nextTick(() => this.scrollToBottom());
        },

        addBotResponse(text, key) {
            this.messages.push({ type: 'bot', text, key: key || 'api' });
            this.$nextTick(() => this.scrollToBottom());
        },

        async callApi(message) {
            try {
                const res = await fetch('/api/chatbot/query', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ message }),
                });
                if (!res.ok) throw new Error('API error');
                const data = await res.json();
                return data;
            } catch {
                return null;
            }
        },

        handleQuickReply(reply) {
            this.showQuickReplies = false;
            this.messages.push({ type: 'user', text: reply.text });
            this.$nextTick(() => this.scrollToBottom());
            this.isLoading = true;
            setTimeout(() => {
                this.isLoading = false;
                if (!this.apiFailed && !navigator.onLine === false) {
                    this.callApi(reply.text).then(data => {
                        if (data) {
                            this.addBotResponse(data.response, data.key);
                        } else {
                            this.apiFailed = true;
                            this.addBotMessage(reply.key);
                        }
                    });
                } else {
                    this.addBotMessage(reply.key);
                }
                this.$nextTick(() => {
                    if (this.filteredQuickReplies.length > 0) {
                        this.showQuickReplies = true;
                    }
                });
            }, 600 + Math.random() * 400);
        },

        detectIntent(text) {
            const lower = text.toLowerCase().trim();
            const business = /(reklame|iklan|billboard|baliho|spanduk|megatron|neon.?box|signage|cetak|print|advertising|promo|branding|banner|periklanan|sewa|pemasangan|jasa|layanan|luar.?ruang|outdoor|videotron)/i;
            const greetings = /^(halo|hi|hai|hey|helo|pagi|siang|sore|malam|test|tes|assalamualaikum|permisi|misi|bang|kak|selamat)/i;
            const pricing = /(harga|price|biaya|tarif|cost|mahal|murah|berapa|kisaran|dana|anggaran|rate|price.?list)/i;
            const order = /(order|pesan|pesanan|cara.*order|cara.*pesan|booking|pasang|langkah|proses|step|tahapan|gimana.*cara)/i;
            const contact = /(kontak|telepon|telp|phone|call|hubungi|email|wa|whatsapp|cs|customer.?service)/i;
            const location = /(?:lokasi|alamat|bertemu|datang|maps|posisi).*(?:kantor|perusahaan)|(?:kantor|perusahaan).*(?:lokasi|alamat|di mana)|(?:^|\s)(?:lokasi|alamat)(?=\s|$)/i;
            const portfolio = /(portfolio|portofolio|proyek|project|klien|client|hasil|karya|contoh|referensi|pernah)/i;
            const catalog = /(katalog|titik|point|daftar|list|reklame.*(?:tersedia|ada|lokasi)|(?:tersedia|ada).*reklame|pilihan.*reklame|kota|jakarta|bandung|surabaya)/i;
            const about = /(tentang|profile|perusahaan|sejarah|visi|misi|pt|cv|makmur|kreasi)/i;
            const services = /(layanan|jasa|service|apa.*saja|bisa.*apa|sediakan|menyediakan|keunggulan)/i;

            if (greetings.test(lower)) return 'greeting';
            if (pricing.test(lower)) return 'pricing';
            if (order.test(lower)) return 'order';
            if (contact.test(lower)) return 'contact';
            if (location.test(lower)) return 'location';
            if (portfolio.test(lower)) return 'portfolio';
            if (catalog.test(lower)) return 'catalog';
            if (about.test(lower)) return 'about';
            if (services.test(lower)) return 'services';

            if (!business.test(lower)) return 'irrelevant';
            return 'fallback';
        },

        async sendMessage() {
            const text = this.input.trim();
            if (!text || this.isLoading) return;
            this.showQuickReplies = false;
            this.messages.push({ type: 'user', text });
            this.input = '';
            this.$nextTick(() => this.scrollToBottom());
            this.isLoading = true;

            const data = await this.callApi(text);
            if (data) {
                this.isLoading = false;
                this.addBotResponse(data.response, data.key);
                this.$nextTick(() => {
                    if (data.key !== 'irrelevant' && this.filteredQuickReplies.length > 0) {
                        this.showQuickReplies = true;
                    }
                });
            } else {
                const intent = this.detectIntent(text);
                this.isLoading = false;
                this.addBotMessage(intent);
                this.$nextTick(() => {
                    if (intent !== 'irrelevant' && this.filteredQuickReplies.length > 0) {
                        this.showQuickReplies = true;
                    }
                });
            }
        },

        scrollToBottom() {
            if (this.$refs.messages) {
                this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight;
            }
        },

        handleKeydown(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        },
    }));
});

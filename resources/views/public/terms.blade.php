@extends('layouts.app', ['seo' => $seo])

@section('content')
    <div class="page-header py-16">
        <div class="page-header-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <x-breadcrumbs :items="['Syarat & Ketentuan' => '']" />
            <div class="mt-6 max-w-3xl">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-full text-green-400 text-sm font-medium mb-4">
                    Legal
                </span>
                <h1 class="text-3xl lg:text-5xl font-extrabold text-white leading-tight mt-3">Syarat & Ketentuan</h1>
                <p class="text-slate-300 mt-3 text-lg">{{ setting('site_name', 'PT. Jaya Makmur') }}</p>
            </div>
        </div>
    </div>

    <section class="py-16 lg:py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="prose prose-slate max-w-none prose-headings:text-slate-900 prose-headings:font-bold prose-h2:text-2xl prose-h2:mt-10 prose-h2:mb-4 prose-h3:text-xl prose-h3:mt-8 prose-h3:mb-3 prose-p:text-slate-600 prose-p:leading-relaxed prose-p:mb-4 prose-ul:text-slate-600 prose-ul:leading-relaxed prose-li:mb-2 prose-strong:text-slate-800">
                <p class="text-slate-500 text-sm dark:text-slate-300">Terakhir diperbarui: {{ date('d F Y') }}</p>

                <p class="dark:text-slate-300">
                    Dengan mengakses dan menggunakan website {{ setting('site_name', 'PT. Jaya Makmur') }}, Anda menyetujui
                    untuk terikat oleh syarat dan ketentuan berikut. Jika Anda tidak setuju dengan bagian mana pun dari
                    syarat ini, harap jangan gunakan website atau layanan kami.
                </p>

                <h2 class="dark:text-white">1. Definisi</h2>
                <ul>
                    <li class="dark:text-slate-300"><strong class="dark:text-white">"Perusahaan"</strong> merujuk pada
                        {{ setting('site_name', 'PT. Jaya Makmur') }}, penyedia
                        jasa reklame dan periklanan.</li>
                    <li class="dark:text-slate-300"><strong class="dark:text-white">"Pengguna"</strong> merujuk pada
                        individu atau entitas yang
                        mengakses atau menggunakan
                        website ini.</li>
                    <li class="dark:text-slate-300"><strong class="dark:text-white">"Layanan"</strong> merujuk pada semua
                        produk dan jasa yang
                        ditawarkan oleh perusahaan,
                        termasuk namun tidak terbatas pada sewa billboard, baliho, dan media reklame lainnya.</li>
                </ul>

                <h2 class="dark:text-white">2. Layanan</h2>
                <p class="dark:text-slate-300">
                    Perusahaan menyediakan platform untuk informasi dan pemesanan media reklame. Informasi yang ditampilkan
                    di website ini bersifat informatif dan dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya. Untuk
                    informasi lebih lanjut mengenai ketersediaan dan harga, silakan hubungi tim kami.
                </p>

                <h2 class="dark:text-white">3. Penggunaan Website</h2>
                <p class="dark:text-slate-300">Pengguna setuju untuk:</p>
                <ul>
                    <li class="dark:text-slate-300">Tidak menggunakan website untuk tujuan ilegal atau terlarang</li>
                    <li class="dark:text-slate-300">Tidak mengganggu atau merusak keamanan website</li>
                    <li class="dark:text-slate-300">Tidak mencoba mengakses area terbatas tanpa otorisasi</li>
                    <li class="dark:text-slate-300">Memberikan informasi yang akurat dan terkini saat menggunakan form
                        kontak atau pendaftaran</li>
                </ul>

                <h2 class="dark:text-white">4. Hak Kekayaan Intelektual</h2>
                <p class="dark:text-slate-300">
                    Seluruh konten yang terdapat di website ini, termasuk namun tidak terbatas pada teks, gambar, logo,
                    grafik, dan desain, dilindungi oleh hak cipta dan hak kekayaan intelektual lainnya milik perusahaan atau
                    pemberi lisensi. Dilarang mereproduksi, mendistribusikan, atau menggunakan konten tanpa izin tertulis
                    dari perusahaan.
                </p>

                <h2 class="dark:text-white">5. Harga & Pembayaran</h2>
                <p class="dark:text-slate-300">
                    Harga yang tercantum di website dapat berubah sewaktu-waktu tanpa pemberitahuan. Harga final akan
                    dikonfirmasi melalui proses inquiry dan penawaran resmi. Pembayaran harus dilakukan sesuai dengan
                    ketentuan yang tercantum dalam kontrak atau invoice yang diterbitkan.
                </p>

                <h2 class="dark:text-white">6. Pembatalan & Pengembalian Dana</h2>
                <p class="dark:text-slate-300">
                    Kebijakan pembatalan dan pengembalian dana akan diatur dalam kontrak terpisah antara perusahaan dan
                    klien. Secara umum, pembatalan yang dilakukan setelah kontrak ditandatangani dapat dikenakan biaya
                    pembatalan sesuai dengan ketentuan yang berlaku.
                </p>

                <h2 class="dark:text-white">7. Batasan Tanggung Jawab</h2>
                <p class="dark:text-slate-300">
                    Perusahaan tidak bertanggung jawab atas kerugian tidak langsung, insidental, atau konsekuensial yang
                    timbul dari penggunaan atau ketidakmampuan menggunakan layanan kami. Tanggung jawab perusahaan dibatasi
                    pada jumlah yang dibayarkan oleh pengguna untuk layanan yang bersangkutan.
                </p>

                <h2 class="dark:text-white">8. Tautan ke Pihak Ketiga</h2>
                <p class="dark:text-slate-300">
                    Website kami dapat berisi tautan ke website pihak ketiga. Kami tidak memiliki kendali atas konten atau
                    praktik privasi website tersebut dan tidak bertanggung jawab atas kerugian yang mungkin timbul dari
                    penggunaannya.
                </p>

                <h2 class="dark:text-white">9. Perubahan Syarat & Ketentuan</h2>
                <p class="dark:text-slate-300">
                    Perusahaan berhak untuk mengubah syarat dan ketentuan ini kapan saja. Perubahan akan diumumkan melalui
                    halaman ini. Penggunaan berkelanjutan website setelah perubahan dianggap sebagai penerimaan terhadap
                    syarat yang telah diperbarui.
                </p>

                <h2 class="dark:text-white">10. Hukum yang Berlaku</h2>
                <p class="dark:text-slate-300">
                    Syarat dan ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum yang berlaku di Republik
                    Indonesia. Setiap sengketa yang timbul akan diselesaikan melalui musyawarah atau melalui pengadilan yang
                    berwenang di Indonesia.
                </p>

                <h2 class="dark:text-white">11. Hubungi Kami</h2>
                <p class="dark:text-slate-300">
                    Jika Anda memiliki pertanyaan tentang syarat dan ketentuan ini, silakan hubungi kami melalui:
                </p>
                <ul>
                    <li class="dark:text-slate-300">Email: {{ setting('email', 'info@jayamakmur.com') }}</li>
                    <li class="dark:text-slate-300">Telepon: {{ setting('phone', '+62 812-3456-7890') }}</li>
                    <li class="dark:text-slate-300">
                        Alamat: {{ setting('address', 'Jl. Sudirman No. 123') }}
                        {{-- {{ setting('address2', 'Jakarta Pusat, Indonesia') }} --}}
                    </li>
                </ul>
            </div>
        </div>
    </section>
@endsection

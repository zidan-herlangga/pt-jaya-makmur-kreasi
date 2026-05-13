@extends('layouts.app', ['seo' => $seo])

@section('content')
    <div class="page-header py-16">
        <div class="page-header-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <x-breadcrumbs :items="['Kebijakan Privasi' => '']" />
            <div class="mt-6 max-w-3xl">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-full text-green-400 text-sm font-medium mb-4">
                    Legal
                </span>
                <h1 class="text-3xl lg:text-5xl font-extrabold text-white leading-tight mt-3">Kebijakan Privasi</h1>
                <p class="text-slate-300 mt-3 text-lg">{{ setting('site_name', 'PT. Jaya Makmur') }}</p>
            </div>
        </div>
    </div>

    <section class="py-16 lg:py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-slate max-w-none prose-headings:text-slate-900 prose-headings:font-bold prose-h2:text-2xl prose-h2:mt-10 prose-h2:mb-4 prose-h3:text-xl prose-h3:mt-8 prose-h3:mb-3 prose-p:text-slate-600 prose-p:leading-relaxed prose-p:mb-4 prose-ul:text-slate-600 prose-ul:leading-relaxed prose-li:mb-2 prose-strong:text-slate-800">
                <p class="text-slate-500 text-sm">Terakhir diperbarui: {{ date('d F Y') }}</p>

                <p>
                    {{ setting('site_name', 'PT. Jaya Makmur') }} ("kami", "kita", atau "perusahaan") berkomitmen untuk melindungi privasi pengguna website ini. Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengungkapkan, dan melindungi informasi pribadi Anda saat mengakses dan menggunakan layanan kami.
                </p>

                <h2>1. Informasi yang Kami Kumpulkan</h2>
                <p>Kami dapat mengumpulkan informasi berikut:</p>
                <ul>
                    <li><strong>Informasi Identitas Pribadi:</strong> Nama, alamat email, nomor telepon, dan informasi lain yang Anda berikan melalui form kontak atau pendaftaran.</li>
                    <li><strong>Informasi Penggunaan:</strong> Data tentang bagaimana Anda mengakses dan menggunakan website kami, termasuk halaman yang dikunjungi, waktu kunjungan, dan durasi.</li>
                    <li><strong>Informasi Teknis:</strong> Alamat IP, jenis browser, sistem operasi, dan data teknis lainnya yang dikumpulkan secara otomatis.</li>
                </ul>

                <h2>2. Cara Kami Menggunakan Informasi</h2>
                <p>Informasi yang kami kumpulkan digunakan untuk:</p>
                <ul>
                    <li>Menyediakan, mengoperasikan, dan memelihara layanan kami</li>
                    <li>Menanggapi pertanyaan, komentar, atau keluhan Anda</li>
                    <li>Mengirimkan informasi tentang layanan, penawaran, dan pembaruan (dengan persetujuan Anda)</li>
                    <li>Meningkatkan pengalaman pengguna dan kualitas layanan</li>
                    <li>Mematuhi kewajiban hukum dan peraturan yang berlaku</li>
                </ul>

                <h2>3. Perlindungan Data</h2>
                <p>
                    Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk melindungi informasi pribadi Anda dari akses tidak sah, perubahan, pengungkapan, atau penghancuran. Namun, tidak ada metode transmisi data melalui internet yang sepenuhnya aman, sehingga kami tidak dapat menjamin keamanan absolut.
                </p>

                <h2>4. Pengungkapan kepada Pihak Ketiga</h2>
                <p>Kami tidak menjual, memperdagangkan, atau mentransfer informasi pribadi Anda kepada pihak ketiga tanpa persetujuan Anda, kecuali:</p>
                <ul>
                    <li>Penyedia layanan tepercaya yang membantu kami mengoperasikan website atau melayani Anda</li>
                    <li>Jika diwajibkan oleh hukum atau peraturan yang berlaku</li>
                    <li>Untuk melindungi hak, properti, atau keamanan perusahaan</li>
                </ul>

                <h2>5. Cookie</h2>
                <p>
                    Website kami dapat menggunakan cookie untuk meningkatkan pengalaman pengguna. Cookie adalah file kecil yang disimpan di perangkat Anda yang memungkinkan kami mengenali browser Anda dan mengingat preferensi tertentu. Anda dapat mengatur browser Anda untuk menolak cookie atau memberi peringatan saat cookie dikirim.
                </p>

                <h2>6. Hak Anda</h2>
                <p>Anda berhak untuk:</p>
                <ul>
                    <li>Mengakses data pribadi yang kami miliki tentang Anda</li>
                    <li>Meminta koreksi data yang tidak akurat atau tidak lengkap</li>
                    <li>Meminta penghapusan data pribadi Anda</li>
                    <li>Menolak pemrosesan data untuk tujuan pemasaran langsung</li>
                    <li>Mencabut persetujuan yang telah diberikan sebelumnya</li>
                </ul>

                <h2>7. Perubahan Kebijakan Privasi</h2>
                <p>
                    Kami dapat memperbarui kebijakan privasi ini dari waktu ke waktu. Setiap perubahan akan diumumkan melalui halaman ini. Kami mendorong Anda untuk meninjau halaman ini secara berkala untuk mengetahui informasi terbaru tentang praktik privasi kami.
                </p>

                <h2>8. Hubungi Kami</h2>
                <p>
                    Jika Anda memiliki pertanyaan tentang kebijakan privasi ini atau ingin menggunakan hak Anda terkait data pribadi, silakan hubungi kami melalui:
                </p>
                <ul>
                    <li>Email: {{ setting('email', 'info@jayamakmur.com') }}</li>
                    <li>Telepon: {{ setting('phone', '+62 812-3456-7890') }}</li>
                    <li>Alamat: {{ setting('address', 'Jl. Sudirman No. 123') }}, {{ setting('address2', 'Jakarta Pusat, Indonesia') }}</li>
                </ul>
            </div>
        </div>
    </section>
@endsection

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdvertisingPoint;
use App\Models\Portfolio;
use App\Models\Post;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    private array $context;

    public function __construct(
        private SettingService $settings
    ) {
        $this->context = [
            'site_name' => $this->settings->get('site_name', 'PT. Jaya Makmur Kreasi'),
            'address' => $this->settings->get('address', ''),
            'phone' => $this->settings->get('phone', ''),
            'email' => $this->settings->get('email', ''),
            'whatsapp' => $this->settings->get('whatsapp_number', '6281234567890'),
        ];
    }

    private static array $businessKeywords = [
        'reklame', 'iklan', 'billboard', 'baliho', 'spanduk', 'megatron', 'neon box',
        'signage', 'cetak', 'print', 'advertising', 'promo', 'promosi', 'branding',
        'banner', 'titik reklame', 'papan reklame', 'media luar ruang', 'outdoor',
        'periklanan', 'pemasangan', 'sewa reklame', 'jasa reklame', 'reklame',
        'brosur', 'flyer', 'baliho', 'videotron', 'led screen',
    ];

    private static array $allowedTopics = [
        'layanan', 'jasa', 'harga', 'biaya', 'order', 'pesan', 'booking', 'sewa',
        'lokasi', 'alamat', 'kantor', 'kontak', 'telepon', 'email', 'whatsapp',
        'portofolio', 'proyek', 'klien', 'tentang', 'profile', 'perusahaan',
        'cara order', 'proses', 'pembayaran', 'katalog', 'produk', 'tersedia',
        'kota', 'jakarta', 'bandung', 'surabaya', 'testing', 'test',
        'makmur', 'jaya', 'info', 'artikel', 'berita', 'blog',
    ];

    public function query(Request $request): JsonResponse
    {
        $request->validate(['message' => ['required', 'string', 'max:500']]);
        $message = trim($request->input('message'));

        $intent = $this->detectIntent($message);

        if ($intent === 'irrelevant') {
            return response()->json([
                'response' => $this->politeDecline(),
                'key' => 'irrelevant',
            ]);
        }

        $response = match ($intent) {
            'greeting' => $this->greetingResponse(),
            'services' => $this->servicesResponse(),
            'order' => $this->orderResponse(),
            'pricing' => $this->pricingResponse(),
            'location' => $this->locationResponse(),
            'portfolio' => $this->portfolioResponse(),
            'contact' => $this->contactResponse(),
            'catalog' => $this->catalogResponse(),
            'about' => $this->aboutResponse(),
            default => $this->fallbackResponse(),
        };

        return response()->json($response);
    }

    private function detectIntent(string $message): string
    {
        $lower = mb_strtolower($message);

        $greetings = '/^(halo|hi|hai|hey|helo|pagi|siang|sore|malam|test|tes|assalamualaikum|permisi|misi|bang|kak|selamat)\b/ui';
        $services = '/(layanan|jasa|service|apa.*saja|bisa.*apa|sediakan|menyediakan|reklame|billboard|baliho|megatron|spanduk|neon.?box|signage|cetak|print|keunggulan)/ui';
        $order = '/(order|pesan|pesanan|cara.*order|cara.*pesan|booking|pasang|langkah|proses|step|tahapan|gimana.*cara)/ui';
        $pricing = '/(harga|price|biaya|tarif|cost|mahal|murah|berapa|kisaran|dana|anggaran|rate|price.?list)/ui';
        $location = '/(?:lokasi|alamat|bertemu|datang|maps|posisi).*(?:kantor|perusahaan)|(?:kantor|perusahaan).*(?:lokasi|alamat|dimana)|(?:^|\s)(?:lokasi|alamat|kantor)(?:\s|$)/ui';
        $portfolio = '/(portfolio|portofolio|proyek|project|klien|client|hasil|karya|contoh|referensi|pernah.*buat|pernah.*kerja)/ui';
        $contact = '/(kontak|telepon|telp|phone|call|hubungi|email|wa|whatsapp|cs|customer.?service)/ui';
        $catalog = '/(katalog|titik|point|daftar|list|reklame.*tersedia|tersedia.*reklame|reklame.*ada|ada.*reklame|reklame.*lokasi|pilihan.*reklame)/ui';
        $about = '/(tentang|profile|perusahaan|sejarah|latar.*belakang|visi|misi|pt\.?\s*jaya|makmur|kreasi)/ui';

        if (preg_match($greetings, $lower)) return 'greeting';
        if (preg_match($pricing, $lower)) return 'pricing';
        if (preg_match($order, $lower)) return 'order';
        if (preg_match($contact, $lower)) return 'contact';
        if (preg_match($location, $lower)) return 'location';
        if (preg_match($portfolio, $lower)) return 'portfolio';
        if (preg_match($catalog, $lower)) return 'catalog';
        if (preg_match($about, $lower)) return 'about';
        if (preg_match($services, $lower)) return 'services';

        $allKeywords = array_merge(self::$businessKeywords, self::$allowedTopics);
        $matched = false;
        foreach ($allKeywords as $keyword) {
            if (str_contains($lower, $keyword)) {
                $matched = true;
                break;
            }
        }

        if (!$matched) return 'irrelevant';
        return 'fallback';
    }

    private function politeDecline(): string
    {
        $variants = [
            'Maaf, saya adalah asisten virtual ' . $this->context['site_name'] . ' yang khusus membantu pertanyaan seputar <b>layanan reklame dan periklanan</b> 📢. Saat ini saya belum bisa menjawab pertanyaan di luar topik tersebut. Silakan tanyakan hal lain terkait layanan kami ya 😊',
            'Mohon maaf 🙏, saya hanya bisa membantu pertanyaan seputar jasa reklame, billboard, baliho, dan periklanan dari ' . $this->context['site_name'] . '. Untuk pertanyaan lainnya, saya belum bisa merespon. Ada yang bisa kami bantu terkait layanan periklanan? 😊',
            'Halo! 👋 Saya asisten digital ' . $this->context['site_name'] . ' dan saya khusus membantu informasi seputar <b>dunia periklanan & reklame</b>. Pertanyaan Anda di luar topik tersebut. Silakan tanya seputar layanan reklame kami ya!',
        ];
        return $variants[array_rand($variants)];
    }

    private function greetingResponse(): array
    {
        $points = AdvertisingPoint::available()->count();
        $portfolios = Portfolio::where('status', 'published')->count();

        return [
            'response' => 'Halo! Selamat datang di ' . $this->context['site_name'] . ' ✨<br><br>'
                . 'Kami memiliki <b>' . $points . ' titik reklame</b> tersedia dan <b>' . $portfolios . ' proyek portofolio</b> yang sudah kami kerjakan.<br><br>'
                . 'Ada yang bisa saya bantu? Silakan tanya seputar layanan, harga, lokasi kantor, atau lihat portofolio kami!',
            'key' => 'greeting',
        ];
    }

    private function servicesResponse(): array
    {
        $points = AdvertisingPoint::available()->count();
        $cities = AdvertisingPoint::available()->whereNotNull('city')->distinct()->pluck('city');

        $response = 'Kami menyediakan berbagai layanan reklame unggulan:<br><br>'
            . '🏢 <b>Billboard & Megatron</b> — Papan reklame ukuran besar di lokasi strategis<br>'
            . '📍 <b>Baliho & Spanduk</b> — Fleksibel untuk berbagai kebutuhan promosi<br>'
            . '🖨️ <b>Cetak Digital</b> — Print berkualitas tinggi untuk indoor & outdoor<br>'
            . '💡 <b>Neon Box & Signage</b> — Branding yang terang dan menarik<br>'
            . '📱 <b>Advertising Kreatif</b> — Solusi periklanan inovatif<br><br>'
            . 'Saat ini tersedia <b>' . $points . ' titik reklame</b>';

        if ($cities->isNotEmpty()) {
            $response .= ' di ' . $cities->take(4)->join(', ', ' dan ');
        }

        $response .= '.<br><br>Kunjungi halaman <a href="/katalog" class="text-green-600 underline font-medium">Katalog</a> untuk detail selengkapnya!';

        return ['response' => $response, 'key' => 'services'];
    }

    private function orderResponse(): array
    {
        return [
            'response' => 'Proses pemesanan sangat mudah:<br><br>'
                . '1️⃣ <b>Pilih Titik</b> — Telusuri titik reklame di halaman <a href="/katalog" class="text-green-600 underline font-medium">Katalog</a><br>'
                . '2️⃣ <b>Konsultasi</b> — Hubungi tim kami untuk diskusi kebutuhan<br>'
                . '3️⃣ <b>Konfirmasi</b> — Sepakati harga & jadwal pemasangan<br>'
                . '4️⃣ <b>Pasang & Pantau</b> — Tim kami pasang reklame Anda<br><br>'
                . 'Tim sales kami siap membantu Anda! 🚀',
            'key' => 'order',
        ];
    }

    private function pricingResponse(): array
    {
        $points = AdvertisingPoint::available()->whereNotNull('price')->get();
        $minPrice = $points->min('price');
        $maxPrice = $points->max('price');

        $response = 'Harga sewa reklame bervariasi tergantung beberapa faktor:<br><br>'
            . '📍 <b>Lokasi</b> — Titik strategis vs area biasa<br>'
            . '📐 <b>Ukuran & Spesifikasi</b> — Semakin besar, semakin menonjol<br>'
            . '⏳ <b>Durasi Sewa</b> — Harga spesial untuk jangka panjang<br>'
            . '💡 <b>Jenis Reklame</b> — Billboard, baliho, neon box, dll.<br>';

        if ($minPrice && $maxPrice) {
            $response .= '<br>💰 <b>Kisaran harga:</b> Rp ' . number_format($minPrice, 0, ',', '.')
                . ' – Rp ' . number_format($maxPrice, 0, ',', '.') . ' per periode';
        }

        $response .= '<br><br>Untuk info harga terbaru dan diskusi kebutuhan, silakan hubungi tim kami via WhatsApp atau kunjungi halaman <a href="/katalog" class="text-green-600 underline font-medium">Katalog</a> 😊';

        return ['response' => $response, 'key' => 'pricing'];
    }

    private function locationResponse(): array
    {
        $address = $this->context['address'];
        $response = '📍 <b>' . $this->context['site_name'] . '</b><br>';

        if ($address) {
            $response .= nl2br(e($address)) . '<br><br>';
        }

        $response .= '🕐 <b>Jam Operasional:</b><br>'
            . 'Senin - Jumat: 08.00 - 17.00<br>'
            . 'Sabtu: 08.00 - 14.00<br><br>'
            . 'Atau hubungi kami via WhatsApp untuk janji temu.';

        return ['response' => $response, 'key' => 'location'];
    }

    private function portfolioResponse(): array
    {
        $portfolios = Portfolio::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $response = 'Kami telah mengerjakan berbagai proyek reklame untuk klien ternama 🏆<br><br>';

        if ($portfolios->isNotEmpty()) {
            foreach ($portfolios as $p) {
                $response .= '• <b>' . e($p->title) . '</b>'
                    . ($p->client_name ? ' — ' . e($p->client_name) : '') . '<br>';
            }
            $response .= '<br>Lihat portofolio lengkap di halaman <a href="/portofolio" class="text-green-600 underline font-medium">Portofolio</a> 📸';
        } else {
            $response .= 'Kunjungi halaman <a href="/portofolio" class="text-green-600 underline font-medium">Portofolio</a> untuk melihat proyek-proyek terbaru kami 📸';
        }

        return ['response' => $response, 'key' => 'portfolio'];
    }

    private function contactResponse(): array
    {
        $response = 'Anda bisa menghubungi kami melalui:<br><br>';

        if ($this->context['phone']) {
            $response .= '📞 <b>Telepon:</b> ' . e($this->context['phone']) . '<br>';
        }
        if ($this->context['email']) {
            $response .= '✉️ <b>Email:</b> ' . e($this->context['email']) . '<br>';
        }
        $response .= '💬 <b>WhatsApp:</b> <a href="https://wa.me/' . $this->context['whatsapp']
            . '?text=Halo%20saya%20ingin%20bertanya%20tentang%20layanan%20reklame" target="_blank" class="text-green-600 underline font-medium">Klik di sini</a><br><br>'
            . 'Atau kunjungi halaman <a href="/kontak" class="text-green-600 underline font-medium">Kontak</a> kami.';

        return ['response' => $response, 'key' => 'contact'];
    }

    private function catalogResponse(): array
    {
        $points = AdvertisingPoint::available()
            ->with('category')
            ->orderBy('city')
            ->take(10)
            ->get();

        $total = AdvertisingPoint::available()->count();
        $cities = AdvertisingPoint::available()->whereNotNull('city')->distinct()->pluck('city');

        $response = 'Berikut titik reklame yang tersedia ';

        if ($cities->isNotEmpty()) {
            $response .= 'di ' . $cities->take(4)->join(', ', ' dan ');
        }
        $response .= ':<br><br>';

        if ($points->isNotEmpty()) {
            $grouped = $points->groupBy('city');
            foreach ($grouped as $city => $cityPoints) {
                if ($city) {
                    $response .= '📍 <b>' . e($city) . '</b><br>';
                }
                foreach ($cityPoints as $point) {
                    $response .= '&nbsp;&nbsp;• ' . e($point->title)
                        . ($point->size_dimension ? ' (' . e($point->size_dimension) . ')' : '')
                        . ($point->price ? ' — Rp ' . number_format($point->price, 0, ',', '.') : '')
                        . '<br>';
                }
            }
        } else {
            $response .= 'Saat ini belum ada titik reklame yang tersedia. Silakan hubungi kami untuk informasi lebih lanjut.';
        }

        $response .= '<br><a href="/katalog" class="text-green-600 underline font-medium">Lihat semua ' . $total . ' titik →</a>';

        return ['response' => $response, 'key' => 'catalog'];
    }

    private function aboutResponse(): array
    {
        return [
            'response' => '<b>' . $this->context['site_name'] . '</b> adalah perusahaan yang bergerak di bidang <b>jasa periklanan dan reklame</b> terpercaya. Kami menyediakan berbagai solusi advertising mulai dari billboard, baliho, megatron, neon box, hingga cetak digital.<br><br>'
                . 'Dengan pengalaman dan jaringan luas, kami siap membantu brand Anda tampil lebih menonjol di lokasi-lokasi strategis. 🚀<br><br>'
                . 'Kunjungi halaman <a href="/tentang" class="text-green-600 underline font-medium">Tentang Kami</a> untuk informasi lebih lanjut.',
            'key' => 'about',
        ];
    }

    private function fallbackResponse(): array
    {
        return [
            'response' => 'Maaf, saya belum bisa menjawab pertanyaan tersebut. Silakan hubungi tim kami langsung melalui WhatsApp atau telepon untuk bantuan lebih lanjut 🙏<br><br>'
                . 'Atau Anda bisa menghubungi kami melalui halaman <a href="/kontak" class="text-green-600 underline font-medium">Kontak</a>.',
            'key' => 'fallback',
        ];
    }
}

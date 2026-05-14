# PT. Jaya Makmur Kreasi — Sistem Informasi Periklanan & Reklame

Sistem informasi manajemen periklanan dan reklame berbasis web untuk PT. Jaya Makmur Kreasi. Dibangun dengan Laravel 11, mencakup website company profile, katalog titik reklame, portofolio, berita, manajemen inquiry, dan panel admin lengkap.

## Fitur

### Publik

- **Beranda** — Hero banner, statistik, titik reklame unggulan, portofolio, berita terbaru, testimoni, trust badges, floating WhatsApp
- **Katalog Produk** — Grid pencarian titik reklame dengan filter kota, kategori, orientasi, jenis lampu, harga; sorting dan detail produk dengan galeri
- **Portofolio** — Galeri proyek klien dengan filter kategori
- **Berita** — Artikel dan blog dengan filter kategori, estimasi waktu baca
- **Kontak** — Form inquiry dengan honeypot anti-spam, notifikasi email ke admin
- **Newsletter** — Langganan email via AJAX
- **SEO Lengkap** — Meta tags Open Graph, Twitter Cards, JSON-LD structured data (Organization, Product, NewsArticle, CreativeWork)

### Admin Panel

- **Dashboard** — Statistik, grafik inquiry bulanan, titik populer
- **Titik Reklame CRUD** — Manajemen titik reklame dengan optimasi gambar (4 varian WebP), galeri, SEO fields, soft deletes
- **Portofolio CRUD** — Proyek klien dengan galeri gambar
- **Artikel CRUD** — TinyMCE rich text editor, excerpt otomatis, kategori
- **Inquiry Management** — Workflow status (pending/processed/spam/archived), catatan admin
- **Kategori** — Manajemen kategori (produk & post) dengan icon
- **Users** — Manajemen pengguna dengan role (super-admin, admin, editor)
- **Settings** — Pengaturan dinamis (umum, SEO, sosial media, kontak, tampilan)
- **Newsletter** — Daftar subscriber, export CSV

## Tech Stack

| Lapisan       | Teknologi                                |
| ------------- | ---------------------------------------- |
| **Framework** | Laravel 11                               |
| **PHP**       | ^8.2                                     |
| **Database**  | MySQL                                    |
| **CSS**       | Tailwind CSS 3 + @tailwindcss/typography |
| **JS**        | Alpine.js 3, TinyMCE 8                   |
| **Build**     | Vite 5                                   |
| **Auth**      | Laravel Auth (session-based)             |
| **RBAC**      | Spatie Laravel Permission                |
| **Image**     | Intervention Image 3                     |

## Persyaratan

- PHP ^8.2
- Composer
- Node.js & NPM
- MySQL 5+

## Instalasi

```bash
# Clone repositori
git clone <repository-url>
cd ProjekIklan

# Install dependencies PHP
composer install

# Install dependencies frontend
npm install && npm run build

# Copy environment
cp .env.example .env
# Edit .env sesuai konfigurasi database dan mail Anda

# Generate key
php artisan key:generate

# Migrasi dan seeder
php artisan migrate --seed

# Storage link
php artisan storage:link

# Jalankan
php artisan serve
```

## Role Pengguna

| Role            | Akses                                                       |
| --------------- | ----------------------------------------------------------- |
| **super-admin** | Akses penuh ke semua fitur, termasuk manajemen user         |
| **admin**       | Semua CRUD kecuali manajemen user                           |
| **editor**      | View + Create + Edit (tanpa delete), akses inquiry terbatas |

Login default setelah seeder: `superadmin@example.com` / `password`

## Pengembang

Zidan Herlangga :
Dibangun menggunakan [Laravel](https://laravel.com).

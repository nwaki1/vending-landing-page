# Plan: Landing Page Company Vending Machine

Dokumen ini merangkum scope kerja untuk membangun landing page company + CMS/admin untuk produk vending machine.

## Tujuan

- Menampilkan company profile yang jelas dan meyakinkan.
- Mendorong conversion lewat CTA beli/sewa, WhatsApp, dan form konsultasi.
- Menyediakan katalog produk vending machine yang mudah difilter dan dibandingkan.
- Menyediakan CMS/admin untuk pengelolaan konten, produk, banner, artikel, testimoni, dan leads.

## Scope Frontend

### 1. Landing Page Company

- Hero section
- Branding
- CTA beli/sewa
- Keunggulan

### 2. Katalog Produk

- List vending machine
- Filter kategori
- Perbandingan spesifikasi

### 3. Lead Generation

- Tombol WhatsApp
- Form konsultasi
- CTA `Mulai Sekarang`

## Scope CMS / Admin

- Kelola produk
- Kelola banner
- Kelola artikel/testimoni
- Leads customer

## Struktur Konten

### Company Section

- Nama brand
- Value proposition utama
- Deskripsi singkat perusahaan
- Keunggulan utama
- CTA utama dan sekunder

### Catalog Section

- Daftar produk vending machine
- Kategori produk
- Harga atau status harga
- Spesifikasi inti
- Foto produk
- Status ketersediaan

### Lead Section

- Nama customer
- Nomor WhatsApp
- Email
- Kebutuhan customer
- Catatan tambahan
- Sumber lead

### CMS Content

- Banner home
- Artikel edukasi
- Testimoni customer
- Data produk
- Data leads

## Rencana Implementasi

### Phase 1: Company Landing Page ✅

- [x] Susun layout landing page utama (Navbar, Hero, Stats, Footer).
- [x] Tampilkan branding dan CTA utama (Beli Sekarang / Sewa Unit).
- [x] Buat section keunggulan (6 poin).
- [x] Buat ringkasan produk (3 product cards placeholder).
- [x] Buat section CTA konsultasi dengan form UI (belum functional).
- [x] Tambahkan tombol WhatsApp di footer.
- [x] Setup `HomeController` dan route `/`.

### Phase 2: Katalog Produk & Perbandingan

Prasyarat: model `Product` dan migration harus ada sebelum phase ini.

**Database:**
- Migration tabel `products`: `name`, `slug`, `category`, `description`, `price`, `specs` (JSON), `image`, `status` (`available`/`indent`/`unavailable`), `is_featured`, `timestamps`.
- Model `Product` + seeder data contoh (min. 6 produk, 3 kategori).

**Halaman `/katalog`:**
- Route `GET /katalog` → `CatalogController@index`.
- Tampilkan semua produk dari database.
- Filter kategori via query string `?category=snack` (tanpa reload halaman, pakai Alpine.js atau JS vanilla).
- Card produk: foto, nama, kategori, harga, spesifikasi ringkas, tombol "Detail" dan "Tanya Harga".

**Halaman `/katalog/{slug}`:**
- Route `GET /katalog/{product:slug}` → `CatalogController@show`.
- Detail produk lengkap: galeri foto, spesifikasi penuh, CTA konsultasi.

**Blok perbandingan spesifikasi:**
- Tambahkan section di halaman katalog atau landing page.
- User bisa pilih 2–3 produk untuk dibandingkan side-by-side (tabel spesifikasi).
- Implementasi dengan JS (state pilihan produk di frontend, tabel render dinamis).

**Integrasi landing page:**
- Update section ringkasan produk di `welcome.blade.php` agar data diambil dari database (`Product::featured()`).
- Tombol "Lihat Semua Produk" mengarah ke `/katalog`.

### Phase 3: Lead Generation (Backend) ✅

UI sudah selesai di Phase 1. Phase ini fokus ke backend dan peningkatan UX.

**Database:**
- [x] Migration tabel `leads`: `name`, `whatsapp`, `email` (nullable), `need` (enum: `beli/sewa/info/service`), `message`, `source` (default: `landing_page`), `status` (enum: `new/contacted/closed`), `timestamps`.
- [x] Model `Lead` + accessor `need_label`, `status_label`.

**Backend form konsultasi:**
- [x] Route `POST /konsultasi` → `LeadController@store`.
- [x] Validasi server-side (name, whatsapp regex, email, need required).
- [x] Simpan lead ke tabel `leads`.
- [x] Redirect back dengan flash message sukses + tampil di form.
- [x] Form `welcome.blade.php` diupdate: action, `old()`, error display, field email ditambahkan.

**WhatsApp floating button:**
- [x] Tombol floating di kanan bawah semua halaman (`welcome.blade.php` + `layouts/app.blade.php`).
- [x] Muncul setelah scroll 300px dari atas (JS vanilla).

**Anti-spam:**
- [x] Honeypot field `website` (hidden, bot isi — manusia tidak).
- [x] Rate limiting `throttle:5,1` pada route POST konsultasi.

### Phase 4: CMS / Admin ✅

Prasyarat: autentikasi admin harus ada (Laravel Breeze atau guard terpisah).

**Autentikasi:**
- Setup Laravel Breeze atau guard `admin` tersendiri.
- Proteksi semua route `/admin/*` dengan middleware `auth` + role check.

**Dashboard:**
- Halaman `/admin` — ringkasan: total produk, total leads baru, leads bulan ini.

**Kelola Produk (`/admin/products`):**
- CRUD lengkap: list, create, edit, delete.
- Upload foto produk (storage disk `public`).
- Toggle status `is_featured` untuk produk yang tampil di landing page.

**Kelola Leads (`/admin/leads`):**
- List semua leads dengan filter status (`new/contacted/closed`).
- Update status lead.
- Tombol quick-reply WhatsApp langsung dari tabel.
- Export ke CSV.

**Kelola Banner (`/admin/banners`):**
- CRUD banner untuk hero section (judul, subjudul, CTA, gambar, urutan tampil).

**Kelola Testimoni (`/admin/testimonials`):**
- CRUD testimoni customer (nama, foto, rating, isi teks, status publish).

**Kelola Artikel (`/admin/articles`):**
- CRUD artikel edukasi dengan editor teks sederhana.

## Prioritas MVP

1. Hero section + branding + CTA beli/sewa ✅
2. Keunggulan ✅
3. Ringkasan produk (UI placeholder) ✅
4. Form konsultasi UI ✅ / backend _(Phase 3)_
5. Tombol WhatsApp ✅ / floating button _(Phase 3)_
6. Katalog produk lengkap + filter _(Phase 2)_
7. Dashboard admin dasar untuk produk dan leads _(Phase 4)_

## Output Yang Diharapkan

- Landing page siap pakai untuk company profile.
- Katalog vending machine bisa difilter dan dibandingkan.
- Channel lead generation aktif (form tersimpan ke DB + WhatsApp).
- Admin panel minimal untuk mengelola produk, leads, dan konten.

## Catatan

- Fokus awal adalah conversion dan kejelasan informasi.
- CMS/admin bisa dikembangkan bertahap setelah MVP stabil.
- Struktur data (`products`, `leads`) harus disiapkan di Phase 2–3 agar Phase 4 bisa langsung CRUD tanpa migrasi ulang.
- Semua konten teks (brand, harga, kontak) di Phase 1 bersifat placeholder — bisa diupdate langsung di `welcome.blade.php` atau setelah CMS admin siap.

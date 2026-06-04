<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Solusi vending machine terpercaya untuk bisnis Anda. Pilihan beli atau sewa, garansi 2 tahun, support 24/7.">
    <title>VendoSmart — Solusi Vending Machine Terpercaya</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @endif

    <style>
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white">

    {{-- ===================== NAVBAR ===================== --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <a href="#" class="text-2xl font-extrabold text-blue-900 tracking-tight">
                    Vendo<span class="text-amber-500">Smart</span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#keunggulan" class="text-gray-600 hover:text-blue-900 text-sm font-medium transition-colors">Keunggulan</a>
                    <a href="{{ route('catalog.index') }}" class="text-gray-600 hover:text-blue-900 text-sm font-medium transition-colors">Katalog</a>
                    <a href="#kontak"     class="text-gray-600 hover:text-blue-900 text-sm font-medium transition-colors">Kontak</a>
                    <a href="#konsultasi" class="bg-blue-900 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-blue-800 transition-colors shadow-sm">
                        Konsultasi Gratis
                    </a>
                </div>

                <button type="button" class="md:hidden text-gray-600 hover:text-blue-900" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-4 py-3 space-y-1">
            <a href="#keunggulan" class="block py-2 text-sm text-gray-600 hover:text-blue-900 font-medium">Keunggulan</a>
            <a href="{{ route('catalog.index') }}" class="block py-2 text-sm text-gray-600 hover:text-blue-900 font-medium">Katalog</a>
            <a href="#kontak"     class="block py-2 text-sm text-gray-600 hover:text-blue-900 font-medium">Kontak</a>
            <a href="#konsultasi" class="block mt-2 bg-blue-900 text-white text-sm font-semibold px-5 py-2.5 rounded-lg text-center hover:bg-blue-800 transition-colors">
                Konsultasi Gratis
            </a>
        </div>
    </nav>


    {{-- ===================== HERO ===================== --}}
    <section class="pt-16 bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                {{-- Left: Copy --}}
                <div>
                    <span class="inline-flex items-center bg-blue-800/60 border border-blue-600/40 text-blue-200 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide mb-6">
                        <span class="w-1.5 h-1.5 bg-amber-400 rounded-full mr-2"></span>
                        Terpercaya sejak 2015 · 50+ Kota di Indonesia
                    </span>

                    <h1 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold leading-tight mb-6">
                        Solusi Vending Machine
                        <span class="text-amber-400"> Terbaik</span>
                        <br>untuk Bisnis Anda
                    </h1>

                    <p class="text-blue-200 text-lg lg:text-xl mb-10 leading-relaxed max-w-xl">
                        Kami menyediakan vending machine berkualitas tinggi — snack, minuman, kopi, hingga ATM beras.
                        Pilihan <strong class="text-white">beli</strong> atau <strong class="text-white">sewa</strong> sesuai kebutuhan bisnis Anda.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 mb-12">
                        <a href="#produk"
                           class="bg-amber-500 hover:bg-amber-400 text-white font-bold px-8 py-4 rounded-xl transition-all text-center text-base shadow-lg hover:shadow-amber-500/40 hover:-translate-y-0.5">
                            Beli Sekarang
                        </a>
                        <a href="#konsultasi"
                           class="border-2 border-white/40 hover:border-white hover:bg-white/10 text-white font-semibold px-8 py-4 rounded-xl transition-all text-center text-base">
                            Sewa Unit
                        </a>
                    </div>

                    <div class="flex flex-wrap gap-5">
                        @foreach ([['Garansi 2 Tahun'], ['Pengiriman ke Seluruh Indonesia'], ['Support 24/7']] as $badge)
                        <div class="flex items-center gap-2 text-blue-200 text-sm">
                            <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $badge[0] }}
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Right: Illustration --}}
                <div class="relative flex justify-center lg:justify-end">
                    <div class="relative w-72 lg:w-80">
                        {{-- Machine body --}}
                        <div class="w-full h-[400px] bg-gradient-to-b from-blue-700 to-blue-950 rounded-3xl border-2 border-white/20 shadow-2xl relative overflow-hidden">
                            {{-- Screen --}}
                            <div class="absolute top-6 left-6 right-6 h-36 bg-black/30 rounded-xl border border-white/15 flex items-center justify-center overflow-hidden">
                                <div class="grid grid-cols-3 gap-2 p-3 w-full">
                                    <div class="h-9 bg-amber-400/90 rounded-lg flex items-center justify-center text-xs font-bold text-amber-900">SNK</div>
                                    <div class="h-9 bg-emerald-400/90 rounded-lg flex items-center justify-center text-xs font-bold text-emerald-900">DRK</div>
                                    <div class="h-9 bg-rose-400/90 rounded-lg flex items-center justify-center text-xs font-bold text-rose-900">KPI</div>
                                    <div class="h-9 bg-violet-400/90 rounded-lg flex items-center justify-center text-xs font-bold text-violet-900">JUS</div>
                                    <div class="h-9 bg-sky-400/90 rounded-lg flex items-center justify-center text-xs font-bold text-sky-900">AIR</div>
                                    <div class="h-9 bg-orange-400/90 rounded-lg flex items-center justify-center text-xs font-bold text-orange-900">TEH</div>
                                </div>
                            </div>
                            {{-- Price display --}}
                            <div class="absolute top-[176px] left-6 right-6 bg-black/40 rounded-lg px-4 py-2 flex items-center justify-between">
                                <span class="text-blue-300 text-xs">Pilih produk</span>
                                <span class="text-amber-400 font-bold text-sm">Rp 8.000</span>
                            </div>
                            {{-- Keypad --}}
                            <div class="absolute top-[220px] left-6 right-6 grid grid-cols-3 gap-1.5">
                                @foreach(range(1, 9) as $n)
                                <div class="h-7 bg-white/10 rounded border border-white/15 flex items-center justify-center text-xs text-white/70">{{ $n }}</div>
                                @endforeach
                            </div>
                            {{-- Payment slot --}}
                            <div class="absolute bottom-14 left-6 right-6 h-10 bg-black/40 rounded-lg border border-white/10 flex items-center px-3 gap-2">
                                <div class="w-6 h-6 bg-amber-500/80 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM2 9v6a2 2 0 002 2h12a2 2 0 002-2V9H2z"/></svg>
                                </div>
                                <span class="text-white/60 text-xs">QRIS / Cash / Debit</span>
                            </div>
                            {{-- Output slot --}}
                            <div class="absolute bottom-4 left-10 right-10 h-7 bg-black/60 rounded border border-white/10"></div>
                        </div>

                        {{-- Floating badge: rating --}}
                        <div class="absolute -top-3 -right-4 bg-white text-blue-900 px-3 py-2 rounded-2xl shadow-xl text-xs font-bold border border-gray-100">
                            ⭐ 4.9 / 5.0
                        </div>

                        {{-- Floating badge: units --}}
                        <div class="absolute -bottom-3 -left-4 bg-amber-500 text-white px-4 py-2 rounded-2xl shadow-xl text-xs font-bold">
                            🏆 1.000+ Mesin Aktif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Wave divider --}}
        <div class="relative h-16 overflow-hidden">
            <svg viewBox="0 0 1440 64" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute bottom-0 w-full" preserveAspectRatio="none">
                <path d="M0 64L1440 64L1440 20C1200 60 960 0 720 20C480 40 240 -10 0 20V64Z" fill="white"/>
            </svg>
        </div>
    </section>


    {{-- ===================== STATS ===================== --}}
    <section class="bg-white py-14 border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                @foreach ([
                    ['1.000+', 'Mesin Terpasang'],
                    ['50+',    'Kota di Indonesia'],
                    ['500+',   'Klien Aktif'],
                    ['9 Th',   'Pengalaman'],
                ] as [$number, $label])
                <div>
                    <div class="text-4xl font-extrabold text-blue-900 mb-1">{{ $number }}</div>
                    <div class="text-gray-500 text-sm font-medium">{{ $label }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ===================== KEUNGGULAN ===================== --}}
    <section id="keunggulan" class="bg-gray-50 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-amber-500 font-semibold text-sm tracking-wider uppercase">Mengapa VendoSmart</span>
                <h2 class="mt-2 text-3xl lg:text-4xl font-extrabold text-gray-900">Keunggulan yang Membedakan Kami</h2>
                <p class="mt-4 text-gray-500 text-lg max-w-2xl mx-auto">
                    Dari kualitas mesin hingga layanan purna jual, kami berkomitmen memberikan yang terbaik untuk bisnis Anda.
                </p>
            </div>

            @php
                $keunggulan = [
                    [
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                        'bg'    => 'bg-blue-100',
                        'hover' => 'group-hover:bg-blue-800',
                        'text'  => 'text-blue-700',
                        'title' => 'Kualitas Premium',
                        'desc'  => 'Mesin kami diproduksi dengan bahan berkualitas tinggi, telah lulus uji standar internasional untuk keandalan dan ketahanan jangka panjang.',
                    ],
                    [
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'bg'    => 'bg-amber-100',
                        'hover' => 'group-hover:bg-amber-500',
                        'text'  => 'text-amber-600',
                        'title' => 'Garansi 2 Tahun',
                        'desc'  => 'Setiap unit dilindungi garansi resmi 2 tahun. Perbaikan dan penggantian komponen tanpa biaya tambahan selama masa garansi berlaku.',
                    ],
                    [
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
                        'bg'    => 'bg-green-100',
                        'hover' => 'group-hover:bg-green-600',
                        'text'  => 'text-green-600',
                        'title' => 'Instalasi Profesional',
                        'desc'  => 'Tim teknisi bersertifikat kami menangani pemasangan di lokasi Anda — memastikan mesin beroperasi optimal sejak hari pertama.',
                    ],
                    [
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>',
                        'bg'    => 'bg-purple-100',
                        'hover' => 'group-hover:bg-purple-600',
                        'text'  => 'text-purple-600',
                        'title' => 'Teknologi IoT',
                        'desc'  => 'Pantau stok, penjualan, dan kondisi mesin secara real-time melalui dashboard digital. Notifikasi otomatis saat stok menipis atau ada gangguan.',
                    ],
                    [
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'bg'    => 'bg-red-100',
                        'hover' => 'group-hover:bg-red-600',
                        'text'  => 'text-red-600',
                        'title' => 'Pilihan Beli & Sewa',
                        'desc'  => 'Fleksibel sesuai kondisi finansial Anda. Beli langsung, cicilan 0%, atau sewa bulanan tanpa modal besar di awal — semua tersedia.',
                    ],
                    [
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>',
                        'bg'    => 'bg-teal-100',
                        'hover' => 'group-hover:bg-teal-600',
                        'text'  => 'text-teal-600',
                        'title' => 'Support 24/7',
                        'desc'  => 'Tim support siap membantu kapan saja melalui WhatsApp, telepon, atau kunjungan langsung. Respons cepat agar bisnis Anda tidak terganggu.',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($keunggulan as $item)
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition-all group border border-gray-100 hover:border-blue-100">
                    <div class="w-14 h-14 {{ $item['bg'] }} {{ $item['hover'] }} rounded-xl flex items-center justify-center mb-6 transition-colors duration-200">
                        <svg class="w-7 h-7 {{ $item['text'] }} group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $item['icon'] !!}
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ $item['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ===================== PRODUK (RINGKASAN — dari DB) ===================== --}}
    <section id="produk" class="bg-white py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-amber-500 font-semibold text-sm tracking-wider uppercase">Katalog Produk</span>
                <h2 class="mt-2 text-3xl lg:text-4xl font-extrabold text-gray-900">Vending Machine Pilihan</h2>
                <p class="mt-4 text-gray-500 text-lg max-w-2xl mx-auto">
                    Tersedia berbagai jenis vending machine untuk memenuhi kebutuhan lokasi dan bisnis Anda.
                </p>
            </div>

            @if ($featuredProducts->isNotEmpty())
            @php
                $colorMap = [
                    'snack_minuman' => ['bg' => 'from-blue-50 to-blue-100',    'machine' => 'from-blue-600 to-blue-900 border-blue-400',    'badge' => 'bg-blue-100 text-blue-800'],
                    'kopi_panas'    => ['bg' => 'from-amber-50 to-amber-100',  'machine' => 'from-amber-600 to-amber-900 border-amber-400',  'badge' => 'bg-amber-100 text-amber-800'],
                    'atm_beras'     => ['bg' => 'from-green-50 to-green-100',  'machine' => 'from-green-600 to-green-900 border-green-400',  'badge' => 'bg-green-100 text-green-800'],
                    'custom'        => ['bg' => 'from-purple-50 to-purple-100','machine' => 'from-purple-600 to-purple-900 border-purple-400','badge' => 'bg-purple-100 text-purple-800'],
                ];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($featuredProducts as $product)
                @php $c = $colorMap[$product->category] ?? $colorMap['custom']; @endphp
                <div class="bg-white border border-amber-200 ring-1 ring-amber-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all relative group">

                    <div class="bg-gradient-to-br {{ $c['bg'] }} h-52 flex items-center justify-center relative">
                        <span class="absolute top-3 right-3 bg-amber-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow">
                            Unggulan
                        </span>
                        <div class="w-28 h-40 bg-gradient-to-b {{ $c['machine'] }} rounded-2xl border-2 relative shadow-lg group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-3 left-3 right-3 h-16 bg-white/10 rounded-lg border border-white/20"></div>
                            <div class="absolute bottom-6 left-3 right-3 h-5 bg-white/20 rounded"></div>
                            <div class="absolute bottom-2 left-3 right-3 h-3 bg-white/10 rounded"></div>
                        </div>
                    </div>

                    <div class="p-6">
                        <span class="inline-block {{ $c['badge'] }} text-xs font-semibold px-3 py-1 rounded-full mb-3">
                            {{ $product->category_label }}
                        </span>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-500 text-sm mb-5 leading-relaxed line-clamp-3">{{ $product->description }}</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-blue-900 font-extrabold text-xl">{{ $product->formatted_price }}</span>
                                <span class="text-gray-400 text-xs ml-1">/ unit</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('catalog.show', $product->slug) }}"
                                   class="border border-blue-900 text-blue-900 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-blue-50 transition-colors">
                                    Detail
                                </a>
                                <a href="#konsultasi"
                                   class="bg-blue-900 hover:bg-blue-800 text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors">
                                    Tanya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            {{-- Fallback jika DB belum di-seed --}}
            <p class="text-center text-gray-400 py-12">Jalankan <code class="bg-gray-100 px-2 py-1 rounded text-sm">php artisan migrate --seed</code> untuk menampilkan produk.</p>
            @endif

            <div class="text-center mt-10">
                <a href="{{ route('catalog.index') }}" class="inline-flex items-center text-blue-900 font-semibold hover:text-blue-700 transition-colors text-sm">
                    Lihat Semua Produk di Katalog
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>


    {{-- ===================== CTA / KONSULTASI ===================== --}}
    <section id="konsultasi" class="bg-gradient-to-r from-blue-950 to-blue-900 py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <svg viewBox="0 0 800 400" fill="white" class="w-full h-full" preserveAspectRatio="xMidYMid slice">
                <circle cx="700" cy="50"  r="200"/>
                <circle cx="100" cy="350" r="150"/>
            </svg>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-amber-400 font-semibold text-sm tracking-wider uppercase">Mulai Sekarang</span>
            <h2 class="mt-2 text-3xl lg:text-4xl font-extrabold text-white mb-4">
                Konsultasi Gratis dengan Tim Ahli Kami
            </h2>
            <p class="text-blue-200 text-lg mb-10 max-w-xl mx-auto">
                Ceritakan kebutuhan bisnis Anda. Tim kami akan merekomendasikan solusi vending machine yang paling tepat — tanpa biaya konsultasi.
            </p>

            <div class="bg-white rounded-2xl p-8 text-left shadow-2xl max-w-2xl mx-auto">

                {{-- Success state --}}
                @if (session('lead_success'))
                <div class="flex items-start gap-3 bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-green-800 font-semibold text-sm">Pesan terkirim!</p>
                        <p class="text-green-700 text-xs mt-0.5">Tim kami akan menghubungi Anda dalam 1×24 jam melalui WhatsApp.</p>
                    </div>
                </div>
                @endif

                <form action="{{ route('konsultasi.store') }}" method="POST">
                    @csrf

                    {{-- Honeypot: disembunyikan dari manusia, diisi bot --}}
                    <div class="hidden" aria-hidden="true">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama Anda"
                                   class="w-full border {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1.5">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08xxxxxxxxxx"
                                   class="w-full border {{ $errors->has('whatsapp') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('whatsapp')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@anda.com (opsional)"
                               class="w-full border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1.5">Kebutuhan Anda <span class="text-red-500">*</span></label>
                        <select name="need" class="w-full border {{ $errors->has('need') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                            <option value="">Pilih jenis kebutuhan</option>
                            <option value="beli"    {{ old('need') === 'beli'    ? 'selected' : '' }}>Beli Unit Baru</option>
                            <option value="sewa"    {{ old('need') === 'sewa'    ? 'selected' : '' }}>Sewa Unit</option>
                            <option value="info"    {{ old('need') === 'info'    ? 'selected' : '' }}>Informasi Produk</option>
                            <option value="service" {{ old('need') === 'service' ? 'selected' : '' }}>Servis / Perawatan</option>
                        </select>
                        @error('need')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-1.5">Pesan / Pertanyaan</label>
                        <textarea name="message" rows="3" placeholder="Ceritakan lokasi, jumlah unit, dan kebutuhan bisnis Anda..."
                                  class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-3.5 rounded-xl transition-colors text-base shadow-sm">
                        Kirim & Konsultasi Gratis
                    </button>
                    <p class="text-center text-gray-400 text-xs mt-3">
                        Dengan mengirim form ini, Anda setuju untuk dihubungi oleh tim VendoSmart.
                    </p>
                </form>
            </div>
        </div>
    </section>


    {{-- ===================== FOOTER ===================== --}}
    <footer id="kontak" class="bg-gray-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

                {{-- Brand --}}
                <div class="lg:col-span-2">
                    <div class="text-2xl font-extrabold mb-4 tracking-tight">Vendo<span class="text-amber-400">Smart</span></div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm mb-6">
                        Solusi vending machine terpercaya untuk bisnis Anda. Lebih dari 500 klien aktif di seluruh Indonesia telah mempercayakan kebutuhan vending machine mereka kepada kami.
                    </p>
                    <a href="https://wa.me/6281234567890?text=Halo%20VendoSmart%2C%20saya%20ingin%20konsultasi%20tentang%20vending%20machine"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white px-5 py-3 rounded-xl transition-colors font-semibold text-sm shadow">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Chat WhatsApp
                    </a>
                </div>

                {{-- Produk --}}
                <div>
                    <h4 class="font-semibold text-white mb-4 text-sm tracking-wide uppercase">Produk</h4>
                    <ul class="space-y-2.5 text-gray-400 text-sm">
                        @foreach (['VM Snack & Minuman', 'VM Kopi & Minuman Panas', 'ATM Beras', 'VM Custom', 'Spare Part'] as $item)
                        <li><a href="#produk" class="hover:text-white transition-colors">{{ $item }}</a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Kontak --}}
                <div>
                    <h4 class="font-semibold text-white mb-4 text-sm tracking-wide uppercase">Kontak</h4>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Jl. Raya Industri No. 123,<br>Jakarta Barat 11520</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 8V5z"/>
                            </svg>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>info@vendosmart.co.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-gray-600 text-sm">© {{ date('Y') }} VendoSmart. Semua hak dilindungi undang-undang.</p>
                <div class="flex gap-6 text-gray-600 text-sm">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- WhatsApp Floating Button --}}
    <a id="wa-float"
       href="https://wa.me/6281234567890?text=Halo%20VendoSmart%2C%20saya%20ingin%20konsultasi%20tentang%20vending%20machine"
       target="_blank" rel="noopener"
       class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 bg-green-500 hover:bg-green-400 text-white font-semibold px-4 py-3 rounded-full shadow-xl transition-all duration-300 opacity-0 pointer-events-none"
       aria-label="Chat WhatsApp">
        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
        <span class="text-sm">WhatsApp</span>
    </a>

    <script>
        // Close mobile menu on link click
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });

        // WhatsApp floating button — muncul setelah scroll 300px
        (function () {
            const btn = document.getElementById('wa-float');
            function toggleWaBtn() {
                if (window.scrollY > 300) {
                    btn.classList.remove('opacity-0', 'pointer-events-none');
                    btn.classList.add('opacity-100');
                } else {
                    btn.classList.add('opacity-0', 'pointer-events-none');
                    btn.classList.remove('opacity-100');
                }
            }
            window.addEventListener('scroll', toggleWaBtn, { passive: true });
        })();
    </script>
</body>
</html>

@extends('layouts.app')

@section('title', 'Katalog Produk')

@push('head')
<style>
    .filter-btn.active { background-color: #1e3a8a; color: #fff; }
    .filter-btn { transition: all .15s; }
</style>
@endpush

@section('content')

{{-- Page header --}}
<section class="bg-gradient-to-br from-blue-950 to-blue-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-blue-300 text-sm font-medium mb-1">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                    <span class="mx-2">›</span> Katalog
                </p>
                <h1 class="text-3xl lg:text-4xl font-extrabold">Katalog Vending Machine</h1>
                <p class="text-blue-200 mt-2 text-sm">{{ $products->count() }} produk tersedia</p>
            </div>
            <a href="{{ url('/#konsultasi') }}"
               class="self-start sm:self-center bg-amber-500 hover:bg-amber-400 text-white font-bold px-6 py-3 rounded-xl transition-colors text-sm shadow-lg">
                Konsultasi Gratis
            </a>
        </div>
    </div>
</section>

{{-- Filter & Compare Bar --}}
<section class="bg-white border-b border-gray-100 sticky top-16 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        {{-- Category filters --}}
        <div class="flex flex-wrap gap-2" id="filter-bar">
            <button onclick="filterProducts('all')"
                    data-filter="all"
                    class="filter-btn active text-sm font-medium px-4 py-1.5 rounded-full border border-blue-900 text-blue-900 hover:bg-blue-900 hover:text-white">
                Semua
            </button>
            @foreach ($categories as $cat)
            <button onclick="filterProducts('{{ $cat['value'] }}')"
                    data-filter="{{ $cat['value'] }}"
                    class="filter-btn text-sm font-medium px-4 py-1.5 rounded-full border border-gray-300 text-gray-600 hover:border-blue-900 hover:text-blue-900">
                {{ $cat['label'] }}
            </button>
            @endforeach
        </div>

        {{-- Compare trigger --}}
        <div id="compare-trigger" class="hidden">
            <button onclick="openCompare()"
                    class="flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Bandingkan (<span id="compare-count">0</span>)
            </button>
        </div>
    </div>
</section>

{{-- Product Grid --}}
<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if ($products->isEmpty())
        <div class="text-center py-24">
            <p class="text-gray-400 text-lg">Belum ada produk di kategori ini.</p>
            <button onclick="filterProducts('all')" class="mt-4 text-blue-900 font-semibold hover:underline text-sm">
                Lihat semua produk →
            </button>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="product-grid">
            @foreach ($products as $product)
            @php
                $colors = [
                    'snack_minuman' => ['bg' => 'from-blue-50 to-blue-100',   'machine' => 'from-blue-600 to-blue-900 border-blue-400',     'badge' => 'bg-blue-100 text-blue-800'],
                    'kopi_panas'    => ['bg' => 'from-amber-50 to-amber-100', 'machine' => 'from-amber-600 to-amber-900 border-amber-400',   'badge' => 'bg-amber-100 text-amber-800'],
                    'atm_beras'     => ['bg' => 'from-green-50 to-green-100', 'machine' => 'from-green-600 to-green-900 border-green-400',   'badge' => 'bg-green-100 text-green-800'],
                    'custom'        => ['bg' => 'from-purple-50 to-purple-100','machine'=> 'from-purple-600 to-purple-900 border-purple-400','badge' => 'bg-purple-100 text-purple-800'],
                ];
                $c = $colors[$product->category] ?? $colors['custom'];
            @endphp
            <div class="product-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all border {{ $product->is_featured ? 'border-amber-200' : 'border-gray-100' }} group flex flex-col"
                 data-category="{{ $product->category }}"
                 data-id="{{ $product->id }}">

                @if ($product->is_featured)
                <div class="absolute" style="position:relative">
                    <span class="absolute top-3 right-3 bg-amber-500 text-white text-xs font-bold px-2.5 py-1 rounded-full z-10 shadow">
                        Unggulan
                    </span>
                </div>
                @endif

                {{-- Visual --}}
                <div class="bg-gradient-to-br {{ $c['bg'] }} h-44 flex items-center justify-center relative">
                    @if ($product->is_featured)
                    <span class="absolute top-3 right-3 bg-amber-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow">
                        Unggulan
                    </span>
                    @endif

                    @if ($product->status !== 'available')
                    <span class="absolute top-3 left-3 bg-gray-700 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow">
                        {{ $product->status_label }}
                    </span>
                    @endif

                    <div class="w-24 h-36 bg-gradient-to-b {{ $c['machine'] }} rounded-xl border-2 relative shadow-lg group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-2 left-2 right-2 h-14 bg-white/10 rounded-lg border border-white/20"></div>
                        <div class="absolute bottom-5 left-2 right-2 h-4 bg-white/20 rounded"></div>
                        <div class="absolute bottom-1 left-2 right-2 h-3 bg-white/10 rounded"></div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-5 flex flex-col flex-1">
                    <span class="inline-block {{ $c['badge'] }} text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2">
                        {{ $product->category_label }}
                    </span>
                    <h3 class="font-bold text-gray-900 mb-1 leading-snug">{{ $product->name }}</h3>
                    <p class="text-gray-500 text-xs leading-relaxed mb-4 flex-1 line-clamp-3">
                        {{ $product->description }}
                    </p>

                    {{-- Specs preview --}}
                    @php $previewSpecs = array_slice($product->specs, 0, 2, true); @endphp
                    <ul class="space-y-1 mb-4">
                        @foreach ($previewSpecs as $key => $val)
                        <li class="flex items-start gap-1.5 text-xs text-gray-500">
                            <svg class="w-3 h-3 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span><strong>{{ $key }}:</strong> {{ $val }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <span class="text-blue-900 font-extrabold text-lg">{{ $product->formatted_price }}</span>
                            <span class="text-gray-400 text-xs ml-1">/ unit</span>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-auto">
                        <a href="{{ route('catalog.show', $product->slug) }}"
                           class="flex-1 border border-blue-900 text-blue-900 hover:bg-blue-900 hover:text-white text-xs font-semibold py-2 rounded-lg text-center transition-colors">
                            Detail
                        </a>
                        <a href="{{ url('/#konsultasi') }}"
                           class="flex-1 bg-blue-900 hover:bg-blue-800 text-white text-xs font-semibold py-2 rounded-lg text-center transition-colors">
                            Tanya Harga
                        </a>
                        <button onclick="toggleCompare({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                id="compare-btn-{{ $product->id }}"
                                title="Tambah ke perbandingan"
                                class="w-9 h-9 flex items-center justify-center border border-gray-200 rounded-lg hover:border-blue-900 hover:text-blue-900 text-gray-400 transition-colors flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- Comparison Modal --}}
<div id="compare-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-auto">
        <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
            <h2 class="text-xl font-bold text-gray-900">Perbandingan Spesifikasi</h2>
            <button onclick="closeCompare()" class="text-gray-400 hover:text-gray-700 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="w-full text-sm" id="compare-table">
                <thead></thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="p-6 border-t bg-gray-50 rounded-b-2xl flex justify-between items-center">
            <button onclick="closeCompare()" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                ← Kembali ke katalog
            </button>
            <a href="{{ url('/#konsultasi') }}"
               class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">
                Konsultasi Sekarang
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const allProducts = @json($products->keyBy('id'));

    // ── Filter ───────────────────────────────────────────────────────────────
    function filterProducts(category) {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.filter === category);
        });

        document.querySelectorAll('.product-card').forEach(card => {
            const show = category === 'all' || card.dataset.category === category;
            card.style.display = show ? '' : 'none';
        });
    }

    // Init filter from URL
    const urlCategory = new URLSearchParams(window.location.search).get('category');
    if (urlCategory) filterProducts(urlCategory);

    // ── Compare ──────────────────────────────────────────────────────────────
    let compareList = [];

    function toggleCompare(id, name) {
        const idx = compareList.findIndex(p => p.id === id);
        const btn = document.getElementById('compare-btn-' + id);

        if (idx > -1) {
            compareList.splice(idx, 1);
            btn.classList.remove('border-blue-900', 'text-blue-900', 'bg-blue-50');
        } else {
            if (compareList.length >= 3) {
                alert('Maksimal 3 produk bisa dibandingkan sekaligus.');
                return;
            }
            compareList.push({ id, name });
            btn.classList.add('border-blue-900', 'text-blue-900', 'bg-blue-50');
        }

        updateCompareTrigger();
    }

    function updateCompareTrigger() {
        const trigger = document.getElementById('compare-trigger');
        const count   = document.getElementById('compare-count');
        const show    = compareList.length >= 2;
        trigger.classList.toggle('hidden', !show);
        count.textContent = compareList.length;
    }

    function openCompare() {
        buildCompareTable();
        const modal = document.getElementById('compare-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeCompare() {
        const modal = document.getElementById('compare-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function buildCompareTable() {
        const products = compareList.map(p => allProducts[p.id]);
        const allSpecKeys = [...new Set(products.flatMap(p => Object.keys(p.specs)))];

        const colors = {
            snack_minuman: '#dbeafe',
            kopi_panas:    '#fef3c7',
            atm_beras:     '#d1fae5',
            custom:        '#ede9fe',
        };

        // Header
        let thead = '<tr><th class="text-left py-3 px-4 text-gray-500 font-medium w-40">Spesifikasi</th>';
        products.forEach(p => {
            thead += `<th class="py-3 px-4 text-center">
                <div class="font-bold text-gray-900">${p.name}</div>
                <div class="text-xs text-gray-500 mt-1">${p.category_label}</div>
                <div class="text-blue-900 font-extrabold text-base mt-1">${p.formatted_price}</div>
            </th>`;
        });
        thead += '</tr>';

        // Body — product name row
        let tbody = '';

        // Specs rows
        allSpecKeys.forEach((key, i) => {
            const bg = i % 2 === 0 ? 'bg-gray-50' : 'bg-white';
            tbody += `<tr class="${bg}">
                <td class="py-2.5 px-4 text-gray-600 font-medium text-xs">${key}</td>`;
            products.forEach(p => {
                const val = p.specs[key] || '—';
                tbody += `<td class="py-2.5 px-4 text-center text-xs text-gray-800">${val}</td>`;
            });
            tbody += '</tr>';
        });

        // CTA row
        tbody += '<tr class="bg-white border-t-2"><td class="py-4 px-4"></td>';
        products.forEach(p => {
            tbody += `<td class="py-4 px-4 text-center">
                <a href="/katalog/${p.slug}" class="inline-block border border-blue-900 text-blue-900 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-blue-900 hover:text-white transition-colors">
                    Lihat Detail
                </a>
            </td>`;
        });
        tbody += '</tr>';

        document.querySelector('#compare-table thead').innerHTML = thead;
        document.querySelector('#compare-table tbody').innerHTML  = tbody;
    }

    // Close modal on backdrop click
    document.getElementById('compare-modal').addEventListener('click', function (e) {
        if (e.target === this) closeCompare();
    });
</script>
@endpush

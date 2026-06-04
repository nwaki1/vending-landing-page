@extends('layouts.app')

@section('title', $product->name)

@section('content')

{{-- Breadcrumb + back --}}
<section class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <p class="text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-900 transition-colors">Beranda</a>
            <span class="mx-2">›</span>
            <a href="{{ route('catalog.index') }}" class="hover:text-blue-900 transition-colors">Katalog</a>
            <span class="mx-2">›</span>
            <span class="text-gray-800 font-medium">{{ $product->name }}</span>
        </p>
    </div>
</section>

{{-- Product detail --}}
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            {{-- Left: visual + status --}}
            <div>
                @php
                    $colors = [
                        'snack_minuman' => 'from-blue-50 to-blue-100',
                        'kopi_panas'    => 'from-amber-50 to-amber-100',
                        'atm_beras'     => 'from-green-50 to-green-100',
                        'custom'        => 'from-purple-50 to-purple-100',
                    ];
                    $machineColors = [
                        'snack_minuman' => 'from-blue-600 to-blue-900 border-blue-400',
                        'kopi_panas'    => 'from-amber-600 to-amber-900 border-amber-400',
                        'atm_beras'     => 'from-green-600 to-green-900 border-green-400',
                        'custom'        => 'from-purple-600 to-purple-900 border-purple-400',
                    ];
                    $bg  = $colors[$product->category]       ?? 'from-gray-50 to-gray-100';
                    $mc  = $machineColors[$product->category] ?? 'from-gray-500 to-gray-800 border-gray-400';
                @endphp

                <div class="bg-gradient-to-br {{ $bg }} rounded-2xl h-72 flex items-center justify-center mb-6 relative">
                    @if ($product->is_featured)
                    <span class="absolute top-4 right-4 bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                        Produk Unggulan
                    </span>
                    @endif

                    <div class="w-40 h-60 bg-gradient-to-b {{ $mc }} rounded-3xl border-2 relative shadow-2xl">
                        <div class="absolute top-4 left-4 right-4 h-24 bg-white/10 rounded-xl border border-white/20 flex items-center justify-center">
                            <div class="grid grid-cols-3 gap-1.5 p-2">
                                @foreach(['bg-amber-400','bg-green-400','bg-red-400','bg-purple-400','bg-sky-400','bg-orange-400'] as $cl)
                                <div class="w-7 h-9 {{ $cl }} rounded-lg opacity-80"></div>
                                @endforeach
                            </div>
                        </div>
                        <div class="absolute bottom-10 left-4 right-4 h-7 bg-white/20 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xs font-medium opacity-80">{{ $product->formatted_price }}</span>
                        </div>
                        <div class="absolute bottom-3 left-4 right-4 h-5 bg-white/10 rounded-lg"></div>
                    </div>
                </div>

                {{-- Status badge --}}
                @php
                    $statusColors = [
                        'available'   => 'bg-green-100 text-green-800',
                        'indent'      => 'bg-amber-100 text-amber-800',
                        'unavailable' => 'bg-red-100 text-red-800',
                    ];
                @endphp
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center {{ $statusColors[$product->status] }} px-3 py-1 rounded-full text-sm font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $product->status === 'available' ? 'bg-green-500' : ($product->status === 'indent' ? 'bg-amber-500' : 'bg-red-500') }}"></span>
                        {{ $product->status_label }}
                    </span>
                    <span class="text-gray-400 text-sm">· Garansi 2 Tahun</span>
                </div>
            </div>

            {{-- Right: info --}}
            <div>
                @php
                    $badgeColors = [
                        'snack_minuman' => 'bg-blue-100 text-blue-800',
                        'kopi_panas'    => 'bg-amber-100 text-amber-800',
                        'atm_beras'     => 'bg-green-100 text-green-800',
                        'custom'        => 'bg-purple-100 text-purple-800',
                    ];
                    $badge = $badgeColors[$product->category] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="inline-block {{ $badge }} text-xs font-semibold px-3 py-1 rounded-full mb-3">
                    {{ $product->category_label }}
                </span>

                <h1 class="text-3xl font-extrabold text-gray-900 mb-3">{{ $product->name }}</h1>

                <div class="flex items-baseline gap-2 mb-6">
                    <span class="text-4xl font-extrabold text-blue-900">{{ $product->formatted_price }}</span>
                    <span class="text-gray-400 text-sm">/ unit</span>
                </div>

                <p class="text-gray-600 leading-relaxed mb-8">{{ $product->description }}</p>

                {{-- CTA buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 mb-10">
                    <a href="{{ url('/#konsultasi') }}"
                       class="flex-1 bg-blue-900 hover:bg-blue-800 text-white font-bold py-3.5 rounded-xl text-center transition-colors shadow-sm">
                        Tanya Harga & Konsultasi
                    </a>
                    <a href="https://wa.me/6281234567890?text=Halo%20VendoSmart%2C%20saya%20tertarik%20dengan%20{{ urlencode($product->name) }}"
                       target="_blank" rel="noopener"
                       class="flex-1 border-2 border-green-600 text-green-700 hover:bg-green-600 hover:text-white font-bold py-3.5 rounded-xl text-center transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Chat WhatsApp
                    </a>
                </div>

                {{-- Specs table --}}
                <div class="border border-gray-200 rounded-2xl overflow-hidden">
                    <div class="bg-gray-50 px-5 py-3 border-b border-gray-200">
                        <h2 class="font-bold text-gray-900 text-sm">Spesifikasi Lengkap</h2>
                    </div>
                    <table class="w-full text-sm">
                        <tbody>
                            @foreach ($product->specs as $key => $value)
                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="py-3 px-5 text-gray-500 font-medium w-44">{{ $key }}</td>
                                <td class="py-3 px-5 text-gray-800 font-semibold">{{ $value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related products --}}
@if ($related->isNotEmpty())
<section class="bg-gray-50 py-16 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-8">Produk Sejenis</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($related as $rel)
            @php
                $rColors = [
                    'snack_minuman' => ['bg' => 'from-blue-50 to-blue-100',   'machine' => 'from-blue-600 to-blue-900 border-blue-400',     'badge' => 'bg-blue-100 text-blue-800'],
                    'kopi_panas'    => ['bg' => 'from-amber-50 to-amber-100', 'machine' => 'from-amber-600 to-amber-900 border-amber-400',   'badge' => 'bg-amber-100 text-amber-800'],
                    'atm_beras'     => ['bg' => 'from-green-50 to-green-100', 'machine' => 'from-green-600 to-green-900 border-green-400',   'badge' => 'bg-green-100 text-green-800'],
                    'custom'        => ['bg' => 'from-purple-50 to-purple-100','machine'=> 'from-purple-600 to-purple-900 border-purple-400','badge' => 'bg-purple-100 text-purple-800'],
                ];
                $rc = $rColors[$rel->category] ?? $rColors['custom'];
            @endphp
            <a href="{{ route('catalog.show', $rel->slug) }}"
               class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-gray-100 group flex gap-4 p-4 items-center">
                <div class="bg-gradient-to-br {{ $rc['bg'] }} rounded-xl w-20 h-24 flex items-center justify-center flex-shrink-0">
                    <div class="w-10 h-16 bg-gradient-to-b {{ $rc['machine'] }} rounded-lg border-2 shadow group-hover:scale-105 transition-transform"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="text-xs {{ $rc['badge'] }} px-2 py-0.5 rounded-full font-semibold">{{ $rel->category_label }}</span>
                    <h3 class="font-bold text-gray-900 mt-1 text-sm leading-snug truncate">{{ $rel->name }}</h3>
                    <p class="text-blue-900 font-extrabold text-base mt-1">{{ $rel->formatted_price }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('catalog.index') }}"
               class="inline-flex items-center text-blue-900 font-semibold hover:text-blue-700 transition-colors text-sm">
                ← Kembali ke semua katalog
            </a>
        </div>
    </div>
</section>
@endif

@endsection

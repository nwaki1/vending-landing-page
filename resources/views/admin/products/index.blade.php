@extends('admin.layouts.app')

@section('title', 'Kelola Produk')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">{{ $products->total() }} produk terdaftar</p>
    <a href="{{ route('admin.products.create') }}"
       class="bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Produk
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Produk</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Harga</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide text-center">Unggulan</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($products as $product)
                @php
                    $statusColor = match($product->status) {
                        'available'   => 'bg-green-100 text-green-700',
                        'indent'      => 'bg-amber-100 text-amber-700',
                        'unavailable' => 'bg-red-100 text-red-700',
                        default       => 'bg-gray-100 text-gray-700',
                    };
                @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                        <p class="text-gray-400 text-xs">{{ $product->slug }}</p>
                    </td>
                    <td class="px-5 py-3 text-gray-600">{{ $product->category_label }}</td>
                    <td class="px-5 py-3 font-semibold text-blue-900">{{ $product->formatted_price }}</td>
                    <td class="px-5 py-3">
                        <span class="inline-block {{ $statusColor }} text-xs font-semibold px-2.5 py-1 rounded-full">{{ $product->status_label }}</span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <form method="POST" action="{{ route('admin.products.toggle-featured', $product) }}" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" title="{{ $product->is_featured ? 'Nonaktifkan unggulan' : 'Jadikan unggulan' }}"
                                    class="{{ $product->is_featured ? 'text-amber-500 hover:text-amber-700' : 'text-gray-300 hover:text-amber-400' }} transition-colors">
                                <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="text-blue-900 hover:text-blue-700 text-xs font-semibold px-3 py-1.5 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-700 text-xs font-semibold px-3 py-1.5 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                        Belum ada produk.
                        <a href="{{ route('admin.products.create') }}" class="text-blue-900 font-medium hover:underline">Tambah sekarang →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($products->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection

@extends('admin.layouts.app')

@section('title', $product->exists ? 'Edit Produk' : 'Tambah Produk')

@section('content')

<div class="max-w-3xl">
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-gray-700 text-sm mb-5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">
            {{ $product->exists ? 'Edit: ' . $product->name : 'Tambah Produk Baru' }}
        </h2>

        <form method="POST"
              action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
              enctype="multipart/form-data"
              onsubmit="serializeSpecs()">
            @csrf
            @if ($product->exists) @method('PUT') @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                           oninput="autoSlug()"
                           class="w-full border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Slug <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" required
                           class="w-full border {{ $errors->has('slug') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" required
                            class="w-full border {{ $errors->has('category') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                        <option value="">Pilih kategori</option>
                        @foreach (['snack_minuman' => 'Snack & Minuman', 'kopi_panas' => 'Kopi & Minuman Panas', 'atm_beras' => 'ATM Beras', 'custom' => 'VM Custom'] as $val => $label)
                        <option value="{{ $val }}" {{ old('category', $product->category) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                           class="w-full border {{ $errors->has('price') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select name="status" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                        @foreach (['available' => 'Tersedia', 'indent' => 'Indent', 'unavailable' => 'Tidak Tersedia'] as $val => $label)
                        <option value="{{ $val }}" {{ old('status', $product->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" required
                              class="w-full border {{ $errors->has('description') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none">{{ old('description', $product->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Specs --}}
            <div class="mb-4">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-medium text-gray-700">Spesifikasi</label>
                    <button type="button" onclick="addSpecRow()"
                            class="text-blue-900 text-xs font-semibold hover:underline">+ Tambah baris</button>
                </div>
                <div id="specs-container" class="space-y-2 border border-gray-200 rounded-lg p-3 bg-gray-50">
                    @php $existingSpecs = old('specs_json') ? json_decode(old('specs_json'), true) : ($product->specs ?? []); @endphp
                    @forelse ($existingSpecs as $key => $value)
                    <div class="flex gap-2">
                        <input type="text" placeholder="Nama spesifikasi" value="{{ $key }}"
                               class="spec-key flex-1 border border-gray-200 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <input type="text" placeholder="Nilai" value="{{ $value }}"
                               class="spec-value flex-1 border border-gray-200 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <button type="button" onclick="this.closest('div').remove()"
                                class="text-red-400 hover:text-red-600 px-2 flex-shrink-0 text-lg leading-none">×</button>
                    </div>
                    @empty
                    <p class="text-gray-400 text-xs text-center py-2">Belum ada spesifikasi. Klik "+ Tambah baris".</p>
                    @endforelse
                </div>
                <input type="hidden" name="specs_json" id="specs-input" value="{{ old('specs_json', json_encode($product->specs ?? [])) }}">
            </div>

            {{-- Image --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto Produk</label>
                @if ($product->image)
                <div class="mb-2 flex items-center gap-3">
                    <img src="{{ Storage::url($product->image) }}" alt="" class="h-16 w-16 object-cover rounded-lg border border-gray-200">
                    <span class="text-gray-400 text-xs">Foto saat ini. Upload baru untuk mengganti.</span>
                </div>
                @endif
                <input type="file" name="image" accept="image/*"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-600 file:mr-3 file:py-1 file:px-3 file:border-0 file:rounded-lg file:bg-blue-50 file:text-blue-900 file:text-xs file:font-semibold hover:file:bg-blue-100 transition">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Featured --}}
            <div class="flex items-center gap-2 mb-6">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" id="is_featured" value="1"
                       {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-900 focus:ring-blue-500">
                <label for="is_featured" class="text-sm text-gray-700 font-medium">Tampilkan sebagai produk unggulan di landing page</label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors">
                    {{ $product->exists ? 'Simpan Perubahan' : 'Tambah Produk' }}
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold px-6 py-2.5 rounded-xl transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function autoSlug() {
        const name = document.getElementById('name').value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        document.getElementById('slug').value = slug;
    }

    function addSpecRow(key = '', value = '') {
        const container = document.getElementById('specs-container');
        // Remove empty state placeholder if present
        const placeholder = container.querySelector('p');
        if (placeholder) placeholder.remove();

        const row = document.createElement('div');
        row.className = 'flex gap-2';
        row.innerHTML = `
            <input type="text" placeholder="Nama spesifikasi" value="${key}"
                   class="spec-key flex-1 border border-gray-200 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
            <input type="text" placeholder="Nilai" value="${value}"
                   class="spec-value flex-1 border border-gray-200 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
            <button type="button" onclick="this.closest('div').remove()"
                    class="text-red-400 hover:text-red-600 px-2 flex-shrink-0 text-lg leading-none">×</button>
        `;
        container.appendChild(row);
    }

    function serializeSpecs() {
        const specs = {};
        document.querySelectorAll('#specs-container .flex').forEach(row => {
            const key   = row.querySelector('.spec-key')?.value?.trim();
            const value = row.querySelector('.spec-value')?.value?.trim();
            if (key) specs[key] = value ?? '';
        });
        document.getElementById('specs-input').value = JSON.stringify(specs);
        return true;
    }
</script>
@endpush

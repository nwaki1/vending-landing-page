@extends('admin.layouts.app')

@section('title', $banner->exists ? 'Edit Banner' : 'Tambah Banner')

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.banners.index') }}" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-gray-700 text-sm mb-5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">{{ $banner->exists ? 'Edit Banner' : 'Tambah Banner' }}</h2>

        <form method="POST"
              action="{{ $banner->exists ? route('admin.banners.update', $banner) : route('admin.banners.store') }}"
              enctype="multipart/form-data">
            @csrf @if($banner->exists) @method('PUT') @endif

            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $banner->title) }}" required
                           class="w-full border {{ $errors->has('title') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Subjudul</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Teks CTA</label>
                        <input type="text" name="cta_text" value="{{ old('cta_text', $banner->cta_text) }}" placeholder="Contoh: Lihat Produk"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">URL CTA</label>
                        <input type="text" name="cta_url" value="{{ old('cta_url', $banner->cta_url) }}" placeholder="/katalog"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Urutan</label>
                        <input type="number" name="order" value="{{ old('order', $banner->order ?? 0) }}" min="0"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                    <div class="flex items-end pb-2.5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-900 focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">Aktifkan banner</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Gambar</label>
                    @if ($banner->image)
                    <img src="{{ Storage::url($banner->image) }}" alt="" class="h-20 rounded-lg border border-gray-200 mb-2 object-cover">
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-600 file:mr-3 file:py-1 file:px-3 file:border-0 file:rounded-lg file:bg-blue-50 file:text-blue-900 file:text-xs file:font-semibold hover:file:bg-blue-100 transition">
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors">
                    {{ $banner->exists ? 'Simpan Perubahan' : 'Tambah Banner' }}
                </button>
                <a href="{{ route('admin.banners.index') }}" class="border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold px-6 py-2.5 rounded-xl transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection

@extends('admin.layouts.app')

@section('title', $testimonial->exists ? 'Edit Testimoni' : 'Tambah Testimoni')

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-gray-700 text-sm mb-5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">{{ $testimonial->exists ? 'Edit Testimoni' : 'Tambah Testimoni' }}</h2>

        <form method="POST"
              action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}"
              enctype="multipart/form-data">
            @csrf @if($testimonial->exists) @method('PUT') @endif

            <div class="space-y-4 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required
                               class="w-full border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan / Perusahaan</label>
                        <input type="text" name="position" value="{{ old('position', $testimonial->position) }}" placeholder="Contoh: Manager PT XYZ"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Rating <span class="text-red-500">*</span></label>
                    <select name="rating" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                        @foreach (range(5, 1) as $r)
                        <option value="{{ $r }}" {{ old('rating', $testimonial->rating ?? 5) == $r ? 'selected' : '' }}>
                            {{ $r }} Bintang — {{ str_repeat('★', $r) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Isi Testimoni <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="4" required
                              class="w-full border {{ $errors->has('content') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none">{{ old('content', $testimonial->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto</label>
                    @if ($testimonial->photo)
                    <img src="{{ Storage::url($testimonial->photo) }}" alt="" class="h-14 w-14 rounded-full object-cover border border-gray-200 mb-2">
                    @endif
                    <input type="file" name="photo" accept="image/*"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-600 file:mr-3 file:py-1 file:px-3 file:border-0 file:rounded-lg file:bg-blue-50 file:text-blue-900 file:text-xs file:font-semibold hover:file:bg-blue-100 transition">
                </div>

                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" id="is_published" value="1"
                           {{ old('is_published', $testimonial->is_published ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-900 focus:ring-blue-500">
                    <label for="is_published" class="text-sm font-medium text-gray-700">Publikasikan di situs</label>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors">
                    {{ $testimonial->exists ? 'Simpan Perubahan' : 'Tambah Testimoni' }}
                </button>
                <a href="{{ route('admin.testimonials.index') }}" class="border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold px-6 py-2.5 rounded-xl transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection

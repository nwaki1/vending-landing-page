@extends('admin.layouts.app')

@section('title', $article->exists ? 'Edit Artikel' : 'Tulis Artikel')

@section('content')

<div class="max-w-3xl">
    <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-gray-700 text-sm mb-5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">{{ $article->exists ? 'Edit Artikel' : 'Tulis Artikel Baru' }}</h2>

        <form method="POST"
              action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}"
              enctype="multipart/form-data">
            @csrf @if($article->exists) @method('PUT') @endif

            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required
                           oninput="autoSlug()"
                           class="w-full border {{ $errors->has('title') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Slug <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $article->slug) }}" required
                           class="w-full border {{ $errors->has('slug') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Konten <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="12" required
                              class="w-full border {{ $errors->has('content') ? 'border-red-400' : 'border-gray-200' }} rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-y font-mono">{{ old('content', $article->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Gambar Sampul</label>
                    @if ($article->image)
                    <img src="{{ Storage::url($article->image) }}" alt="" class="h-24 rounded-lg border border-gray-200 mb-2 object-cover">
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-600 file:mr-3 file:py-1 file:px-3 file:border-0 file:rounded-lg file:bg-blue-50 file:text-blue-900 file:text-xs file:font-semibold hover:file:bg-blue-100 transition">
                </div>

                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" id="is_published" value="1"
                           {{ old('is_published', $article->is_published ?? false) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-900 focus:ring-blue-500">
                    <label for="is_published" class="text-sm font-medium text-gray-700">Publikasikan artikel</label>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors">
                    {{ $article->exists ? 'Simpan Perubahan' : 'Publish Artikel' }}
                </button>
                <a href="{{ route('admin.articles.index') }}" class="border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold px-6 py-2.5 rounded-xl transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function autoSlug() {
        const title = document.getElementById('title').value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim().replace(/\s+/g, '-').replace(/-+/g, '-');
        document.getElementById('slug').value = slug;
    }
</script>
@endpush

@endsection

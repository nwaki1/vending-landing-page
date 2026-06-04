@extends('admin.layouts.app')

@section('title', 'Kelola Testimoni')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">{{ $testimonials->total() }} testimoni</p>
    <a href="{{ route('admin.testimonials.create') }}"
       class="bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Testimoni
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 text-left">
                <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Customer</th>
                <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Rating</th>
                <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Isi</th>
                <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide text-center">Publish</th>
                <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse ($testimonials as $t)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3">
                    <p class="font-semibold text-gray-900">{{ $t->name }}</p>
                    <p class="text-gray-400 text-xs">{{ $t->position ?? '' }}</p>
                </td>
                <td class="px-5 py-3">
                    <span class="text-amber-500">{{ str_repeat('★', $t->rating) }}{{ str_repeat('☆', 5 - $t->rating) }}</span>
                </td>
                <td class="px-5 py-3 text-gray-500 text-xs max-w-xs">
                    <p class="truncate">{{ $t->content }}</p>
                </td>
                <td class="px-5 py-3 text-center">
                    <span class="inline-block {{ $t->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }} text-xs font-semibold px-2.5 py-1 rounded-full">
                        {{ $t->is_published ? 'Publish' : 'Draft' }}
                    </span>
                </td>
                <td class="px-5 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.testimonials.edit', $t) }}" class="text-blue-900 text-xs font-semibold px-3 py-1.5 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">Edit</a>
                        <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" onsubmit="return confirm('Hapus testimoni ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 text-xs font-semibold px-3 py-1.5 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">Belum ada testimoni.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if ($testimonials->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $testimonials->links() }}</div>
    @endif
</div>

@endsection

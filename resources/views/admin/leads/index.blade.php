@extends('admin.layouts.app')

@section('title', 'Kelola Leads')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    {{-- Filter tabs --}}
    <div class="flex gap-1 bg-white border border-gray-200 rounded-xl p-1">
        @php
            $tabs = ['' => 'Semua', 'new' => 'Baru', 'contacted' => 'Dihubungi', 'closed' => 'Selesai'];
        @endphp
        @foreach ($tabs as $val => $label)
        <a href="{{ route('admin.leads.index', $val ? ['status' => $val] : []) }}"
           class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors
                  {{ $status === ($val ?: null) ? 'bg-blue-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <a href="{{ route('admin.leads.export', $status ? ['status' => $status] : []) }}"
       class="flex items-center gap-2 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        Export CSV
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Lead</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kebutuhan</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Pesan</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($leads as $lead)
                @php
                    $statusColor = match($lead->status) {
                        'new'       => 'bg-red-100 text-red-700',
                        'contacted' => 'bg-amber-100 text-amber-700',
                        'closed'    => 'bg-green-100 text-green-700',
                        default     => 'bg-gray-100 text-gray-700',
                    };
                @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <p class="font-semibold text-gray-900">{{ $lead->name }}</p>
                        <p class="text-gray-500 text-xs">{{ $lead->whatsapp }}</p>
                        @if ($lead->email)
                        <p class="text-gray-400 text-xs">{{ $lead->email }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-600">{{ $lead->need_label }}</td>
                    <td class="px-5 py-3 text-gray-500 max-w-xs">
                        <p class="truncate text-xs">{{ $lead->message ?? '—' }}</p>
                    </td>
                    <td class="px-5 py-3">
                        <form method="POST" action="{{ route('admin.leads.update-status', $lead) }}">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                    class="text-xs font-semibold border-0 rounded-lg px-2 py-1 focus:ring-0 cursor-pointer {{ $statusColor }} bg-transparent">
                                <option value="new"       {{ $lead->status === 'new'       ? 'selected' : '' }}>Baru</option>
                                <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>Dihubungi</option>
                                <option value="closed"    {{ $lead->status === 'closed'    ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-5 py-3 text-gray-400 text-xs whitespace-nowrap">
                        {{ $lead->created_at->format('d M Y') }}<br>{{ $lead->created_at->format('H:i') }}
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->whatsapp) }}?text={{ urlencode('Halo ' . $lead->name . ', kami dari VendoSmart ingin menindaklanjuti kebutuhan Anda mengenai ' . $lead->need_label . '. Apakah ada waktu untuk berdiskusi?') }}"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-500 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a9.87 9.87 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/>
                            </svg>
                            Balas WA
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">Belum ada leads.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($leads->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $leads->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection

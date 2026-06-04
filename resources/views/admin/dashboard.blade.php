@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Stat cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
        $cards = [
            ['label' => 'Total Produk',    'value' => $stats['total_products'], 'color' => 'blue',   'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['label' => 'Total Leads',     'value' => $stats['total_leads'],    'color' => 'indigo', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['label' => 'Leads Baru',      'value' => $stats['new_leads'],      'color' => 'red',    'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
            ['label' => 'Leads Bulan Ini', 'value' => $stats['monthly_leads'],  'color' => 'green',  'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ];
        $colorMap = [
            'blue'   => ['bg' => 'bg-blue-50',   'icon' => 'bg-blue-100 text-blue-700',   'val' => 'text-blue-900'],
            'indigo' => ['bg' => 'bg-indigo-50',  'icon' => 'bg-indigo-100 text-indigo-700','val' => 'text-indigo-900'],
            'red'    => ['bg' => 'bg-red-50',     'icon' => 'bg-red-100 text-red-700',     'val' => 'text-red-900'],
            'green'  => ['bg' => 'bg-green-50',   'icon' => 'bg-green-100 text-green-700', 'val' => 'text-green-900'],
        ];
    @endphp

    @foreach ($cards as $card)
    @php $c = $colorMap[$card['color']]; @endphp
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-12 h-12 {{ $c['icon'] }} rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500 text-xs font-medium">{{ $card['label'] }}</p>
            <p class="text-2xl font-extrabold {{ $c['val'] }}">{{ number_format($card['value']) }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Recent leads --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-gray-900">Leads Terbaru</h2>
        <a href="{{ route('admin.leads.index') }}" class="text-blue-900 text-sm font-medium hover:underline">Lihat semua →</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">WhatsApp</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kebutuhan</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($recentLeads as $lead)
                @php
                    $statusColor = match($lead->status) {
                        'new'       => 'bg-red-100 text-red-700',
                        'contacted' => 'bg-amber-100 text-amber-700',
                        'closed'    => 'bg-green-100 text-green-700',
                        default     => 'bg-gray-100 text-gray-700',
                    };
                @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3 font-medium text-gray-900">{{ $lead->name }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ $lead->whatsapp }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ $lead->need_label }}</td>
                    <td class="px-6 py-3">
                        <span class="inline-block {{ $statusColor }} text-xs font-semibold px-2.5 py-1 rounded-full">{{ $lead->status_label }}</span>
                    </td>
                    <td class="px-6 py-3 text-gray-400 text-xs">{{ $lead->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada lead masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

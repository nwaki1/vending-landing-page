<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        // Honeypot: bot isi field ini, manusia tidak
        if ($request->filled('website')) {
            return $request->expectsJson()
                ? response()->json(['success' => true])
                : redirect()->back()->with('lead_success', true);
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'whatsapp' => ['required', 'string', 'max:20', 'regex:/^(\+62|62|0)8[0-9]{8,12}$/'],
            'email'    => 'nullable|email|max:100',
            'need'     => 'required|in:beli,sewa,info,service',
            'message'  => 'nullable|string|max:1000',
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.regex'    => 'Format nomor tidak valid. Contoh: 08123456789.',
            'email.email'       => 'Format email tidak valid.',
            'need.required'     => 'Pilih kebutuhan Anda.',
            'need.in'           => 'Pilihan kebutuhan tidak valid.',
        ]);

        Lead::create([
            'name'     => $validated['name'],
            'whatsapp' => $validated['whatsapp'],
            'email'    => $validated['email'] ?? null,
            'need'     => $validated['need'],
            'message'  => $validated['message'] ?? null,
            'source'   => 'landing_page',
            'status'   => 'new',
        ]);

        return $request->expectsJson()
            ? response()->json(['success' => true])
            : redirect()->back()->with('lead_success', true);
    }
}

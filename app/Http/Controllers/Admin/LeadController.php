<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status');

        $leads = Lead::when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.leads.index', compact('leads', 'status'));
    }

    public function updateStatus(Request $request, Lead $lead): RedirectResponse
    {
        $request->validate(['status' => 'required|in:new,contacted,closed']);

        $lead->update(['status' => $request->status]);

        return back()->with('success', 'Status lead diperbarui.');
    }

    public function export(): Response
    {
        $leads = Lead::orderByDesc('created_at')->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="leads_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($leads) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM for Excel
            fputcsv($out, ['ID', 'Nama', 'WhatsApp', 'Email', 'Kebutuhan', 'Pesan', 'Sumber', 'Status', 'Tanggal']);
            foreach ($leads as $lead) {
                fputcsv($out, [
                    $lead->id,
                    $lead->name,
                    $lead->whatsapp,
                    $lead->email ?? '-',
                    $lead->need_label,
                    $lead->message ?? '-',
                    $lead->source,
                    $lead->status_label,
                    $lead->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}

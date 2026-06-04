<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_products' => Product::count(),
            'total_leads'    => Lead::count(),
            'new_leads'      => Lead::where('status', 'new')->count(),
            'monthly_leads'  => Lead::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count(),
        ];

        $recentLeads = Lead::orderByDesc('created_at')->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'recentLeads'));
    }
}

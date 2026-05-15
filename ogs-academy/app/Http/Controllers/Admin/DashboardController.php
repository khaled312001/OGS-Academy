<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Inquiry;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\Partner;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'programs'         => Program::count(),
            'published'        => Program::published()->count(),
            'categories'       => ProgramCategory::count(),
            'partners'         => Partner::count(),
            'inquiries_total'  => Inquiry::count(),
            'inquiries_new'    => Inquiry::new()->count(),
            'messages_total'   => ContactMessage::count(),
            'messages_unread'  => ContactMessage::unread()->count(),
        ];

        $latestInquiries = Inquiry::with('program')->latest()->limit(5)->get();
        $latestMessages  = ContactMessage::latest()->limit(5)->get();
        $topPrograms     = Program::published()->orderByDesc('views_count')->limit(5)->get();

        // Inquiries chart (last 30 days)
        $days = collect(range(29, 0))->map(function ($i) {
            return now()->subDays($i)->toDateString();
        });
        $byDay = Inquiry::query()
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->groupBy('d')
            ->pluck('c', 'd');
        $chartData = $days->map(fn ($d) => [
            'date'  => $d,
            'count' => (int) ($byDay[$d] ?? 0),
        ])->values();

        return view('admin.dashboard', compact('stats', 'latestInquiries', 'latestMessages', 'topPrograms', 'chartData'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPrograms = Program::published()
            ->featured()
            ->with('category')
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $latestPrograms = Program::published()
            ->with('category')
            ->latest()
            ->limit(3)
            ->get();

        $categories = ProgramCategory::active()
            ->withCount(['programs' => fn ($q) => $q->where('is_published', true)])
            ->orderBy('sort_order')
            ->get();

        $partners = Partner::active()
            ->whereIn('type', ['supervisor', 'partner'])
            ->orderBy('sort_order')
            ->get();

        $testimonials = Testimonial::active()->orderBy('sort_order')->limit(6)->get();

        return view('pages.home', compact(
            'featuredPrograms',
            'latestPrograms',
            'categories',
            'partners',
            'testimonials'
        ));
    }
}

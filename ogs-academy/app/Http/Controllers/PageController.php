<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Partner;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::where('slug', 'about')->where('is_published', true)->first();
        $partners = Partner::active()->orderBy('sort_order')->get();
        return view('pages.about', compact('page', 'partners'));
    }
}

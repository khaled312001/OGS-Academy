<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProgramCategory::active()->orderBy('sort_order')->get();
        $activeSlug = $request->query('category');

        $programs = Program::published()
            ->with('category')
            ->when($activeSlug, function ($q) use ($activeSlug) {
                $q->whereHas('category', fn ($c) => $c->where('slug', $activeSlug));
            })
            ->when($request->query('q'), function ($q, $term) {
                $q->where(function ($w) use ($term) {
                    $w->where('title_ar', 'like', "%{$term}%")
                      ->orWhere('summary_ar', 'like', "%{$term}%");
                });
            })
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(9)
            ->withQueryString();

        return view('pages.programs.index', compact('programs', 'categories', 'activeSlug'));
    }

    public function show(Program $program)
    {
        abort_unless($program->is_published, 404);
        $program->load(['modules', 'category']);

        // Increment views (lightweight, no event firing)
        Program::where('id', $program->id)->increment('views_count');

        $related = Program::published()
            ->where('id', '!=', $program->id)
            ->when($program->category_id, fn ($q) => $q->where('category_id', $program->category_id))
            ->limit(3)
            ->get();

        return view('pages.programs.show', compact('program', 'related'));
    }
}

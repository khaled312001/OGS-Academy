<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $activeCategory = $request->query('category');

        $articles = Article::published()
            ->when($activeCategory, fn ($q) => $q->where('category', $activeCategory))
            ->when($request->query('q'), function ($q, $t) {
                $q->where(function ($w) use ($t) {
                    $w->where('title_ar', 'like', "%{$t}%")
                      ->orWhere('excerpt_ar', 'like', "%{$t}%");
                });
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $featured = Article::published()->featured()->latest('published_at')->limit(1)->first();
        $categories = Article::CATEGORIES;

        return view('pages.articles.index', compact('articles', 'featured', 'categories', 'activeCategory'));
    }

    public function show(Article $article)
    {
        abort_unless($article->is_published, 404);
        Article::where('id', $article->id)->increment('views_count');

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->when($article->category, fn ($q) => $q->where('category', $article->category))
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('pages.articles.show', compact('article', 'related'));
    }
}

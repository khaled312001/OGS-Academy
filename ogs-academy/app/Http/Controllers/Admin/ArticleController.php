<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::query()
            ->with('author')
            ->when($request->q, fn ($q, $t) => $q->where('title_ar', 'like', "%{$t}%"))
            ->when($request->category, fn ($q, $c) => $q->where('category', $c))
            ->when($request->status === 'published', fn ($q) => $q->where('is_published', true))
            ->when($request->status === 'draft', fn ($q) => $q->where('is_published', false))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.articles.index', [
            'articles'   => $articles,
            'categories' => Article::CATEGORIES,
        ]);
    }

    public function create()
    {
        return view('admin.articles.create', ['categories' => Article::CATEGORIES]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['author_id'] = auth()->id();
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }
        $data['tags'] = $this->parseTags($request->tags);

        Article::create($data);
        return redirect()->route('admin.articles.index')->with('success', 'تم إضافة المقال.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', ['article' => $article, 'categories' => Article::CATEGORIES]);
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validateData($request, $article);
        if ($request->hasFile('cover_image')) {
            if ($article->cover_image) Storage::disk('public')->delete($article->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }
        $data['tags'] = $this->parseTags($request->tags);

        $article->update($data);
        return redirect()->route('admin.articles.index')->with('success', 'تم تحديث المقال.');
    }

    public function destroy(Article $article)
    {
        if ($article->cover_image) Storage::disk('public')->delete($article->cover_image);
        $article->delete();
        return back()->with('success', 'تم حذف المقال.');
    }

    private function validateData(Request $request, ?Article $article = null): array
    {
        return $request->validate([
            'title_ar'         => ['required', 'string', 'max:255'],
            'title_en'         => ['nullable', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:articles,slug,' . ($article?->id ?? '')],
            'subtitle_ar'      => ['nullable', 'string', 'max:255'],
            'excerpt_ar'       => ['nullable', 'string', 'max:500'],
            'content_ar'       => ['nullable', 'string'],
            'cover_image'      => ['nullable', 'image', 'max:4096'],
            'category'         => ['nullable', 'in:' . implode(',', array_keys(Article::CATEGORIES))],
            'read_minutes'     => ['nullable', 'integer', 'min:1', 'max:60'],
            'is_featured'      => ['nullable', 'boolean'],
            'is_published'     => ['nullable', 'boolean'],
            'published_at'     => ['nullable', 'date'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]) + [
            'is_featured'  => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published', true),
        ];
    }

    private function parseTags(?string $input): ?array
    {
        if (! $input) return null;
        return collect(explode(',', $input))->map(fn ($t) => trim($t))->filter()->values()->all();
    }
}

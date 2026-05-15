<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;

class ProgramCategoryController extends Controller
{
    public function index()
    {
        $categories = ProgramCategory::withCount('programs')->orderBy('sort_order')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        ProgramCategory::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'تم إضافة التصنيف.');
    }

    public function edit(ProgramCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, ProgramCategory $category)
    {
        $data = $this->validateData($request, $category);
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'تم تحديث التصنيف.');
    }

    public function destroy(ProgramCategory $category)
    {
        $category->delete();
        return back()->with('success', 'تم حذف التصنيف.');
    }

    private function validateData(Request $request, ?ProgramCategory $cat = null): array
    {
        return $request->validate([
            'name_ar'        => ['required', 'string', 'max:160'],
            'name_en'        => ['nullable', 'string', 'max:160'],
            'slug'           => ['nullable', 'string', 'max:160', 'unique:program_categories,slug,' . ($cat?->id ?? '')],
            'description_ar' => ['nullable', 'string', 'max:600'],
            'icon'           => ['nullable', 'string', 'max:60'],
            'color'          => ['nullable', 'string', 'max:16'],
            'sort_order'     => ['nullable', 'integer'],
            'is_active'      => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}

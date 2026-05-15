<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $programs = Program::query()
            ->with('category')
            ->when($request->q, fn ($q, $t) => $q->where('title_ar', 'like', "%{$t}%"))
            ->when($request->category, fn ($q, $c) => $q->where('category_id', $c))
            ->when($request->status === 'published', fn ($q) => $q->where('is_published', true))
            ->when($request->status === 'draft',     fn ($q) => $q->where('is_published', false))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = ProgramCategory::orderBy('sort_order')->get();
        return view('admin.programs.index', compact('programs', 'categories'));
    }

    public function create()
    {
        $categories = ProgramCategory::orderBy('sort_order')->get();
        return view('admin.programs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('programs', 'public');
        }
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('programs', 'public');
        }
        $data['outcomes_ar']      = $this->parseList($request->outcomes_ar);
        $data['prerequisites_ar'] = $this->parseList($request->prerequisites_ar);

        $program = Program::create($data);

        $this->syncModules($program, $request->modules ?? []);

        return redirect()->route('admin.programs.index')->with('success', 'تم إضافة البرنامج بنجاح.');
    }

    public function edit(Program $program)
    {
        $program->load('modules');
        $categories = ProgramCategory::orderBy('sort_order')->get();
        return view('admin.programs.edit', compact('program', 'categories'));
    }

    public function update(Request $request, Program $program)
    {
        $data = $this->validateData($request, $program);
        if ($request->hasFile('cover_image')) {
            if ($program->cover_image) Storage::disk('public')->delete($program->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('programs', 'public');
        }
        if ($request->hasFile('thumbnail')) {
            if ($program->thumbnail) Storage::disk('public')->delete($program->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('programs', 'public');
        }
        $data['outcomes_ar']      = $this->parseList($request->outcomes_ar);
        $data['prerequisites_ar'] = $this->parseList($request->prerequisites_ar);

        $program->update($data);
        $this->syncModules($program, $request->modules ?? []);

        return redirect()->route('admin.programs.index')->with('success', 'تم تحديث البرنامج بنجاح.');
    }

    public function destroy(Program $program)
    {
        if ($program->cover_image) Storage::disk('public')->delete($program->cover_image);
        if ($program->thumbnail)   Storage::disk('public')->delete($program->thumbnail);
        $program->delete();
        return back()->with('success', 'تم حذف البرنامج.');
    }

    private function validateData(Request $request, ?Program $program = null): array
    {
        return $request->validate([
            'title_ar'         => ['required', 'string', 'max:255'],
            'title_en'         => ['nullable', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:programs,slug,' . ($program?->id ?? '')],
            'category_id'      => ['nullable', 'exists:program_categories,id'],
            'subtitle_ar'      => ['nullable', 'string', 'max:255'],
            'summary_ar'       => ['nullable', 'string', 'max:1000'],
            'description_ar'   => ['nullable', 'string'],
            'cover_image'      => ['nullable', 'image', 'max:4096'],
            'thumbnail'        => ['nullable', 'image', 'max:2048'],
            'intro_video_url'  => ['nullable', 'url', 'max:255'],
            'duration_label'   => ['nullable', 'string', 'max:120'],
            'duration_hours'   => ['nullable', 'integer', 'min:0'],
            'level'            => ['nullable', 'string', 'max:60'],
            'audience_ar'      => ['nullable', 'string', 'max:255'],
            'certificate_label'=> ['nullable', 'string', 'max:255'],
            'price'            => ['nullable', 'numeric', 'min:0'],
            'price_label'      => ['nullable', 'string', 'max:120'],
            'seats'            => ['nullable', 'integer', 'min:0'],
            'start_date'       => ['nullable', 'date'],
            'end_date'         => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_featured'      => ['nullable', 'boolean'],
            'is_published'     => ['nullable', 'boolean'],
            'sort_order'       => ['nullable', 'integer'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]) + [
            'is_featured'  => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published', true),
        ];
    }

    private function parseList(?string $input): array
    {
        if (! $input) return [];
        return collect(preg_split('/\r\n|\r|\n/', $input))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->all();
    }

    private function syncModules(Program $program, array $modules): void
    {
        $program->modules()->delete();
        foreach ($modules as $idx => $m) {
            if (empty($m['title_ar'])) continue;
            $program->modules()->create([
                'title_ar'       => $m['title_ar'],
                'description_ar' => $m['description_ar'] ?? null,
                'duration_hours' => $m['duration_hours'] ?? null,
                'sort_order'     => $idx + 1,
            ]);
        }
    }
}

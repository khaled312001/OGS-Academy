<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'تم إضافة الشهادة.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $this->validateData($request, $testimonial);
        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar) Storage::disk('public')->delete($testimonial->avatar);
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'تم تحديث الشهادة.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->avatar) Storage::disk('public')->delete($testimonial->avatar);
        $testimonial->delete();
        return back()->with('success', 'تم حذف الشهادة.');
    }

    private function validateData(Request $request, ?Testimonial $t = null): array
    {
        return $request->validate([
            'author_name'    => ['required', 'string', 'max:160'],
            'author_title'   => ['nullable', 'string', 'max:160'],
            'author_company' => ['nullable', 'string', 'max:160'],
            'avatar'         => ['nullable', 'image', 'max:2048'],
            'quote_ar'       => ['required', 'string', 'max:1500'],
            'rating'         => ['required', 'integer', 'min:1', 'max:5'],
            'sort_order'     => ['nullable', 'integer'],
            'is_active'      => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}

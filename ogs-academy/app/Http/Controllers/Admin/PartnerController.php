<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('type')->orderBy('sort_order')->paginate(20);
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }
        Partner::create($data);
        return redirect()->route('admin.partners.index')->with('success', 'تم إضافة الشريك.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $this->validateData($request, $partner);
        if ($request->hasFile('logo')) {
            if ($partner->logo && ! str_starts_with($partner->logo, 'http')) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }
        $partner->update($data);
        return redirect()->route('admin.partners.index')->with('success', 'تم تحديث الشريك.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo && ! str_starts_with($partner->logo, 'http')) {
            Storage::disk('public')->delete($partner->logo);
        }
        $partner->delete();
        return back()->with('success', 'تم حذف الشريك.');
    }

    private function validateData(Request $request, ?Partner $partner = null): array
    {
        return $request->validate([
            'name_ar'    => ['required', 'string', 'max:160'],
            'name_en'    => ['nullable', 'string', 'max:160'],
            'logo'       => [$partner ? 'nullable' : 'required', 'image', 'max:2048'],
            'website'    => ['nullable', 'url', 'max:255'],
            'type'       => ['required', 'in:partner,supervisor,accredited,sponsor'],
            'sort_order' => ['nullable', 'integer'],
            'is_active'  => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}

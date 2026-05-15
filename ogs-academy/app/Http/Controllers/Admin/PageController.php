<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index()
    {
        $pages    = config('admin_pages');
        $settings = SiteSetting::all_settings();
        $dbPages  = Page::pluck('updated_at', 'slug');

        return view('admin.pages.index', compact('pages', 'settings', 'dbPages'));
    }

    public function edit(string $slug)
    {
        $config = config("admin_pages.$slug");
        abort_if(! $config, 404, 'الصفحة غير موجودة في سجل الصفحات');

        $values  = SiteSetting::all_settings();
        $dbPage  = ! empty($config['page_db_slug'])
            ? Page::where('slug', $config['page_db_slug'])->first()
            : null;

        return view('admin.pages.edit', compact('slug', 'config', 'values', 'dbPage'));
    }

    public function update(Request $request, string $slug)
    {
        $config = config("admin_pages.$slug");
        abort_if(! $config, 404);

        // Save all section fields (text/textarea/number/image) to site_settings
        foreach (($config['sections'] ?? []) as $sectionKey => $section) {
            foreach (($section['fields'] ?? []) as $field) {
                $key  = $field['key'];
                $type = $field['type'] ?? 'text';
                $setting = SiteSetting::firstWhere('key', $key);
                if (! $setting) continue;

                if ($type === 'image') {
                    if ($request->hasFile("files.$key")) {
                        if ($setting->value && ! str_starts_with($setting->value, 'http')) {
                            Storage::disk('public')->delete($setting->value);
                        }
                        $setting->value = $request->file("files.$key")->store('settings', 'public');
                        $setting->save();
                    } elseif ($request->boolean("clear.$key")) {
                        if ($setting->value && ! str_starts_with($setting->value, 'http')) {
                            Storage::disk('public')->delete($setting->value);
                        }
                        $setting->value = null;
                        $setting->save();
                    }
                    continue;
                }

                $value = $request->input("values.$key");
                $setting->value = $value;
                $setting->save();
            }
        }

        // Save Page DB record (about page)
        if (! empty($config['page_db_slug'])) {
            $page = Page::firstOrCreate(['slug' => $config['page_db_slug']], [
                'title_ar' => $config['title'] ?? $slug,
            ]);

            // content_ar, vision_ar, mission_ar (page-level fields)
            $sections = $page->sections ?? [];
            foreach (($config['page_fields'] ?? []) as $field) {
                $key = $field['key'];
                $val = $request->input("page.$key");
                if (! empty($field['section_field'])) {
                    $sections[$key] = $val;
                } else {
                    $page->{$key} = $val;
                }
            }

            // Repeaters (values, why_us)
            foreach (($config['page_repeaters'] ?? []) as $repKey => $repConfig) {
                $rows = $request->input("repeater.$repKey", []);
                $cleaned = [];
                foreach ($rows as $row) {
                    $hasAny = false;
                    $clean  = [];
                    foreach ($repConfig['fields'] as $rf) {
                        $v = $row[$rf['key']] ?? null;
                        if (! empty($v)) $hasAny = true;
                        $clean[$rf['key']] = $v;
                    }
                    if ($hasAny) $cleaned[] = $clean;
                }
                $sections[$repKey] = $cleaned;
            }
            $page->sections = $sections;
            $page->save();
        }

        return redirect()->route('admin.pages.edit', $slug)->with('success', 'تم حفظ التعديلات. التغييرات تظهر فوراً على الموقع.');
    }
}

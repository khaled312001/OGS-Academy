<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    private array $groups = [
        'general' => 'الإعدادات العامة',
        'hero'    => 'قسم الهيرو',
        'about'   => 'من نحن',
        'stats'   => 'الإحصائيات',
        'contact' => 'بيانات الاتصال',
        'social'  => 'حسابات التواصل',
        'seo'     => 'تحسين محركات البحث',
    ];

    public function index(Request $request)
    {
        $activeGroup = $request->query('group', 'general');
        if (! array_key_exists($activeGroup, $this->groups)) {
            $activeGroup = 'general';
        }

        $items = SiteSetting::where('group', $activeGroup)
            ->orderBy('sort_order')
            ->get();

        return view('admin.settings.index', [
            'items'       => $items,
            'groups'      => $this->groups,
            'activeGroup' => $activeGroup,
        ]);
    }

    public function update(Request $request)
    {
        $group = $request->input('group', 'general');
        $values = $request->input('values', []);
        $files  = $request->file('files', []);

        foreach ($values as $key => $value) {
            $setting = SiteSetting::firstWhere('key', $key);
            if (! $setting) continue;

            if ($setting->type === 'bool') {
                $value = $request->boolean("values.$key") ? '1' : '0';
            }
            if ($setting->type === 'json' && is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }
            $setting->update(['value' => $value]);
        }

        foreach ($files as $key => $file) {
            $setting = SiteSetting::firstWhere('key', $key);
            if (! $setting) continue;
            if ($setting->value) Storage::disk('public')->delete($setting->value);
            $path = $file->store('settings', 'public');
            $setting->update(['value' => $path]);
        }

        return redirect()->route('admin.settings.index', ['group' => $group])->with('success', 'تم حفظ الإعدادات.');
    }
}

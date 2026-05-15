<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $base = Inquiry::query()
            ->with('program')
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->lead_type === 'b2b',  fn ($q) => $q->whereNotNull('company')->where('company', '!=', ''))
            ->when($request->lead_type === 'individual', fn ($q) => $q->where(function ($w) { $w->whereNull('company')->orWhere('company', ''); }))
            ->when($request->q, function ($q, $t) {
                $q->where(function ($w) use ($t) {
                    $w->where('full_name', 'like', "%{$t}%")
                      ->orWhere('email', 'like', "%{$t}%")
                      ->orWhere('company', 'like', "%{$t}%")
                      ->orWhere('phone', 'like', "%{$t}%");
                });
            });

        $inquiries = (clone $base)->latest()->paginate(15)->withQueryString();

        $counts = [
            'all'         => Inquiry::count(),
            'new'         => Inquiry::where('status', 'new')->count(),
            'b2b'         => Inquiry::whereNotNull('company')->where('company', '!=', '')->count(),
            'individual'  => Inquiry::where(function ($w) { $w->whereNull('company')->orWhere('company', ''); })->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'counts'));
    }

    public function export(Request $request): StreamedResponse
    {
        $filename = 'inquiries-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $rows = Inquiry::with('program')
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->get();

        return response()->stream(function () use ($rows) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM for Excel Arabic support
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, [
                '#', 'الاسم', 'الشركة', 'المسمى الوظيفي', 'البريد', 'الجوال',
                'البرنامج', 'عدد المتدربين', 'التاريخ المفضّل', 'الحالة', 'المصدر', 'الرسالة', 'تاريخ الإرسال',
            ]);
            foreach ($rows as $i => $r) {
                fputcsv($out, [
                    $i + 1,
                    $r->full_name,
                    $r->company,
                    $r->job_title,
                    $r->email,
                    $r->phone,
                    optional($r->program)->title_ar,
                    $r->trainees_count,
                    $r->preferred_date,
                    $r->status_label,
                    $r->source,
                    str_replace(["\r","\n"], ' ', (string) $r->message),
                    $r->created_at?->format('Y-m-d H:i'),
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load('program');
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $data = $request->validate([
            'status'      => ['required', 'in:' . implode(',', array_keys(Inquiry::STATUSES))],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);
        $inquiry->update($data);
        return back()->with('success', 'تم تحديث الطلب.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'تم حذف الطلب.');
    }
}

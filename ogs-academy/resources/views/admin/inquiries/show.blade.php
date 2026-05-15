@extends('layouts.admin')
@section('title', 'تفاصيل الطلب')
@section('subtitle', $inquiry->full_name)

@section('content')
<div class="grid lg:grid-cols-[1fr_360px] gap-6 max-w-6xl">
    <div class="space-y-6">
        <div class="p-6 rounded-2xl bg-white border border-brand-gray">
            <h3 class="font-extrabold mb-5 flex items-center gap-2"><span class="flame-bar"></span> معلومات مقدم الطلب</h3>
            <dl class="grid sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                <div><dt class="text-brand-ink/60 mb-1">الاسم</dt><dd class="font-bold">{{ $inquiry->full_name }}</dd></div>
                <div><dt class="text-brand-ink/60 mb-1">الشركة</dt><dd class="font-bold">{{ $inquiry->company ?: '—' }}</dd></div>
                <div><dt class="text-brand-ink/60 mb-1">المسمى الوظيفي</dt><dd class="font-bold">{{ $inquiry->job_title ?: '—' }}</dd></div>
                <div><dt class="text-brand-ink/60 mb-1">البريد</dt><dd class="font-bold" dir="ltr">{{ $inquiry->email }}</dd></div>
                <div><dt class="text-brand-ink/60 mb-1">الجوال</dt><dd class="font-bold" dir="ltr">{{ $inquiry->phone }}</dd></div>
                <div><dt class="text-brand-ink/60 mb-1">عدد المتدربين</dt><dd class="font-bold">{{ $inquiry->trainees_count ?: '—' }}</dd></div>
                <div><dt class="text-brand-ink/60 mb-1">التاريخ المفضّل</dt><dd class="font-bold">{{ $inquiry->preferred_date ?: '—' }}</dd></div>
                <div><dt class="text-brand-ink/60 mb-1">المصدر</dt><dd class="font-bold">{{ $inquiry->source ?: '—' }}</dd></div>
            </dl>

            @if($inquiry->program)
                <div class="mt-5 pt-5 border-t border-brand-gray">
                    <p class="text-sm text-brand-ink/60 mb-2">البرنامج المطلوب</p>
                    <a href="{{ route('admin.programs.edit', $inquiry->program) }}" class="inline-flex items-center gap-2 text-brand-red font-bold hover:underline">
                        {{ $inquiry->program->title_ar }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            @endif
        </div>

        @if($inquiry->message)
            <div class="p-6 rounded-2xl bg-white border border-brand-gray">
                <h3 class="font-extrabold mb-3 flex items-center gap-2"><span class="flame-bar"></span> الرسالة</h3>
                <p class="text-brand-ink/80 leading-relaxed whitespace-pre-line">{{ $inquiry->message }}</p>
            </div>
        @endif

        <div class="p-6 rounded-2xl bg-white border border-brand-gray text-xs text-brand-ink/60">
            <p>تم الإرسال: {{ $inquiry->created_at->format('Y-m-d H:i') }} ({{ $inquiry->created_at->diffForHumans() }})</p>
            <p class="mt-1" dir="ltr">IP: {{ $inquiry->ip_address }}</p>
        </div>
    </div>

    <aside class="space-y-6 lg:sticky lg:top-24 self-start">
        <div class="p-6 rounded-2xl bg-white border border-brand-gray">
            <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}">
                @csrf @method('PUT')
                <h3 class="font-extrabold mb-4">حالة الطلب</h3>
                <select name="status" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3 mb-4">
                    @foreach(\App\Models\Inquiry::STATUSES as $k => $v)
                        <option value="{{ $k }}" @selected($inquiry->status === $k)>{{ $v }}</option>
                    @endforeach
                </select>

                <label class="block text-sm font-bold mb-2">ملاحظات داخلية</label>
                <textarea name="admin_notes" rows="6" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3 mb-4">{{ $inquiry->admin_notes }}</textarea>

                <button type="submit" class="btn btn-primary w-full">حفظ</button>
            </form>
        </div>

        <div class="p-6 rounded-2xl bg-white border border-brand-gray">
            <h3 class="font-extrabold mb-3">إجراءات سريعة</h3>
            <a href="mailto:{{ $inquiry->email }}" class="btn btn-outline w-full mb-2 text-sm">ردّ بالبريد</a>
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $inquiry->phone) }}" target="_blank" rel="noopener" class="btn w-full mb-2 text-sm bg-green-500 text-white hover:bg-green-600">واتساب</a>
            <a href="tel:{{ $inquiry->phone }}" class="btn btn-outline w-full mb-2 text-sm">اتصال</a>
            <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" onsubmit="return confirm('حذف الطلب نهائياً؟')">
                @csrf @method('DELETE')
                <button class="w-full text-red-600 text-sm py-2 hover:bg-red-50 rounded-xl mt-2">حذف الطلب</button>
            </form>
        </div>
    </aside>
</div>
@endsection

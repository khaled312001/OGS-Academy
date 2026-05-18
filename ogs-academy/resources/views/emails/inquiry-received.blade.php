@extends('emails.layout')

@section('badge', '🔔 طلب جديد · B2B')
@section('title', 'طلب من ' . ($inquiry->company ?: $inquiry->full_name))
@section('subtitle', 'تم استلامه ' . $inquiry->created_at->translatedFormat('j F Y · g:i a'))

@section('content')
    <p style="margin:0 0 20px;font-size:16px;color:#161616;line-height:1.85;">
        تم استلام طلب جديد من نموذج صفحة البرنامج. التفاصيل أدناه — يُرجى التواصل مع العميل خلال يوم عمل.
    </p>

    {{-- Info table --}}
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 0 24px;border:1px solid #ededed;border-radius:12px;overflow:hidden;">
        <tr style="background:linear-gradient(135deg,#fafafa 0%,#f3f4f6 100%);">
            <td colspan="2" style="padding:12px 18px;border-bottom:1px solid #ededed;">
                <div style="display:inline-block;width:3px;height:16px;background:#E30613;vertical-align:middle;margin-left:8px;border-radius:2px;"></div>
                <strong style="color:#A01818;font-size:14px;vertical-align:middle;">بيانات مقدِّم الطلب</strong>
            </td>
        </tr>
        <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;width:38%;border-bottom:1px solid #ededed;font-weight:700;">الاسم</td>
            <td style="padding:10px 18px;color:#161616;font-size:14px;border-bottom:1px solid #ededed;">{{ $inquiry->full_name }}</td></tr>
        @if($inquiry->company)
            <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;border-bottom:1px solid #ededed;font-weight:700;">الشركة / المؤسسة</td>
                <td style="padding:10px 18px;color:#A01818;font-size:14px;font-weight:700;border-bottom:1px solid #ededed;">{{ $inquiry->company }}</td></tr>
        @endif
        @if($inquiry->job_title)
            <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;border-bottom:1px solid #ededed;font-weight:700;">المسمى الوظيفي</td>
                <td style="padding:10px 18px;color:#161616;font-size:14px;border-bottom:1px solid #ededed;">{{ $inquiry->job_title }}</td></tr>
        @endif
        <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;border-bottom:1px solid #ededed;font-weight:700;">البريد الإلكتروني</td>
            <td style="padding:10px 18px;font-size:14px;border-bottom:1px solid #ededed;" dir="ltr">
                <a href="mailto:{{ $inquiry->email }}" style="color:#A01818;text-decoration:none;">{{ $inquiry->email }}</a>
            </td></tr>
        <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;border-bottom:1px solid #ededed;font-weight:700;">رقم الجوال</td>
            <td style="padding:10px 18px;font-size:14px;border-bottom:1px solid #ededed;" dir="ltr">
                <a href="tel:{{ $inquiry->phone }}" style="color:#A01818;text-decoration:none;">{{ $inquiry->phone }}</a>
            </td></tr>
    </table>

    @if($inquiry->program || $inquiry->trainees_count || $inquiry->preferred_date)
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 0 24px;border:1px solid #ededed;border-radius:12px;overflow:hidden;">
        <tr style="background:linear-gradient(135deg,#fafafa 0%,#f3f4f6 100%);">
            <td colspan="2" style="padding:12px 18px;border-bottom:1px solid #ededed;">
                <div style="display:inline-block;width:3px;height:16px;background:#E30613;vertical-align:middle;margin-left:8px;border-radius:2px;"></div>
                <strong style="color:#A01818;font-size:14px;vertical-align:middle;">تفاصيل البرنامج</strong>
            </td>
        </tr>
        @if($inquiry->program)
            <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;width:38%;border-bottom:1px solid #ededed;font-weight:700;">البرنامج المطلوب</td>
                <td style="padding:10px 18px;color:#161616;font-size:14px;border-bottom:1px solid #ededed;font-weight:700;">{{ $inquiry->program->title_ar }}</td></tr>
        @endif
        @if($inquiry->trainees_count)
            <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;border-bottom:1px solid #ededed;font-weight:700;">عدد المتدربين</td>
                <td style="padding:10px 18px;color:#161616;font-size:14px;border-bottom:1px solid #ededed;">{{ $inquiry->trainees_count }} متدرب</td></tr>
        @endif
        @if($inquiry->preferred_date)
            <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;border-bottom:1px solid #ededed;font-weight:700;">التاريخ المفضّل</td>
                <td style="padding:10px 18px;color:#161616;font-size:14px;border-bottom:1px solid #ededed;">{{ $inquiry->preferred_date }}</td></tr>
        @endif
    </table>
    @endif

    @if($inquiry->message)
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 0 24px;">
            <tr>
                <td style="padding:0;">
                    <div style="display:inline-block;width:3px;height:16px;background:#E30613;vertical-align:middle;margin-left:8px;border-radius:2px;"></div>
                    <strong style="color:#A01818;font-size:14px;vertical-align:middle;">رسالة العميل</strong>
                </td>
            </tr>
            <tr>
                <td style="padding:14px 18px;background:linear-gradient(135deg,#fff5f5 0%,#fafafa 100%);border-right:4px solid #A01818;border-radius:0 8px 8px 0;color:#161616;font-size:14px;line-height:1.85;margin-top:10px;">
                    {!! nl2br(e($inquiry->message)) !!}
                </td>
            </tr>
        </table>
    @endif

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:20px 0 16px;">
        <tr>
            <td align="center">
                <a href="{{ url('/admin/inquiries/' . $inquiry->id) }}"
                   style="display:inline-block;padding:14px 36px;background:linear-gradient(135deg,#A01818 0%,#5C0808 100%);color:#ffffff;text-decoration:none;border-radius:999px;font-weight:800;font-size:14px;box-shadow:0 6px 16px rgba(160,24,24,0.3);">
                    📋 عرض الطلب في لوحة التحكم
                </a>
            </td>
        </tr>
    </table>

    <p style="margin:18px 0 0;color:#9ca3af;font-size:12px;text-align:center;border-top:1px solid #ededed;padding-top:14px;">
        المصدر: <strong>{{ $inquiry->source ?: 'الموقع' }}</strong>
        · IP: <span dir="ltr">{{ $inquiry->ip_address ?? '—' }}</span>
        · معرف الطلب: <strong>#{{ str_pad((string)$inquiry->id, 5, '0', STR_PAD_LEFT) }}</strong>
    </p>
@endsection

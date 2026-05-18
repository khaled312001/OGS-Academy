@extends('emails.layout')

@section('badge', '📧 رسالة تواصل')
@section('title', 'رسالة من ' . $message->full_name)
@section('subtitle', $message->created_at->translatedFormat('j F Y · g:i a'))

@section('content')
    <p style="margin:0 0 20px;font-size:16px;color:#161616;line-height:1.85;">
        وصلتك رسالة جديدة عبر صفحة "تواصل معنا" على الموقع.
    </p>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 0 24px;border:1px solid #ededed;border-radius:12px;overflow:hidden;">
        <tr style="background:linear-gradient(135deg,#fafafa 0%,#f3f4f6 100%);">
            <td colspan="2" style="padding:12px 18px;border-bottom:1px solid #ededed;">
                <div style="display:inline-block;width:3px;height:16px;background:#E30613;vertical-align:middle;margin-left:8px;border-radius:2px;"></div>
                <strong style="color:#A01818;font-size:14px;vertical-align:middle;">بيانات المُرسِل</strong>
            </td>
        </tr>
        <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;width:38%;border-bottom:1px solid #ededed;font-weight:700;">الاسم</td>
            <td style="padding:10px 18px;color:#161616;font-size:14px;border-bottom:1px solid #ededed;">{{ $message->full_name }}</td></tr>
        <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;border-bottom:1px solid #ededed;font-weight:700;">البريد الإلكتروني</td>
            <td style="padding:10px 18px;font-size:14px;border-bottom:1px solid #ededed;" dir="ltr">
                <a href="mailto:{{ $message->email }}" style="color:#A01818;text-decoration:none;">{{ $message->email }}</a>
            </td></tr>
        @if($message->phone)
            <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;border-bottom:1px solid #ededed;font-weight:700;">رقم الجوال</td>
                <td style="padding:10px 18px;font-size:14px;border-bottom:1px solid #ededed;" dir="ltr">
                    <a href="tel:{{ $message->phone }}" style="color:#A01818;text-decoration:none;">{{ $message->phone }}</a>
                </td></tr>
        @endif
        @if($message->subject)
            <tr><td style="padding:10px 18px;background:#fafafa;color:#888;font-size:13px;border-bottom:1px solid #ededed;font-weight:700;">الموضوع</td>
                <td style="padding:10px 18px;color:#161616;font-size:14px;font-weight:700;border-bottom:1px solid #ededed;">{{ $message->subject }}</td></tr>
        @endif
    </table>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:0 0 24px;">
        <tr>
            <td style="padding:0 0 10px;">
                <div style="display:inline-block;width:3px;height:16px;background:#E30613;vertical-align:middle;margin-left:8px;border-radius:2px;"></div>
                <strong style="color:#A01818;font-size:14px;vertical-align:middle;">نص الرسالة</strong>
            </td>
        </tr>
        <tr>
            <td style="padding:14px 18px;background:linear-gradient(135deg,#fff5f5 0%,#fafafa 100%);border-right:4px solid #A01818;border-radius:0 8px 8px 0;color:#161616;font-size:14px;line-height:1.85;">
                {!! nl2br(e($message->message)) !!}
            </td>
        </tr>
    </table>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:20px 0 16px;">
        <tr>
            <td align="center">
                <a href="{{ url('/admin/messages/' . $message->id) }}"
                   style="display:inline-block;padding:14px 36px;background:linear-gradient(135deg,#A01818 0%,#5C0808 100%);color:#ffffff;text-decoration:none;border-radius:999px;font-weight:800;font-size:14px;box-shadow:0 6px 16px rgba(160,24,24,0.3);">
                    📬 عرض الرسالة في لوحة التحكم
                </a>
            </td>
        </tr>
    </table>

    <p style="margin:18px 0 0;color:#9ca3af;font-size:12px;text-align:center;border-top:1px solid #ededed;padding-top:14px;">
        IP: <span dir="ltr">{{ $message->ip_address ?? '—' }}</span>
        · معرف الرسالة: <strong>#{{ str_pad((string)$message->id, 5, '0', STR_PAD_LEFT) }}</strong>
    </p>
@endsection

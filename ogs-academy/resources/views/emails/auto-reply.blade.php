@extends('emails.layout')

@section('badge', '✓ تأكيد استلام')
@section('title', $type === 'contact' ? 'وصلتنا رسالتك بنجاح' : 'وصلنا طلبك بنجاح')
@section('subtitle', 'شكراً لاهتمامك بأكاديمية OGS للخدمات التدريبية')

@section('content')
    <p style="margin:0 0 16px;font-size:17px;color:#161616;line-height:1.85;">
        مرحباً <strong style="color:#A01818;">{{ $recipientName }}</strong>،
    </p>

    @if($type === 'contact')
        <p style="margin:0 0 14px;font-size:15px;color:#161616;line-height:1.85;">
            شكراً لتواصلك مع أكاديمية OGS. وصلت رسالتك بنجاح إلى فريقنا، وسيتم الرد عليك خلال <strong>يوم عمل واحد</strong>.
        </p>
    @else
        <p style="margin:0 0 14px;font-size:15px;color:#161616;line-height:1.85;">
            شكراً لاهتمامك ببرامج <strong style="color:#A01818;">أكاديمية OGS</strong> التدريبية. تم استلام طلبك بنجاح@if($programTitle) بخصوص برنامج <strong>"{{ $programTitle }}"</strong>@endif.
        </p>
        <p style="margin:0 0 18px;font-size:15px;color:#161616;line-height:1.85;">
            سيقوم فريق التطوير المؤسسي لدينا بالتواصل معك خلال <strong>يوم عمل واحد</strong> لتخصيص البرنامج وفق احتياجات شركتك.
        </p>
    @endif

    {{-- Confirmation box --}}
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:20px 0;background:linear-gradient(135deg,#fff5f5 0%,#fafafa 100%);border-right:4px solid #A01818;border-radius:0 12px 12px 0;">
        <tr>
            <td style="padding:18px 22px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td style="vertical-align:top;padding-left:14px;">
                            <div style="width:36px;height:36px;background:linear-gradient(135deg,#A01818 0%,#5C0808 100%);border-radius:50%;text-align:center;line-height:36px;color:#fff;font-size:18px;">✓</div>
                        </td>
                        <td style="vertical-align:middle;">
                            <strong style="display:block;color:#A01818;font-size:14px;margin-bottom:3px;">تم الحفظ في نظامنا</strong>
                            <span style="color:#666;font-size:13px;">سيتواصل معك المختص المسؤول قريباً</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Links --}}
    <h2 style="color:#A01818;font-size:16px;margin:24px 0 12px;font-weight:800;">
        <span style="display:inline-block;width:3px;height:16px;background:#E30613;vertical-align:middle;margin-left:8px;border-radius:2px;"></span>
        في انتظار التواصل، يمكنك:
    </h2>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:8px 0;">
        @foreach([
            ['📚', 'استعراض كل برامجنا التدريبية', '/programs'],
            ['📰', 'قراءة المقالات والأخبار', '/articles'],
            ['🏛️', 'تعرّف على الأكاديمية وشركائها', '/about'],
        ] as $row)
        <tr>
            <td style="padding:8px 0;border-bottom:1px solid #f3f4f6;">
                <a href="{{ url($row[2]) }}" style="text-decoration:none;color:#161616;font-size:14px;display:block;">
                    <span style="display:inline-block;margin-left:10px;">{{ $row[0] }}</span>
                    <span style="font-weight:700;">{{ $row[1] }}</span>
                    <span style="float:left;color:#A01818;font-weight:800;">←</span>
                </a>
            </td>
        </tr>
        @endforeach
    </table>

    {{-- Contact card --}}
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:28px 0 10px;background:linear-gradient(135deg,#0A0A0A 0%,#161616 100%);border-radius:12px;overflow:hidden;">
        <tr>
            <td style="padding:20px 24px;" align="center">
                <p style="margin:0 0 10px;color:rgba(255,255,255,0.7);font-size:11px;letter-spacing:1px;">للتواصل المباشر</p>
                <p style="margin:0;color:#ffffff;font-size:14px;line-height:1.8;">
                    <a href="tel:+966571107803" style="color:#E30613;text-decoration:none;font-weight:800;" dir="ltr">📞 +966 5711 078 03</a>
                    <br>
                    <a href="mailto:info@ogs-academy.com" style="color:#E30613;text-decoration:none;font-weight:800;" dir="ltr">✉️ info@ogs-academy.com</a>
                </p>
            </td>
        </tr>
    </table>

    <p style="margin:24px 0 0;color:#666;font-size:13px;line-height:1.85;">
        تحياتنا،<br>
        <strong style="color:#A01818;font-size:14px;">فريق أكاديمية OGS</strong><br>
        <span style="color:#888;font-size:12px;">تحت إشراف المؤسسة العامة للتدريب التقني والمهني</span>
    </p>
@endsection

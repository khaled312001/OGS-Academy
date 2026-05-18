<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'أكاديمية OGS')</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:'Tahoma','Segoe UI','Helvetica Neue',Arial,sans-serif;direction:rtl;">

<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background:#f3f4f6;">
    <tr>
        <td align="center" style="padding:30px 12px;">

            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="640" style="width:100%;max-width:640px;background:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 8px 28px rgba(10,10,10,0.08);">

                {{-- ========= HEADER ========= --}}
                <tr>
                    <td style="background:linear-gradient(135deg,#A01818 0%,#5C0808 100%);padding:0;position:relative;">
                        {{-- Top flame strip --}}
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr><td style="height:4px;background:linear-gradient(90deg,#E30613 0%,#FF3B3B 50%,#E30613 100%);"></td></tr>
                        </table>

                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td style="padding:28px 32px;" align="right">
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                        <tr>
                                            <td style="vertical-align:middle;">
                                                <img src="{{ url('/storage/brand/ogs-logo-white.png') }}" alt="OGS Academy"
                                                     height="46" style="display:block;border:0;outline:none;height:46px;">
                                            </td>
                                            <td style="vertical-align:middle;padding-right:14px;border-right:2px solid rgba(255,255,255,0.25);margin-right:14px;">
                                                <div style="color:#ffffff;font-size:16px;font-weight:800;line-height:1.2;padding-right:14px;">أكاديمية OGS</div>
                                                <div style="color:rgba(255,255,255,0.75);font-size:11px;letter-spacing:1px;padding-right:14px;">للخدمات التدريبية</div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0 32px 26px;" align="right">
                                    @hasSection('badge')
                                        <span style="display:inline-block;padding:5px 12px;border-radius:999px;background:rgba(255,255,255,0.18);color:#ffffff;font-size:11px;font-weight:700;letter-spacing:.5px;margin-bottom:10px;">@yield('badge')</span>
                                    @endif
                                    <h1 style="margin:8px 0 4px;color:#ffffff;font-size:22px;font-weight:800;line-height:1.4;">@yield('title')</h1>
                                    @hasSection('subtitle')<p style="margin:0;color:rgba(255,255,255,0.85);font-size:13px;">@yield('subtitle')</p>@endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- ========= BODY ========= --}}
                <tr>
                    <td style="padding:32px 36px 28px;color:#161616;font-size:15px;line-height:1.85;" align="right">
                        @yield('content')
                    </td>
                </tr>

                {{-- ========= SUPERVISOR STRIP ========= --}}
                <tr>
                    <td style="padding:14px 36px;background:#fafafa;border-top:1px solid #ededed;" align="center">
                        <p style="margin:0;color:#888;font-size:11px;letter-spacing:.5px;">تحت إشراف <strong style="color:#A01818;">المؤسسة العامة للتدريب التقني والمهني</strong></p>
                    </td>
                </tr>

                {{-- ========= FOOTER ========= --}}
                <tr>
                    <td style="background:#0A0A0A;padding:24px 36px;" align="center">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td align="center" style="padding-bottom:14px;">
                                    <img src="{{ url('/storage/brand/ogs-logo-white.png') }}" alt="OGS" height="32" style="display:inline-block;border:0;outline:none;height:32px;opacity:.9;">
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding-bottom:10px;">
                                    <a href="mailto:info@ogs-academy.com" style="display:inline-block;color:#E30613;text-decoration:none;font-size:13px;font-weight:700;margin:0 8px;" dir="ltr">info@ogs-academy.com</a>
                                    <span style="color:#555;">·</span>
                                    <a href="tel:+966571107803" style="display:inline-block;color:#E30613;text-decoration:none;font-size:13px;font-weight:700;margin:0 8px;" dir="ltr">+966 5711 078 03</a>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding-bottom:10px;">
                                    <a href="https://ogs-academy.com" style="color:rgba(255,255,255,0.7);text-decoration:none;font-size:12px;" dir="ltr">ogs-academy.com</a>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding-top:12px;border-top:1px solid rgba(255,255,255,0.1);">
                                    <p style="margin:0;color:rgba(255,255,255,0.5);font-size:11px;">© {{ date('Y') }} أكاديمية OGS · مبنى وادي مكة للأعمال · جامعة أم القرى · مكة المكرّمة</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="640" style="width:100%;max-width:640px;margin-top:12px;">
                <tr>
                    <td align="center" style="padding:8px 24px;color:#9ca3af;font-size:11px;line-height:1.6;">
                        هذه الرسالة مُولَّدة آلياً من نظام أكاديمية OGS. لا تردّ مباشرة على البريد إن لم تكن مرسِلَ هذا الطلب.
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

</body>
</html>

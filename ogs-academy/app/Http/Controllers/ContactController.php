<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\AutoReplyToSender;
use App\Mail\ContactReceived;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contact');
    }

    public function store(ContactRequest $request)
    {
        $message = ContactMessage::create([
            ...$request->validated(),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ]);

        $adminEmail = env('ADMIN_NOTIFY_EMAIL', 'info@ogs-academy.com');

        try {
            Mail::to($adminEmail)->send(new ContactReceived($message));
            Mail::to($message->email)->send(new AutoReplyToSender(
                recipientName: $message->full_name,
                type:          'contact',
            ));
        } catch (\Throwable $e) {
            Log::error('Contact mail failed: ' . $e->getMessage(), ['message_id' => $message->id]);
        }

        return back()->with('success', 'تم إرسال رسالتك بنجاح. وصلت رسالة تأكيد لبريدك الإلكتروني.');
    }
}

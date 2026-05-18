<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Mail\AutoReplyToSender;
use App\Mail\InquiryReceived;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(InquiryRequest $request)
    {
        $inquiry = Inquiry::create([
            ...$request->validated(),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ]);

        $inquiry->load('program');

        $adminEmail = config('mail.admin_notify') ?: env('ADMIN_NOTIFY_EMAIL', 'info@ogs-academy.com');

        try {
            // Notify admin
            Mail::to($adminEmail)->send(new InquiryReceived($inquiry));

            // Auto-reply to sender
            Mail::to($inquiry->email)->send(new AutoReplyToSender(
                recipientName: $inquiry->full_name,
                programTitle:  $inquiry->program?->title_ar,
                type:          'inquiry',
            ));
        } catch (\Throwable $e) {
            // Don't block UX if mail fails — log and continue
            Log::error('Inquiry mail failed: ' . $e->getMessage(), ['inquiry_id' => $inquiry->id]);
        }

        return back()->with('success', 'تم استلام طلبك بنجاح. سيتواصل معك فريقنا خلال يوم عمل.');
    }
}

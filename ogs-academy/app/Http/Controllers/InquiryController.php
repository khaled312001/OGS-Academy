<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function store(InquiryRequest $request)
    {
        Inquiry::create([
            ...$request->validated(),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ]);

        return back()->with('success', 'تم استلام طلبك. سيتواصل معك فريقنا في أقرب وقت.');
    }
}

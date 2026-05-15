<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = ContactMessage::query()
            ->when($request->q, function ($q, $t) {
                $q->where(function ($w) use ($t) {
                    $w->where('full_name', 'like', "%{$t}%")
                      ->orWhere('email', 'like', "%{$t}%")
                      ->orWhere('subject', 'like', "%{$t}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'تم حذف الرسالة.');
    }
}

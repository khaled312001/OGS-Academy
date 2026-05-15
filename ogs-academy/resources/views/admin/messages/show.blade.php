@extends('layouts.admin')
@section('title', 'تفاصيل الرسالة')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="p-6 rounded-2xl bg-white border border-brand-gray">
        <div class="flex items-start gap-4 mb-6">
            <div class="w-14 h-14 rounded-full bg-brand-red text-white flex items-center justify-center text-xl font-bold">{{ mb_substr($message->full_name,0,1) }}</div>
            <div>
                <p class="text-lg font-extrabold">{{ $message->full_name }}</p>
                <p class="text-sm text-brand-ink/60" dir="ltr">{{ $message->email }}@if($message->phone) · {{ $message->phone }}@endif</p>
                <p class="text-xs text-brand-ink/50 mt-1">{{ $message->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        @if($message->subject)
            <h3 class="font-extrabold mb-3 text-lg">{{ $message->subject }}</h3>
        @endif
        <div class="prose max-w-none">
            <p class="whitespace-pre-line leading-relaxed">{{ $message->message }}</p>
        </div>
    </div>

    <div class="flex gap-3">
        <a href="mailto:{{ $message->email }}" class="btn btn-primary">ردّ بالبريد</a>
        @if($message->phone)
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $message->phone) }}" target="_blank" class="btn bg-green-500 text-white hover:bg-green-600">واتساب</a>
        @endif
        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('حذف الرسالة؟')" class="mr-auto">
            @csrf @method('DELETE')
            <button class="btn btn-outline border-red-300 text-red-600 hover:bg-red-50">حذف</button>
        </form>
    </div>
</div>
@endsection

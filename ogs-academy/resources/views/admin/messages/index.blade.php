@extends('layouts.admin')
@section('title', 'رسائل التواصل')
@section('subtitle', 'الرسائل الواردة من صفحة التواصل')

@section('content')
<form method="GET" class="mb-6 max-w-md">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="بحث..." class="w-full rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-2 text-sm">
</form>

<div class="rounded-2xl bg-white border border-brand-gray divide-y divide-brand-gray">
    @forelse($messages as $m)
        <a href="{{ route('admin.messages.show', $m) }}" class="block p-5 hover:bg-brand-gray-2/50 transition {{ $m->is_read ? '' : 'bg-red-50/40' }}">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-brand-red text-white flex items-center justify-center font-bold shrink-0">{{ mb_substr($m->full_name,0,1) }}</div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-1">
                        <p class="font-bold truncate">{{ $m->full_name }}</p>
                        @if(!$m->is_read)
                            <span class="text-xs px-2 py-0.5 rounded-full bg-brand-red text-white font-bold">جديد</span>
                        @endif
                    </div>
                    <p class="text-sm text-brand-ink/60 truncate mb-1" dir="ltr">{{ $m->email }}</p>
                    @if($m->subject)
                        <p class="font-semibold text-sm mb-1">{{ $m->subject }}</p>
                    @endif
                    <p class="text-sm text-brand-ink/70 line-clamp-1">{{ $m->message }}</p>
                </div>
                <span class="text-xs text-brand-ink/50 whitespace-nowrap">{{ $m->created_at->diffForHumans() }}</span>
            </div>
        </a>
    @empty
        <div class="text-center py-12 text-brand-ink/50">لا توجد رسائل</div>
    @endforelse
</div>

<div class="mt-6">{{ $messages->links() }}</div>
@endsection

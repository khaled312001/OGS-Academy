@extends('layouts.admin')
@section('title', 'آراء العملاء')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-brand-ink/60">إجمالي: {{ $testimonials->total() }}</p>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">+ إضافة رأي</a>
</div>

<div class="grid md:grid-cols-2 gap-5">
    @foreach($testimonials as $t)
        <div class="p-6 rounded-2xl bg-white border border-brand-gray card-lift">
            <div class="flex text-brand-flame mb-3">
                @for($s=0;$s<$t->rating;$s++)<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 1.5l2.6 5.6 6.1.6-4.5 4 1.3 6L10 14.8 4.5 17.7l1.3-6L1.3 7.7l6.1-.6L10 1.5Z"/></svg>@endfor
            </div>
            <p class="text-sm text-brand-ink/80 leading-relaxed mb-4 line-clamp-3">"{{ $t->quote_ar }}"</p>
            <div class="flex items-center gap-3 pt-4 border-t border-brand-gray">
                <div class="w-10 h-10 rounded-full bg-brand-red text-white flex items-center justify-center font-bold">{{ mb_substr($t->author_name,0,1) }}</div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold truncate">{{ $t->author_name }}</p>
                    <p class="text-xs text-brand-ink/60 truncate">{{ trim(($t->author_title ?? '').($t->author_company ? ' · '.$t->author_company : '')) ?: '—' }}</p>
                </div>
                <div class="flex gap-1">
                    <a href="{{ route('admin.testimonials.edit', $t) }}" class="p-2 rounded-lg hover:bg-brand-gray-2 text-brand-red"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m16.86 4.49 2.65 2.65a1.5 1.5 0 0 1 0 2.12l-9.4 9.4a2 2 0 0 1-1.06.55l-3.85.66a.5.5 0 0 1-.58-.58l.66-3.85a2 2 0 0 1 .55-1.06l9.4-9.4a1.5 1.5 0 0 1 2.12 0Z"/></svg></a>
                    <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="p-2 rounded-lg hover:bg-red-50 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m14.74 9-.346 9m-4.788 0L9.26 9M5 6h14"/></svg></button></form>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="mt-6">{{ $testimonials->links() }}</div>
@endsection

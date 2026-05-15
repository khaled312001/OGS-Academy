@extends('layouts.admin')
@section('title', 'المقالات والأخبار')
@section('subtitle', 'إدارة المحتوى التحريري وقصص نجاحنا')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <form method="GET" class="flex flex-wrap gap-2 items-center">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="بحث..."
               class="rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-2 text-sm">
        <select name="category" class="rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-2 text-sm">
            <option value="">كل التصنيفات</option>
            @foreach($categories as $k => $v)
                <option value="{{ $k }}" @selected(request('category') === $k)>{{ $v }}</option>
            @endforeach
        </select>
        <select name="status" class="rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-2 text-sm">
            <option value="">الكل</option>
            <option value="published" @selected(request('status')==='published')>منشور</option>
            <option value="draft"     @selected(request('status')==='draft')>مسودة</option>
        </select>
        <button type="submit" class="btn btn-outline py-2 px-4 text-sm">تطبيق</button>
    </form>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14m-7-7h14"/></svg>
        مقال جديد
    </a>
</div>

<div class="rounded-2xl bg-white border border-brand-gray overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-gray-2 text-brand-ink/70 text-xs uppercase">
                <tr>
                    <th class="text-right px-5 py-4 font-bold">المقال</th>
                    <th class="text-right px-5 py-4 font-bold">التصنيف</th>
                    <th class="text-right px-5 py-4 font-bold">الكاتب</th>
                    <th class="text-right px-5 py-4 font-bold">مشاهدات</th>
                    <th class="text-right px-5 py-4 font-bold">الحالة</th>
                    <th class="text-right px-5 py-4 font-bold">التاريخ</th>
                    <th class="text-right px-5 py-4 font-bold"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-gray">
                @forelse($articles as $a)
                    <tr class="hover:bg-brand-gray-2/50">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $a->cover_url }}" class="w-14 h-10 rounded-lg object-cover bg-brand-gray-2">
                                <div>
                                    <p class="font-bold truncate max-w-xs">{{ $a->title_ar }}</p>
                                    @if($a->is_featured)
                                        <span class="text-xs inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full bg-brand-flame/10 text-brand-flame font-bold">⚡ مميَّز</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-brand-ink/70">{{ $a->category_label ?: '—' }}</td>
                        <td class="px-5 py-4 text-brand-ink/70">{{ $a->author?->name ?? '—' }}</td>
                        <td class="px-5 py-4">{{ number_format($a->views_count) }}</td>
                        <td class="px-5 py-4">
                            @if($a->is_published)
                                <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold">منشور</span>
                            @else
                                <span class="text-xs px-3 py-1 rounded-full bg-brand-gray-2 text-brand-ink/60 font-bold">مسودة</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-brand-ink/60 text-xs whitespace-nowrap">{{ $a->published_at?->diffForHumans() ?? $a->created_at->diffForHumans() }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('articles.show', $a->slug) }}" target="_blank" class="p-2 rounded-lg hover:bg-brand-gray-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 12s4-8 10-8 10 8 10 8-4 8-10 8S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg></a>
                                <a href="{{ route('admin.articles.edit', $a) }}" class="p-2 rounded-lg hover:bg-brand-gray-2 text-brand-red"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m16.86 4.49 2.65 2.65a1.5 1.5 0 0 1 0 2.12l-9.4 9.4a2 2 0 0 1-1.06.55l-3.85.66a.5.5 0 0 1-.58-.58l.66-3.85a2 2 0 0 1 .55-1.06l9.4-9.4a1.5 1.5 0 0 1 2.12 0Z"/></svg></a>
                                <form method="POST" action="{{ route('admin.articles.destroy', $a) }}" onsubmit="return confirm('حذف المقال؟')">@csrf @method('DELETE')<button class="p-2 rounded-lg hover:bg-red-50 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m14.74 9-.346 9m-4.788 0L9.26 9M5 6h14"/></svg></button></form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 text-brand-ink/50">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-brand-ink/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19 5v14H5V5h14m-5-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8l-5-5Z"/></svg>
                                <p>لا توجد مقالات بعد</p>
                                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary mt-2">إضافة مقال جديد</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $articles->links() }}</div>

@endsection

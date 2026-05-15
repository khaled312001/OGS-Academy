@extends('layouts.admin')
@section('title', 'البرامج التدريبية')
@section('subtitle', 'إدارة البرامج المعروضة على الموقع')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <form method="GET" class="flex flex-wrap gap-2 items-center">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="بحث..." class="rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-2 text-sm">
        <select name="category" class="rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-2 text-sm">
            <option value="">كل التصنيفات</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name_ar }}</option>
            @endforeach
        </select>
        <select name="status" class="rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-2 text-sm">
            <option value="">الكل</option>
            <option value="published" @selected(request('status')==='published')>منشور</option>
            <option value="draft"     @selected(request('status')==='draft')>مسودة</option>
        </select>
        <button type="submit" class="btn btn-outline py-2 px-4 text-sm">تطبيق</button>
    </form>
    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14m-7-7h14"/></svg>
        برنامج جديد
    </a>
</div>

<div class="rounded-2xl bg-white border border-brand-gray overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-gray-2 text-brand-ink/70 text-xs uppercase">
                <tr>
                    <th class="text-right px-5 py-4 font-bold">البرنامج</th>
                    <th class="text-right px-5 py-4 font-bold">التصنيف</th>
                    <th class="text-right px-5 py-4 font-bold">المدة</th>
                    <th class="text-right px-5 py-4 font-bold">المشاهدات</th>
                    <th class="text-right px-5 py-4 font-bold">الحالة</th>
                    <th class="text-right px-5 py-4 font-bold">إجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-gray">
                @forelse($programs as $p)
                    <tr class="hover:bg-brand-gray-2/50 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $p->thumbnail_url }}" alt="" class="w-12 h-12 rounded-xl object-cover bg-brand-gray-2">
                                <div>
                                    <p class="font-bold text-brand-ink truncate max-w-xs">{{ $p->title_ar }}</p>
                                    @if($p->is_featured)
                                        <span class="text-xs inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full bg-brand-flame/10 text-brand-flame font-bold">⚡ مميَّز</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-brand-ink/70">{{ $p->category?->name_ar ?? '—' }}</td>
                        <td class="px-5 py-4 text-brand-ink/70">{{ $p->duration_label ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-4 h-4 text-brand-ink/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2.04 12.32a1 1 0 0 1 0-.64C3.42 7.51 7.36 4.5 12 4.5s8.58 3.01 9.96 7.18a1 1 0 0 1 0 .64C20.58 16.49 16.64 19.5 12 19.5s-8.58-3.01-9.96-7.18Z"/><circle cx="12" cy="12" r="3"/></svg>
                                {{ number_format($p->views_count) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            @if($p->is_published)
                                <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold">منشور</span>
                            @else
                                <span class="text-xs px-3 py-1 rounded-full bg-brand-gray-2 text-brand-ink/60 font-bold">مسودة</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('programs.show', $p->slug) }}" target="_blank" class="p-2 rounded-lg hover:bg-brand-gray-2" title="معاينة"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2.04 12.32a1 1 0 0 1 0-.64C3.42 7.51 7.36 4.5 12 4.5s8.58 3.01 9.96 7.18a1 1 0 0 1 0 .64C20.58 16.49 16.64 19.5 12 19.5s-8.58-3.01-9.96-7.18Z"/><circle cx="12" cy="12" r="3"/></svg></a>
                                <a href="{{ route('admin.programs.edit', $p) }}" class="p-2 rounded-lg hover:bg-brand-gray-2 text-brand-red" title="تعديل"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.86 4.49 2.65 2.65a1.5 1.5 0 0 1 0 2.12l-9.4 9.4a2 2 0 0 1-1.06.55l-3.85.66a.5.5 0 0 1-.58-.58l.66-3.85a2 2 0 0 1 .55-1.06l9.4-9.4a1.5 1.5 0 0 1 2.12 0Z"/></svg></a>
                                <form method="POST" action="{{ route('admin.programs.destroy', $p) }}" onsubmit="return confirm('هل تريد حذف هذا البرنامج؟')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 rounded-lg hover:bg-red-50 hover:text-red-600" title="حذف"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-brand-ink/50">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-brand-ink/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 6.042A8.97 8.97 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                                <p>لا توجد برامج بعد</p>
                                <a href="{{ route('admin.programs.create') }}" class="btn btn-primary mt-2">إضافة برنامج جديد</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $programs->links() }}</div>

@endsection

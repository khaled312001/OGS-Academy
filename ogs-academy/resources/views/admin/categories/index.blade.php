@extends('layouts.admin')
@section('title', 'تصنيفات البرامج')
@section('subtitle', 'إدارة تصنيفات البرامج التدريبية')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-brand-ink/60">إجمالي: {{ $categories->total() }}</p>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14m-7-7h14"/></svg>
        تصنيف جديد
    </a>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach($categories as $cat)
        <div class="p-6 rounded-2xl bg-white border border-brand-gray hover:border-brand-red transition card-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg" style="background:{{ $cat->color ?? '#A01818' }}">
                    {{ mb_substr($cat->name_ar, 0, 1) }}
                </div>
                <span class="text-xs px-2 py-1 rounded-full {{ $cat->is_active ? 'bg-green-100 text-green-700' : 'bg-brand-gray-2 text-brand-ink/60' }}">{{ $cat->is_active ? 'نشط' : 'متوقف' }}</span>
            </div>
            <h3 class="font-extrabold text-lg mb-1">{{ $cat->name_ar }}</h3>
            <p class="text-xs text-brand-ink/50 mb-3" dir="ltr">{{ $cat->slug }}</p>
            <p class="text-sm text-brand-ink/70 line-clamp-2 mb-4 min-h-[2.5rem]">{{ $cat->description_ar }}</p>
            <div class="flex items-center justify-between pt-4 border-t border-brand-gray">
                <span class="text-xs text-brand-ink/60">{{ $cat->programs_count ?? 0 }} برنامج</span>
                <div class="flex gap-1">
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="p-2 rounded-lg hover:bg-brand-gray-2 text-brand-red"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m16.86 4.49 2.65 2.65a1.5 1.5 0 0 1 0 2.12l-9.4 9.4a2 2 0 0 1-1.06.55l-3.85.66a.5.5 0 0 1-.58-.58l.66-3.85a2 2 0 0 1 .55-1.06l9.4-9.4a1.5 1.5 0 0 1 2.12 0Z"/></svg></a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('حذف التصنيف؟')">
                        @csrf @method('DELETE')
                        <button class="p-2 rounded-lg hover:bg-red-50 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m14.74 9-.346 9m-4.788 0L9.26 9M5 6h14"/></svg></button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-6">{{ $categories->links() }}</div>
@endsection

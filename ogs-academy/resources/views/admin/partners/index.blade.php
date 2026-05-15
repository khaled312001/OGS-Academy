@extends('layouts.admin')
@section('title', 'الشركاء والجهات')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-brand-ink/60">إجمالي: {{ $partners->total() }}</p>
    <a href="{{ route('admin.partners.create') }}" class="btn btn-primary">+ شريك جديد</a>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    @foreach($partners as $p)
        <div class="p-5 rounded-2xl bg-white border border-brand-gray card-lift">
            <div class="aspect-[3/2] flex items-center justify-center bg-brand-gray-2 rounded-xl mb-4 p-3">
                <img src="{{ $p->logo_url }}" alt="" class="max-h-full max-w-full object-contain">
            </div>
            <p class="font-bold">{{ $p->name_ar }}</p>
            <p class="text-xs text-brand-ink/60 mb-3">{{ ['partner'=>'شريك','supervisor'=>'إشرافي','accredited'=>'اعتماد','sponsor'=>'راعي'][$p->type] ?? $p->type }}</p>
            <div class="flex items-center justify-between pt-3 border-t border-brand-gray">
                <span class="text-xs {{ $p->is_active ? 'text-green-600' : 'text-brand-ink/50' }}">{{ $p->is_active ? '● نشط' : '○ متوقف' }}</span>
                <div class="flex gap-1">
                    <a href="{{ route('admin.partners.edit', $p) }}" class="p-2 rounded-lg hover:bg-brand-gray-2 text-brand-red"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m16.86 4.49 2.65 2.65a1.5 1.5 0 0 1 0 2.12l-9.4 9.4a2 2 0 0 1-1.06.55l-3.85.66a.5.5 0 0 1-.58-.58l.66-3.85a2 2 0 0 1 .55-1.06l9.4-9.4a1.5 1.5 0 0 1 2.12 0Z"/></svg></a>
                    <form method="POST" action="{{ route('admin.partners.destroy', $p) }}" onsubmit="return confirm('حذف الشريك؟')">
                        @csrf @method('DELETE')
                        <button class="p-2 rounded-lg hover:bg-red-50 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m14.74 9-.346 9m-4.788 0L9.26 9M5 6h14"/></svg></button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-6">{{ $partners->links() }}</div>
@endsection

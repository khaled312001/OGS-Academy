@extends('layouts.admin')
@section('title', 'الإعدادات العامة')
@section('subtitle', 'كل ما يخص الموقع — اللوجو، الألوان، التواصل، الهيرو، الـ SEO')

@section('content')

<div class="flex flex-wrap gap-2 mb-6">
    @foreach($groups as $key => $label)
        <a href="{{ route('admin.settings.index', ['group' => $key]) }}"
           class="px-5 py-2.5 rounded-xl font-semibold text-sm transition {{ $activeGroup === $key ? 'bg-brand-red text-white shadow-brand' : 'bg-white border border-brand-gray text-brand-ink hover:border-brand-red hover:text-brand-red' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="max-w-4xl">
    @csrf
    <input type="hidden" name="group" value="{{ $activeGroup }}">

    <div class="rounded-2xl bg-white border border-brand-gray p-6 space-y-6">
        @forelse($items as $s)
            <div>
                <label class="block text-sm font-bold mb-2">
                    {{ $s->label_ar ?? $s->key }}
                    <span class="text-xs text-brand-ink/40 font-normal" dir="ltr">{{ $s->key }}</span>
                </label>

                @switch($s->type)
                    @case('text')
                        <textarea name="values[{{ $s->key }}]" rows="3" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ $s->value }}</textarea>
                        @break
                    @case('image')
                        <div class="flex items-start gap-4">
                            @if($s->value)
                                <div class="w-32 h-24 rounded-xl bg-brand-gray-2 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset('storage/'.$s->value) }}" class="max-w-full max-h-full object-contain">
                                </div>
                            @endif
                            <input type="file" name="files[{{ $s->key }}]" accept="image/*" class="flex-1 text-sm">
                        </div>
                        @break
                    @case('bool')
                        <label class="flex items-center justify-between p-4 rounded-xl bg-brand-gray-2 cursor-pointer">
                            <span>تفعيل</span>
                            <input type="checkbox" name="values[{{ $s->key }}]" value="1" @checked($s->value) class="rounded text-brand-red focus:ring-brand-red">
                        </label>
                        @break
                    @case('number')
                        <input type="number" name="values[{{ $s->key }}]" value="{{ $s->value }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                        @break
                    @default
                        @php $isLongText = mb_strlen((string) $s->value) > 80; @endphp
                        @if($isLongText)
                            <textarea name="values[{{ $s->key }}]" rows="3" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ $s->value }}</textarea>
                        @else
                            <input type="text" name="values[{{ $s->key }}]" value="{{ $s->value }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                        @endif
                @endswitch
                @if($s->hint)<p class="text-xs text-brand-ink/50 mt-1">{{ $s->hint }}</p>@endif
            </div>
        @empty
            <p class="text-brand-ink/50 text-center py-8">لا توجد إعدادات في هذا القسم</p>
        @endforelse

        @if($items->count())
            <div class="pt-4 border-t border-brand-gray">
                <button class="btn btn-primary">حفظ الإعدادات</button>
            </div>
        @endif
    </div>
</form>
@endsection

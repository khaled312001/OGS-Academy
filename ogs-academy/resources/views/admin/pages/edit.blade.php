@extends('layouts.admin')
@section('title', 'تحرير: ' . $config['title'])
@section('subtitle', $config['description'])

@section('content')

{{-- Top bar: breadcrumb + preview --}}
<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <nav class="text-sm text-brand-ink/60">
        <a href="{{ route('admin.pages.index') }}" class="hover:text-brand-red">الصفحات</a>
        <span class="mx-2">/</span>
        <span class="font-bold text-brand-ink">{{ $config['title'] }}</span>
    </nav>
    @if(! empty($config['preview_url']))
        <a href="{{ url($config['preview_url']) }}" target="_blank" rel="noopener" class="btn btn-outline !py-2 !px-4 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 12s4-8 10-8 10 8 10 8-4 8-10 8S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
            معاينة على الموقع
        </a>
    @endif
</div>

{{-- Note if page is dynamic (no editable sections) --}}
@if(empty($config['sections']) && empty($config['page_db_slug']))
    <div class="p-6 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900">
        <p class="font-bold mb-2">⚠️ هذه الصفحة لا تحتوي على حقول نصية قابلة للتحرير</p>
        @if(! empty($config['note']))
            <p class="text-sm leading-relaxed">{{ $config['note'] }}</p>
        @endif
        @if(! empty($config['cta_links']))
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($config['cta_links'] as $cta)
                    <a href="{{ route($cta['route']) }}" class="btn btn-primary !py-2 !px-4 text-sm">{{ $cta['label'] }}</a>
                @endforeach
            </div>
        @endif
    </div>
@else

<form method="POST" action="{{ route('admin.pages.update', $slug) }}" enctype="multipart/form-data" class="space-y-6">
    @csrf @method('PUT')

    <div class="grid lg:grid-cols-[1fr_320px] gap-6 items-start">

        {{-- ========== LEFT: SECTIONS ========== --}}
        <div class="space-y-6">
            {{-- Each section as an accordion --}}
            @foreach($config['sections'] as $sectionKey => $section)
                <div class="rounded-2xl bg-white border border-brand-gray overflow-hidden" x-data="{ open: true }">
                    <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between p-5 hover:bg-brand-gray-2/40 transition text-right">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-brand-red/10 text-brand-red flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            </span>
                            <div>
                                <h3 class="font-extrabold text-brand-ink">{{ $section['label'] }}</h3>
                                @if(! empty($section['description']))
                                    <p class="text-xs text-brand-ink/60 mt-0.5">{{ $section['description'] }}</p>
                                @endif
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-brand-ink/50 transition" :class="open && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m6 9 6 6 6-6"/></svg>
                    </button>

                    <div x-show="open" x-collapse class="px-5 pb-5 border-t border-brand-gray">
                        <div class="grid sm:grid-cols-2 gap-4 mt-5">
                            @foreach($section['fields'] as $field)
                                @php
                                    $key   = $field['key'];
                                    $type  = $field['type'] ?? 'text';
                                    $cols  = $field['cols'] ?? 1;
                                    $val   = $values[$key] ?? '';
                                    $dirAttr = isset($field['dir']) ? "dir=\"{$field['dir']}\"" : '';
                                @endphp

                                <div class="{{ $cols === 2 ? 'sm:col-span-1' : 'sm:col-span-2' }}">
                                    <label class="block text-sm font-bold mb-2 text-brand-ink">
                                        {{ $field['label'] }}
                                        <span class="text-xs text-brand-ink/40 font-normal mr-1" dir="ltr">{{ $key }}</span>
                                    </label>

                                    @switch($type)
                                        @case('textarea')
                                            <textarea name="values[{{ $key }}]" rows="{{ $field['rows'] ?? 3 }}" {!! $dirAttr !!}
                                                      placeholder="{{ $field['placeholder'] ?? '' }}"
                                                      class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3 text-sm">{{ $val }}</textarea>
                                            @break

                                        @case('number')
                                            <input type="number" name="values[{{ $key }}]" value="{{ $val }}"
                                                   placeholder="{{ $field['placeholder'] ?? '' }}"
                                                   class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                                            @break

                                        @case('image')
                                            <div class="rounded-xl bg-brand-gray-2 border border-dashed border-brand-gray p-4">
                                                @if($val)
                                                    <div class="flex items-center gap-4 mb-3">
                                                        <div class="w-24 h-16 rounded-lg overflow-hidden bg-white flex items-center justify-center shrink-0">
                                                            <img src="{{ asset('storage/'.$val) }}" alt="" class="max-w-full max-h-full object-contain">
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-xs font-bold text-brand-ink/70 mb-1">الصورة الحالية</p>
                                                            <p class="text-[10px] text-brand-ink/50 truncate" dir="ltr">{{ $val }}</p>
                                                            <label class="inline-flex items-center gap-1 text-xs text-red-600 hover:text-red-700 cursor-pointer mt-1">
                                                                <input type="checkbox" name="clear[{{ $key }}]" value="1" class="rounded text-red-600">
                                                                حذف الصورة
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                                <input type="file" name="files[{{ $key }}]" accept="image/*" class="w-full text-xs">
                                                <p class="text-[10px] text-brand-ink/50 mt-2">JPG, PNG, WebP — حد أقصى 4MB</p>
                                            </div>
                                            @break

                                        @default
                                            <input type="text" name="values[{{ $key }}]" value="{{ $val }}" {!! $dirAttr !!}
                                                   placeholder="{{ $field['placeholder'] ?? '' }}"
                                                   class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                                    @endswitch
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- About page extras: rich content + repeaters --}}
            @if(! empty($config['page_db_slug']) && $dbPage)
                {{-- Page-level fields --}}
                @if(! empty($config['page_fields']))
                    <div class="rounded-2xl bg-white border border-brand-gray overflow-hidden" x-data="{ open: true }">
                        <button type="button" @click="open = !open" class="w-full flex items-center justify-between p-5 hover:bg-brand-gray-2/40 transition text-right">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-xl bg-brand-red/10 text-brand-red flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M14 3v6h6M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9l-6-6Z"/></svg>
                                </span>
                                <div>
                                    <h3 class="font-extrabold text-brand-ink">المحتوى الرئيسي والرؤية</h3>
                                    <p class="text-xs text-brand-ink/60 mt-0.5">المحتوى التفصيلي، الرؤية، الرسالة</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-brand-ink/50 transition" :class="open && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="open" x-collapse class="px-5 pb-5 border-t border-brand-gray">
                            <div class="space-y-4 mt-5">
                                @foreach($config['page_fields'] as $field)
                                    @php
                                        $key = $field['key'];
                                        $val = ! empty($field['section_field'])
                                            ? ($dbPage->sections[$key] ?? '')
                                            : ($dbPage->{$key} ?? '');
                                    @endphp
                                    <div>
                                        <label class="block text-sm font-bold mb-2 text-brand-ink">{{ $field['label'] }}</label>
                                        <textarea name="page[{{ $key }}]" rows="{{ $field['rows'] ?? 4 }}"
                                                  class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3 text-sm @if(! empty($field['monospace'])) font-mono @endif">{{ $val }}</textarea>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Repeaters --}}
                @foreach($config['page_repeaters'] ?? [] as $repKey => $repConfig)
                    @php $repValues = $dbPage->sections[$repKey] ?? [['title_ar'=>'','desc_ar'=>'']]; @endphp
                    <div class="rounded-2xl bg-white border border-brand-gray overflow-hidden" x-data='{ open: true, items: @json($repValues), addItem() { this.items.push({title_ar:"",desc_ar:""}); }, removeItem(i) { this.items.splice(i, 1); } }'>
                        <button type="button" @click="open = !open" class="w-full flex items-center justify-between p-5 hover:bg-brand-gray-2/40 transition text-right">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-xl bg-brand-red/10 text-brand-red flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M11.48 3.5a.56.56 0 0 1 1.04 0l2.13 5.11a.56.56 0 0 0 .47.35l5.52.44c.5.04.7.66.32.99l-4.2 3.6a.56.56 0 0 0-.19.56l1.29 5.38a.56.56 0 0 1-.84.61L12 17.66a.56.56 0 0 0-.59 0l-4.72 2.88a.56.56 0 0 1-.84-.61l1.28-5.38a.56.56 0 0 0-.18-.56L2.74 10.4a.56.56 0 0 1 .32-.99l5.52-.44a.56.56 0 0 0 .47-.35Z"/></svg>
                                </span>
                                <div>
                                    <h3 class="font-extrabold text-brand-ink">{{ $repConfig['label'] }}</h3>
                                    <p class="text-xs text-brand-ink/60 mt-0.5">قائمة قابلة للإضافة والحذف</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-brand-ink/50 transition" :class="open && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m6 9 6 6 6-6"/></svg>
                        </button>

                        <div x-show="open" x-collapse class="px-5 pb-5 border-t border-brand-gray">
                            <div class="space-y-4 mt-5">
                                <template x-for="(item, i) in items" :key="i">
                                    <div class="p-4 rounded-xl border border-brand-gray bg-brand-gray-2/40 space-y-3 relative">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-brand-red">عنصر <span x-text="i+1"></span></span>
                                            <button type="button" @click="removeItem(i)" class="text-red-600 hover:bg-red-50 p-1 rounded text-xs">حذف</button>
                                        </div>
                                        @foreach($repConfig['fields'] as $rf)
                                            <div>
                                                <label class="block text-xs font-bold mb-1">{{ $rf['label'] }}</label>
                                                @if(($rf['type'] ?? 'text') === 'textarea')
                                                    <textarea :name="`repeater[{{ $repKey }}][${i}][{{ $rf['key'] }}]`" x-model="item.{{ $rf['key'] }}"
                                                              rows="{{ $rf['rows'] ?? 2 }}"
                                                              class="w-full rounded-lg bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-3 py-2 text-sm"></textarea>
                                                @else
                                                    <input type="text" :name="`repeater[{{ $repKey }}][${i}][{{ $rf['key'] }}]`" x-model="item.{{ $rf['key'] }}"
                                                           class="w-full rounded-lg bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-3 py-2 text-sm">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </template>
                            </div>
                            <button type="button" @click="addItem()" class="btn btn-outline w-full mt-4 !py-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14m-7-7h14"/></svg>
                                إضافة عنصر جديد
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- ========== RIGHT: SIDEBAR ========== --}}
        <aside class="space-y-5 lg:sticky lg:top-24 self-start">
            <div class="p-5 rounded-2xl bg-white border border-brand-gray">
                <h3 class="font-extrabold mb-3 flex items-center gap-2">
                    <span class="flame-bar"></span>
                    حفظ التعديلات
                </h3>
                <p class="text-xs text-brand-ink/60 mb-4 leading-relaxed">
                    التعديلات تظهر فوراً على الموقع بمجرد الحفظ. لا حاجة لخطوات إضافية.
                </p>
                <button type="submit" class="btn btn-primary w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                    حفظ كل التعديلات
                </button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline w-full mt-2 text-sm">إلغاء والرجوع</a>
            </div>

            @if(! empty($config['cta_links']))
                <div class="p-5 rounded-2xl bg-white border border-brand-gray">
                    <h3 class="font-extrabold mb-3 text-sm">روابط ذات صلة</h3>
                    <div class="space-y-1">
                        @foreach($config['cta_links'] as $cta)
                            <a href="{{ route($cta['route']) }}" class="flex items-center gap-2 text-sm text-brand-ink/70 hover:text-brand-red transition px-3 py-2 rounded-lg hover:bg-brand-gray-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M9 5l7 7-7 7"/></svg>
                                {{ $cta['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="p-5 rounded-2xl bg-blue-50 border border-blue-200 text-xs text-blue-900 leading-relaxed">
                <p class="font-bold mb-2 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/></svg>
                    معلومة
                </p>
                <p>كل حقل في هذه الصفحة مربوط بمفتاح إعدادات في قاعدة البيانات. التعديل يطبَّق على الموقع فوراً.</p>
            </div>
        </aside>

    </div>
</form>

@endif

@endsection

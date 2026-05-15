@extends('layouts.admin')
@section('title', 'طلبات التسجيل')
@section('subtitle', 'الاستفسارات الواردة من صفحات البرامج والتواصل')

@section('content')

{{-- ===== Top stat tabs ===== --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
    @php
        $tabs = [
            ['key'=>null,         'qkey'=>null,       'label'=>'الكل',           'val'=>$counts['all'],        'color'=>'bg-brand-ink/5 text-brand-ink',   'active'=>'bg-brand-black text-white'],
            ['key'=>'status',     'qkey'=>'new',      'label'=>'جديد',           'val'=>$counts['new'],        'color'=>'bg-blue-50 text-blue-700',         'active'=>'bg-blue-600 text-white'],
            ['key'=>'lead_type',  'qkey'=>'b2b',      'label'=>'مؤسسي (B2B)',   'val'=>$counts['b2b'],        'color'=>'bg-brand-red/10 text-brand-red',   'active'=>'bg-brand-red text-white'],
            ['key'=>'lead_type',  'qkey'=>'individual','label'=>'فردي',          'val'=>$counts['individual'], 'color'=>'bg-amber-50 text-amber-700',       'active'=>'bg-amber-600 text-white'],
        ];
    @endphp
    @foreach($tabs as $tab)
        @php
            $isActive = $tab['key']
                ? (request($tab['key']) === $tab['qkey'])
                : (! request('status') && ! request('lead_type'));
            $url = $tab['key']
                ? request()->fullUrlWithQuery([$tab['key'] => $tab['qkey'], 'status' => $tab['key'] === 'status' ? $tab['qkey'] : null, 'lead_type' => $tab['key'] === 'lead_type' ? $tab['qkey'] : null])
                : route('admin.inquiries.index');
        @endphp
        <a href="{{ $url }}"
           class="rounded-2xl p-4 transition card-lift {{ $isActive ? $tab['active'].' shadow-brand' : $tab['color'].' hover:opacity-80' }}">
            <p class="text-2xl font-extrabold">{{ number_format($tab['val']) }}</p>
            <p class="text-xs mt-1 opacity-90">{{ $tab['label'] }}</p>
        </a>
    @endforeach
</div>

{{-- ===== Filters + export ===== --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <form method="GET" class="flex flex-wrap gap-2 items-center">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="بحث بالاسم/البريد/الشركة..." class="rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-2 text-sm min-w-[200px]">
        <select name="status" class="rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-2 text-sm">
            <option value="">كل الحالات</option>
            @foreach(\App\Models\Inquiry::STATUSES as $k => $v)
                <option value="{{ $k }}" @selected(request('status')===$k)>{{ $v }}</option>
            @endforeach
        </select>
        <select name="lead_type" class="rounded-xl bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-2 text-sm">
            <option value="">كل العملاء</option>
            <option value="b2b"        @selected(request('lead_type')==='b2b')>مؤسسي فقط</option>
            <option value="individual" @selected(request('lead_type')==='individual')>فردي فقط</option>
        </select>
        <button type="submit" class="btn btn-outline py-2 px-4 text-sm">تصفية</button>
    </form>

    <a href="{{ route('admin.inquiries.export', request()->only(['status','lead_type','q'])) }}"
       class="btn btn-primary !py-2 !px-4 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
        تصدير CSV
    </a>
</div>

{{-- ===== Table ===== --}}
<div class="rounded-2xl bg-white border border-brand-gray overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-gray-2 text-brand-ink/70 text-xs uppercase">
                <tr>
                    <th class="text-right px-5 py-4 font-bold">العميل</th>
                    <th class="text-right px-5 py-4 font-bold">النوع</th>
                    <th class="text-right px-5 py-4 font-bold">الشركة</th>
                    <th class="text-right px-5 py-4 font-bold">البرنامج</th>
                    <th class="text-right px-5 py-4 font-bold">الحالة</th>
                    <th class="text-right px-5 py-4 font-bold">التاريخ</th>
                    <th class="text-right px-5 py-4 font-bold"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-gray">
                @forelse($inquiries as $iq)
                    @php $isB2B = ! empty(trim((string) $iq->company)); @endphp
                    <tr class="hover:bg-brand-gray-2/50 {{ $isB2B ? 'border-r-4 border-r-brand-red' : '' }}">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full {{ $isB2B ? 'bg-brand-red' : 'bg-brand-ink/60' }} text-white flex items-center justify-center font-bold shrink-0">{{ mb_substr($iq->full_name, 0, 1) }}</div>
                                <div class="min-w-0">
                                    <p class="font-bold truncate">{{ $iq->full_name }}</p>
                                    <p class="text-xs text-brand-ink/60 truncate" dir="ltr">{{ $iq->email }} · {{ $iq->phone }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @if($isB2B)
                                <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full bg-brand-red/10 text-brand-red font-bold">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M3 21V9l9-6 9 6v12"/></svg>
                                    مؤسسي
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 font-bold">فردي</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-brand-ink/70 truncate max-w-[180px]">
                            @if($isB2B)
                                <p class="font-semibold text-brand-ink truncate">{{ $iq->company }}</p>
                                @if($iq->job_title)<p class="text-xs text-brand-ink/60 truncate">{{ $iq->job_title }}</p>@endif
                            @else
                                <span class="text-brand-ink/40">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-brand-ink/70 truncate max-w-[200px]">{{ optional($iq->program)->title_ar ?? 'استفسار عام' }}</td>
                        <td class="px-5 py-4">
                            @php $bg = ['new'=>'bg-blue-100 text-blue-700','contacted'=>'bg-amber-100 text-amber-700','converted'=>'bg-green-100 text-green-700','closed'=>'bg-brand-gray-2 text-brand-ink/60'][$iq->status] ?? 'bg-brand-gray-2 text-brand-ink/60'; @endphp
                            <span class="text-xs px-3 py-1 rounded-full font-bold {{ $bg }}">{{ $iq->status_label }}</span>
                        </td>
                        <td class="px-5 py-4 text-brand-ink/60 text-xs whitespace-nowrap">{{ $iq->created_at->diffForHumans() }}</td>
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.inquiries.show', $iq) }}" class="text-xs px-3 py-1.5 rounded-full bg-brand-red text-white hover:bg-brand-red-700 transition">عرض</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-12 text-brand-ink/50">لا توجد طلبات</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $inquiries->links() }}</div>
@endsection

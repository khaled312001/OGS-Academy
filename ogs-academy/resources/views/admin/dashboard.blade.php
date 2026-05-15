@extends('layouts.admin')
@section('title', 'الرئيسية')
@section('subtitle', 'نظرة عامة على نشاط الموقع')

@section('content')

{{-- STATS GRID --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    @php
        $cards = [
            ['label' => 'البرامج المنشورة', 'val' => $stats['published'], 'total' => $stats['programs'],   'icon' => 'book', 'color' => '#A01818', 'route' => 'admin.programs.index'],
            ['label' => 'طلبات جديدة',      'val' => $stats['inquiries_new'], 'total' => $stats['inquiries_total'], 'icon' => 'inbox', 'color' => '#E30613', 'route' => 'admin.inquiries.index'],
            ['label' => 'رسائل غير مقروءة', 'val' => $stats['messages_unread'], 'total' => $stats['messages_total'], 'icon' => 'mail',  'color' => '#0A0A0A', 'route' => 'admin.messages.index'],
            ['label' => 'الشركاء',          'val' => $stats['partners'],  'total' => null,                'icon' => 'shake', 'color' => '#C9A876', 'route' => 'admin.partners.index'],
        ];
        $iconSvgs = [
            'book'  => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 6.042A8.97 8.97 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>',
            'inbox' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M3 13.125V6.375A3.375 3.375 0 0 1 6.375 3h11.25A3.375 3.375 0 0 1 21 6.375v6.75M3 13.125c0 .621.504 1.125 1.125 1.125h3.151c.464 0 .891.263 1.105.671l1.25 2.39c.213.408.64.671 1.104.671h3.13a1.25 1.25 0 0 0 1.104-.671l1.25-2.39c.213-.408.64-.671 1.104-.671h3.152c.621 0 1.125-.504 1.125-1.125M3 13.125V18a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.875"/></svg>',
            'mail'  => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l9 6 9-6M3 8v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8"/></svg>',
            'shake' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3"/></svg>',
        ];
    @endphp

    @foreach($cards as $i => $c)
        <a href="{{ route($c['route']) }}" class="card-lift block p-6 rounded-2xl bg-white border border-brand-gray hover:border-brand-red transition overflow-hidden relative">
            <div class="absolute -top-8 -left-8 w-24 h-24 rounded-full opacity-10" style="background:{{ $c['color'] }}"></div>
            <div class="relative">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white mb-4" style="background:{{ $c['color'] }}">
                    {!! $iconSvgs[$c['icon']] !!}
                </div>
                <p class="text-sm text-brand-ink/60 mb-1">{{ $c['label'] }}</p>
                <p class="text-3xl font-extrabold text-brand-ink">
                    {{ number_format($c['val']) }}
                    @if($c['total'] !== null)
                        <span class="text-sm text-brand-ink/40 font-normal">/ {{ number_format($c['total']) }}</span>
                    @endif
                </p>
            </div>
        </a>
    @endforeach
</div>

{{-- CHART + TOP --}}
<div class="grid lg:grid-cols-3 gap-5 mb-8">
    <div class="lg:col-span-2 p-6 rounded-2xl bg-white border border-brand-gray">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-extrabold">حركة الطلبات — آخر ٣٠ يوم</h3>
            <span class="text-xs px-3 py-1 rounded-full bg-brand-red/10 text-brand-red font-semibold">{{ array_sum($chartData->pluck('count')->all()) }} طلب</span>
        </div>
        <canvas id="inquiriesChart" height="100"></canvas>
    </div>

    <div class="p-6 rounded-2xl bg-white border border-brand-gray">
        <h3 class="font-extrabold mb-4">الأكثر مشاهدة</h3>
        <ul class="space-y-3 text-sm">
            @forelse($topPrograms as $p)
                <li class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-brand-red/10 text-brand-red font-bold flex items-center justify-center text-xs">{{ $loop->iteration }}</span>
                    <a href="{{ route('admin.programs.edit', $p) }}" class="flex-1 truncate hover:text-brand-red font-semibold">{{ $p->title_ar }}</a>
                    <span class="text-xs text-brand-ink/50">{{ $p->views_count }}</span>
                </li>
            @empty
                <li class="text-brand-ink/50">لا يوجد بيانات</li>
            @endforelse
        </ul>
    </div>
</div>

{{-- LATEST --}}
<div class="grid lg:grid-cols-2 gap-5">
    <div class="p-6 rounded-2xl bg-white border border-brand-gray">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-extrabold">أحدث طلبات التسجيل</h3>
            <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-brand-red hover:underline">عرض الكل ←</a>
        </div>
        <ul class="divide-y divide-brand-gray">
            @forelse($latestInquiries as $iq)
                <li class="py-3 flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-brand-red text-white flex items-center justify-center font-bold shrink-0">
                        {{ mb_substr($iq->full_name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold truncate">{{ $iq->full_name }}</p>
                        <p class="text-xs text-brand-ink/60 truncate">{{ $iq->company ?: '—' }} · {{ optional($iq->program)->title_ar ?? 'عام' }}</p>
                    </div>
                    <a href="{{ route('admin.inquiries.show', $iq) }}" class="text-xs px-3 py-1 rounded-full bg-brand-gray-2 hover:bg-brand-red hover:text-white transition">عرض</a>
                </li>
            @empty
                <li class="py-3 text-brand-ink/50 text-sm">لا توجد طلبات بعد</li>
            @endforelse
        </ul>
    </div>

    <div class="p-6 rounded-2xl bg-white border border-brand-gray">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-extrabold">أحدث الرسائل</h3>
            <a href="{{ route('admin.messages.index') }}" class="text-sm text-brand-red hover:underline">عرض الكل ←</a>
        </div>
        <ul class="divide-y divide-brand-gray">
            @forelse($latestMessages as $m)
                <li class="py-3 flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-brand-flame/10 text-brand-flame flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M3 8l9 6 9-6V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2Z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold truncate">{{ $m->full_name }}</p>
                        <p class="text-xs text-brand-ink/60 truncate">{{ $m->subject ?: \Illuminate\Support\Str::limit($m->message, 50) }}</p>
                    </div>
                    @if(!$m->is_read)
                        <span class="text-xs px-2 py-0.5 rounded-full bg-brand-red text-white">جديد</span>
                    @endif
                </li>
            @empty
                <li class="py-3 text-brand-ink/50 text-sm">لا توجد رسائل بعد</li>
            @endforelse
        </ul>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('inquiriesChart');
    if (!ctx) return;
    const data = @json($chartData);
    const grad = ctx.getContext('2d').createLinearGradient(0, 0, 0, 200);
    grad.addColorStop(0, 'rgba(160,24,24,0.35)');
    grad.addColorStop(1, 'rgba(160,24,24,0.02)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(d => d.date.slice(5)),
            datasets: [{
                label: 'طلبات',
                data: data.map(d => d.count),
                borderColor: '#A01818',
                backgroundColor: grad,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#E30613',
                pointRadius: 3,
                pointHoverRadius: 6,
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eee' } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush

@endsection

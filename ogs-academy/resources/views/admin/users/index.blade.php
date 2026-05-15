@extends('layouts.admin')
@section('title', 'المستخدمون')
@section('subtitle', 'إدارة مستخدمي لوحة التحكم')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-brand-ink/60">إجمالي: {{ $users->total() }}</p>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ مستخدم جديد</a>
</div>

<div class="rounded-2xl bg-white border border-brand-gray overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-gray-2 text-brand-ink/70 text-xs uppercase">
                <tr>
                    <th class="text-right px-5 py-4 font-bold">المستخدم</th>
                    <th class="text-right px-5 py-4 font-bold">الدور</th>
                    <th class="text-right px-5 py-4 font-bold">الحالة</th>
                    <th class="text-right px-5 py-4 font-bold">آخر دخول</th>
                    <th class="text-right px-5 py-4 font-bold"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-gray">
                @foreach($users as $u)
                    <tr class="hover:bg-brand-gray-2/50">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $u->avatar_url }}" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-bold">{{ $u->name }}</p>
                                    <p class="text-xs text-brand-ink/60" dir="ltr">{{ $u->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4"><span class="text-xs px-3 py-1 rounded-full bg-brand-red/10 text-brand-red font-bold">{{ ['superadmin'=>'سوبر أدمن','admin'=>'أدمن','editor'=>'محرر'][$u->role] ?? $u->role }}</span></td>
                        <td class="px-5 py-4"><span class="text-xs {{ $u->is_active ? 'text-green-600' : 'text-brand-ink/50' }}">{{ $u->is_active ? '● نشط' : '○ متوقف' }}</span></td>
                        <td class="px-5 py-4 text-brand-ink/60 text-xs">{{ $u->last_login_at?->diffForHumans() ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <div class="flex gap-1">
                                <a href="{{ route('admin.users.edit', $u) }}" class="p-2 rounded-lg hover:bg-brand-gray-2 text-brand-red"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="m16.86 4.49 2.65 2.65a1.5 1.5 0 0 1 0 2.12l-9.4 9.4a2 2 0 0 1-1.06.55l-3.85.66a.5.5 0 0 1-.58-.58l.66-3.85a2 2 0 0 1 .55-1.06l9.4-9.4a1.5 1.5 0 0 1 2.12 0Z"/></svg></a>
                                @if($u->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('حذف المستخدم؟')">@csrf @method('DELETE')<button class="p-2 rounded-lg hover:bg-red-50 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m14.74 9-.346 9m-4.788 0L9.26 9M5 6h14"/></svg></button></form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $users->links() }}</div>
@endsection

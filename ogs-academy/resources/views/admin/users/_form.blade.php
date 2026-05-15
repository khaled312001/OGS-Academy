@php $isEdit = isset($user); @endphp
<form method="POST" action="{{ $isEdit ? route('admin.users.update', $user) : route('admin.users.store') }}" class="max-w-2xl">
    @csrf @if($isEdit) @method('PUT') @endif
    <div class="p-6 rounded-2xl bg-white border border-brand-gray space-y-5">
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">الاسم <span class="text-brand-red">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">البريد <span class="text-brand-red">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required dir="ltr" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">الجوال</label>
                <input type="tel" name="phone" value="{{ old('phone', $user->phone ?? '') }}" dir="ltr" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">الدور <span class="text-brand-red">*</span></label>
                <select name="role" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                    @foreach(['superadmin'=>'سوبر أدمن','admin'=>'أدمن','editor'=>'محرر'] as $k=>$v)
                        <option value="{{ $k }}" @selected(old('role', $user->role ?? 'admin')===$k)>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">كلمة المرور {!! $isEdit ? '<span class="text-xs text-brand-ink/40">(اتركها فارغة للإبقاء)</span>' : '<span class="text-brand-red">*</span>' !!}</label>
                <input type="password" name="password" {{ $isEdit ? '' : 'required' }} class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
        </div>
        <label class="flex items-center justify-between p-4 rounded-xl bg-brand-gray-2 cursor-pointer">
            <span class="font-semibold">حساب نشط</span>
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active ?? true)) class="rounded text-brand-red focus:ring-brand-red">
        </label>
        <div class="flex gap-3 pt-3">
            <button class="btn btn-primary">{{ $isEdit ? 'حفظ' : 'إضافة' }}</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
    </div>
</form>

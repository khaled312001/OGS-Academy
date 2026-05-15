@php $isEdit = isset($partner); @endphp
<form method="POST" action="{{ $isEdit ? route('admin.partners.update', $partner) : route('admin.partners.store') }}" enctype="multipart/form-data" class="max-w-2xl">
    @csrf @if($isEdit) @method('PUT') @endif
    <div class="p-6 rounded-2xl bg-white border border-brand-gray space-y-5">
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">الاسم بالعربية <span class="text-brand-red">*</span></label>
                <input type="text" name="name_ar" value="{{ old('name_ar', $partner->name_ar ?? '') }}" required class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">الاسم بالإنجليزية</label>
                <input type="text" name="name_en" value="{{ old('name_en', $partner->name_en ?? '') }}" dir="ltr" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold mb-2">الشعار {!! $isEdit ? '' : '<span class="text-brand-red">*</span>' !!}</label>
            @if($isEdit && $partner->logo)
                <div class="aspect-[3/2] w-40 flex items-center justify-center bg-brand-gray-2 rounded-xl mb-2 p-3"><img src="{{ $partner->logo_url }}" class="max-h-full max-w-full object-contain"></div>
            @endif
            <input type="file" name="logo" accept="image/*" {{ $isEdit ? '' : 'required' }} class="w-full text-sm">
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">النوع</label>
                <select name="type" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                    @foreach(['supervisor' => 'جهة إشراف', 'partner' => 'شريك', 'accredited' => 'اعتماد', 'sponsor' => 'راعي'] as $k => $v)
                        <option value="{{ $k }}" @selected(old('type', $partner->type ?? 'partner')===$k)>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">الموقع الإلكتروني</label>
                <input type="url" name="website" value="{{ old('website', $partner->website ?? '') }}" dir="ltr" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">الترتيب</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $partner->sort_order ?? 0) }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
            <label class="flex items-center justify-between p-4 rounded-xl bg-brand-gray-2 cursor-pointer">
                <span class="font-semibold">نشط</span>
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $partner->is_active ?? true)) class="rounded text-brand-red focus:ring-brand-red">
            </label>
        </div>
        <div class="flex gap-3 pt-3">
            <button type="submit" class="btn btn-primary">{{ $isEdit ? 'حفظ' : 'إضافة' }}</button>
            <a href="{{ route('admin.partners.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
    </div>
</form>

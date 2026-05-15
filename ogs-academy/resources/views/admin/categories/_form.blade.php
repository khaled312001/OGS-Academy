@php $isEdit = isset($category); @endphp
<form method="POST" action="{{ $isEdit ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="max-w-2xl">
    @csrf @if($isEdit) @method('PUT') @endif

    <div class="p-6 rounded-2xl bg-white border border-brand-gray space-y-5">
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">الاسم بالعربية <span class="text-brand-red">*</span></label>
                <input type="text" name="name_ar" value="{{ old('name_ar', $category->name_ar ?? '') }}" required class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">الاسم بالإنجليزية</label>
                <input type="text" name="name_en" value="{{ old('name_en', $category->name_en ?? '') }}" dir="ltr" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold mb-2">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" dir="ltr" placeholder="auto" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
        </div>
        <div>
            <label class="block text-sm font-bold mb-2">الوصف</label>
            <textarea name="description_ar" rows="4" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ old('description_ar', $category->description_ar ?? '') }}</textarea>
        </div>
        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">اللون (HEX)</label>
                <input type="text" name="color" value="{{ old('color', $category->color ?? '#A01818') }}" dir="ltr" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">اسم الأيقونة</label>
                <input type="text" name="icon" value="{{ old('icon', $category->icon ?? '') }}" dir="ltr" placeholder="shield-check" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">الترتيب</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
        </div>
        <label class="flex items-center justify-between p-4 rounded-xl bg-brand-gray-2 cursor-pointer">
            <span class="font-semibold">تصنيف نشط</span>
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true)) class="rounded text-brand-red focus:ring-brand-red">
        </label>

        <div class="flex gap-3 pt-3">
            <button type="submit" class="btn btn-primary">{{ $isEdit ? 'حفظ التعديلات' : 'إضافة التصنيف' }}</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
    </div>
</form>

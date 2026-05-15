@php $isEdit = isset($testimonial); @endphp
<form method="POST" action="{{ $isEdit ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" enctype="multipart/form-data" class="max-w-2xl">
    @csrf @if($isEdit) @method('PUT') @endif
    <div class="p-6 rounded-2xl bg-white border border-brand-gray space-y-5">
        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">الاسم <span class="text-brand-red">*</span></label>
                <input type="text" name="author_name" value="{{ old('author_name', $testimonial->author_name ?? '') }}" required class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">المسمى الوظيفي</label>
                <input type="text" name="author_title" value="{{ old('author_title', $testimonial->author_title ?? '') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">الشركة</label>
                <input type="text" name="author_company" value="{{ old('author_company', $testimonial->author_company ?? '') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold mb-2">الصورة الشخصية</label>
            @if($isEdit && $testimonial->avatar)
                <img src="{{ $testimonial->avatar_url }}" class="w-20 h-20 rounded-full object-cover mb-2">
            @endif
            <input type="file" name="avatar" accept="image/*" class="w-full text-sm">
        </div>
        <div>
            <label class="block text-sm font-bold mb-2">الاقتباس <span class="text-brand-red">*</span></label>
            <textarea name="quote_ar" rows="4" required class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ old('quote_ar', $testimonial->quote_ar ?? '') }}</textarea>
        </div>
        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">التقييم</label>
                <select name="rating" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                    @for($r=5;$r>=1;$r--)<option value="{{ $r }}" @selected(old('rating', $testimonial->rating ?? 5)==$r)>{{ str_repeat('★',$r) }}</option>@endfor
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">الترتيب</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
            </div>
            <label class="flex items-center justify-between p-4 rounded-xl bg-brand-gray-2 cursor-pointer">
                <span class="font-semibold">نشط</span>
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial->is_active ?? true)) class="rounded text-brand-red focus:ring-brand-red">
            </label>
        </div>
        <div class="flex gap-3 pt-3">
            <button class="btn btn-primary">{{ $isEdit ? 'حفظ' : 'إضافة' }}</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
    </div>
</form>

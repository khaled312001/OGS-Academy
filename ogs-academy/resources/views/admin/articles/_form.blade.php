@php
    /** @var \App\Models\Article|null $article */
    $isEdit = isset($article);
    $action = $isEdit ? route('admin.articles.update', $article) : route('admin.articles.store');
@endphp
<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6">
    @csrf @if($isEdit) @method('PUT') @endif

    <div class="grid lg:grid-cols-[1fr_360px] gap-6">
        {{-- ===== LEFT ===== --}}
        <div class="space-y-6">
            <div class="p-6 rounded-2xl bg-white border border-brand-gray">
                <h3 class="font-extrabold mb-5 flex items-center gap-2"><span class="flame-bar"></span> العنوان والمحتوى</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">العنوان <span class="text-brand-red">*</span></label>
                        <input type="text" name="title_ar" value="{{ old('title_ar', $article?->title_ar) }}" required
                               class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3 text-lg font-bold">
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">العنوان بالإنجليزية</label>
                            <input type="text" name="title_en" value="{{ old('title_en', $article?->title_en ?? '') }}" dir="ltr"
                                   class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug', $article?->slug ?? '') }}" dir="ltr" placeholder="auto"
                                   class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">عنوان فرعي</label>
                        <input type="text" name="subtitle_ar" value="{{ old('subtitle_ar', $article?->subtitle_ar ?? '') }}"
                               class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">المقتطف (يظهر في القائمة)</label>
                        <textarea name="excerpt_ar" rows="2" maxlength="500"
                                  class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ old('excerpt_ar', $article?->excerpt_ar ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">المحتوى الكامل (HTML مسموح)</label>
                        <textarea name="content_ar" rows="16"
                                  class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3 font-mono text-sm">{{ old('content_ar', $article?->content_ar ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-brand-gray">
                <h3 class="font-extrabold mb-5 flex items-center gap-2"><span class="flame-bar"></span> الصورة الرئيسية</h3>
                @if($isEdit && $article->cover_image)
                    <img src="{{ $article->cover_url }}" class="w-full h-48 object-cover rounded-xl mb-3">
                @endif
                <input type="file" name="cover_image" accept="image/*" class="w-full text-sm">
            </div>

            <div class="p-6 rounded-2xl bg-white border border-brand-gray">
                <h3 class="font-extrabold mb-5 flex items-center gap-2"><span class="flame-bar"></span> SEO</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $article?->meta_title ?? '') }}"
                               class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2" maxlength="500"
                                  class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ old('meta_description', $article?->meta_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== RIGHT ===== --}}
        <aside class="space-y-6 lg:sticky lg:top-24 self-start">
            <div class="p-6 rounded-2xl bg-white border border-brand-gray">
                <h3 class="font-extrabold mb-4">النشر</h3>
                <label class="flex items-center justify-between p-3 rounded-xl bg-brand-gray-2 mb-3 cursor-pointer">
                    <span class="font-semibold">نشر المقال</span>
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $article?->is_published ?? true)) class="rounded text-brand-red focus:ring-brand-red">
                </label>
                <label class="flex items-center justify-between p-3 rounded-xl bg-brand-gray-2 mb-3 cursor-pointer">
                    <span class="font-semibold">مقال مميَّز</span>
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $article?->is_featured ?? false)) class="rounded text-brand-red focus:ring-brand-red">
                </label>
                <div class="mt-4">
                    <label class="block text-sm font-bold mb-2">تاريخ النشر</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', $article?->published_at?->format('Y-m-d\TH:i') ?? '') }}"
                           class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-2 text-sm">
                </div>
                <button type="submit" class="btn btn-primary w-full mt-5">{{ $isEdit ? 'حفظ التعديلات' : 'إنشاء المقال' }}</button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-outline w-full mt-2">إلغاء</a>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-brand-gray space-y-4">
                <h3 class="font-extrabold">التصنيف والوسوم</h3>
                <div>
                    <label class="block text-sm font-bold mb-2">التصنيف</label>
                    <select name="category" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                        <option value="">— بدون —</option>
                        @foreach($categories as $k => $v)
                            <option value="{{ $k }}" @selected(old('category', $article?->category) === $k)>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">الوسوم (مفصولة بفاصلة)</label>
                    <input type="text" name="tags" value="{{ old('tags', $article && $article->tags ? implode(', ', $article->tags) : '') }}" placeholder="تدريب, سلامة, صناعة"
                           class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">دقائق القراءة</label>
                    <input type="number" min="1" max="60" name="read_minutes" value="{{ old('read_minutes', $article?->read_minutes ?? '') }}"
                           class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3 text-sm">
                </div>
            </div>
        </aside>
    </div>
</form>

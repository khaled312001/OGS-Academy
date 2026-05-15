@php
    /** @var \App\Models\Program|null $program */
    $isEdit = isset($program);
    $action = $isEdit ? route('admin.programs.update', $program) : route('admin.programs.store');
    $modulesData = $isEdit ? $program->modules->toArray() : [];
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6" x-data="{
        modules: @js($modulesData ?: [['title_ar'=>'','description_ar'=>'','duration_hours'=>null]]),
        addModule() { this.modules.push({title_ar:'',description_ar:'',duration_hours:null}); },
        removeModule(i) { if(this.modules.length>1) this.modules.splice(i,1); }
    }">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="grid lg:grid-cols-[1fr_360px] gap-6">

        {{-- ===== LEFT: main content ===== --}}
        <div class="space-y-6">

            {{-- Basics --}}
            <div class="p-6 rounded-2xl bg-white border border-brand-gray">
                <h3 class="font-extrabold mb-5 flex items-center gap-2"><span class="flame-bar"></span> البيانات الأساسية</h3>
                <div class="space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">العنوان بالعربية <span class="text-brand-red">*</span></label>
                            <input type="text" name="title_ar" value="{{ old('title_ar', $program?->title_ar) }}" required class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">العنوان بالإنجليزية</label>
                            <input type="text" name="title_en" value="{{ old('title_en', $program?->title_en ?? '') }}" dir="ltr" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">عنوان فرعي / Subtitle</label>
                        <input type="text" name="subtitle_ar" value="{{ old('subtitle_ar', $program?->subtitle_ar ?? '') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">نبذة مختصرة (تظهر في كارد الكورس)</label>
                        <textarea name="summary_ar" rows="3" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ old('summary_ar', $program?->summary_ar ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">الوصف الكامل</label>
                        <textarea name="description_ar" rows="6" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ old('description_ar', $program?->description_ar ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Images --}}
            <div class="p-6 rounded-2xl bg-white border border-brand-gray">
                <h3 class="font-extrabold mb-5 flex items-center gap-2"><span class="flame-bar"></span> الصور والفيديو</h3>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold mb-2">الصورة الرئيسية (Cover)</label>
                        @if($isEdit && $program->cover_image)
                            <img src="{{ $program->cover_url }}" class="w-full h-32 object-cover rounded-xl mb-2">
                        @endif
                        <input type="file" name="cover_image" accept="image/*" class="w-full text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">الصورة المصغرة (Thumbnail)</label>
                        @if($isEdit && $program->thumbnail)
                            <img src="{{ $program->thumbnail_url }}" class="w-full h-32 object-cover rounded-xl mb-2">
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm">
                    </div>
                </div>
                <div class="mt-5">
                    <label class="block text-sm font-bold mb-2">رابط فيديو تعريفي (YouTube / Vimeo embed)</label>
                    <input type="url" name="intro_video_url" value="{{ old('intro_video_url', $program?->intro_video_url ?? '') }}" dir="ltr" placeholder="https://www.youtube.com/embed/..." class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                </div>
            </div>

            {{-- Outcomes / Prerequisites --}}
            <div class="p-6 rounded-2xl bg-white border border-brand-gray">
                <h3 class="font-extrabold mb-5 flex items-center gap-2"><span class="flame-bar"></span> مخرجات التعلم والمتطلبات</h3>
                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold mb-2">مخرجات التعلم (سطر لكل نقطة)</label>
                        <textarea name="outcomes_ar" rows="6" placeholder="مخرج 1&#10;مخرج 2&#10;..." class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ old('outcomes_ar', $isEdit ? implode("\n", (array) $program->outcomes_ar) : '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">المتطلبات المسبقة (سطر لكل نقطة)</label>
                        <textarea name="prerequisites_ar" rows="6" placeholder="متطلب 1&#10;متطلب 2" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ old('prerequisites_ar', $isEdit ? implode("\n", (array) $program->prerequisites_ar) : '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Modules --}}
            <div class="p-6 rounded-2xl bg-white border border-brand-gray">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-extrabold flex items-center gap-2"><span class="flame-bar"></span> محاور البرنامج</h3>
                    <button type="button" @click="addModule()" class="btn btn-outline py-2 px-4 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14m-7-7h14"/></svg>
                        محور جديد
                    </button>
                </div>
                <div class="space-y-4">
                    <template x-for="(m, i) in modules" :key="i">
                        <div class="p-4 rounded-xl border border-brand-gray bg-brand-gray-2 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-brand-red">محور <span x-text="i+1"></span></span>
                                <button type="button" @click="removeModule(i)" class="text-red-600 hover:bg-red-50 p-1 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M6 18 18 6M6 6l12 12"/></svg></button>
                            </div>
                            <div class="grid sm:grid-cols-[1fr_120px] gap-3">
                                <input :name="`modules[${i}][title_ar]`" x-model="m.title_ar" placeholder="عنوان المحور" class="rounded-lg bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-3 py-2 text-sm">
                                <input :name="`modules[${i}][duration_hours]`" type="number" min="0" x-model="m.duration_hours" placeholder="ساعات" class="rounded-lg bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-3 py-2 text-sm">
                            </div>
                            <textarea :name="`modules[${i}][description_ar]`" x-model="m.description_ar" rows="2" placeholder="وصف المحور (اختياري)" class="w-full rounded-lg bg-white border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-3 py-2 text-sm"></textarea>
                        </div>
                    </template>
                </div>
            </div>

            {{-- SEO --}}
            <div class="p-6 rounded-2xl bg-white border border-brand-gray">
                <h3 class="font-extrabold mb-5 flex items-center gap-2"><span class="flame-bar"></span> تحسين محركات البحث</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $program?->meta_title ?? '') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2" maxlength="500" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">{{ old('meta_description', $program?->meta_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== RIGHT: side controls ===== --}}
        <aside class="space-y-6 lg:sticky lg:top-24 self-start">
            <div class="p-6 rounded-2xl bg-white border border-brand-gray">
                <h3 class="font-extrabold mb-4">النشر</h3>
                <label class="flex items-center justify-between p-3 rounded-xl bg-brand-gray-2 mb-3 cursor-pointer">
                    <span class="font-semibold">نشر البرنامج</span>
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $program?->is_published ?? true)) class="rounded text-brand-red focus:ring-brand-red">
                </label>
                <label class="flex items-center justify-between p-3 rounded-xl bg-brand-gray-2 mb-3 cursor-pointer">
                    <span class="font-semibold">برنامج مميَّز</span>
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $program?->is_featured ?? false)) class="rounded text-brand-red focus:ring-brand-red">
                </label>

                <button type="submit" class="btn btn-primary w-full mt-4">{{ $isEdit ? 'حفظ التعديلات' : 'إنشاء البرنامج' }}</button>
                <a href="{{ route('admin.programs.index') }}" class="btn btn-outline w-full mt-2">إلغاء</a>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-brand-gray space-y-4">
                <h3 class="font-extrabold">التصنيف والترتيب</h3>
                <div>
                    <label class="block text-sm font-bold mb-2">التصنيف</label>
                    <select name="category_id" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                        <option value="">— بدون —</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" @selected(old('category_id', $program?->category_id ?? null) == $c->id)>{{ $c->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">الترتيب</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $program?->sort_order ?? 0) }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $program?->slug ?? '') }}" dir="ltr" placeholder="auto" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3 text-sm">
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-brand-gray space-y-4">
                <h3 class="font-extrabold">تفاصيل البرنامج</h3>
                <div>
                    <label class="block text-sm font-bold mb-2">وصف المدة</label>
                    <input type="text" name="duration_label" value="{{ old('duration_label', $program?->duration_label ?? '') }}" placeholder="5 أيام · 30 ساعة" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold mb-2">ساعات</label>
                        <input type="number" name="duration_hours" value="{{ old('duration_hours', $program?->duration_hours ?? '') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2">المقاعد</label>
                        <input type="number" name="seats" value="{{ old('seats', $program?->seats ?? '') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">المستوى</label>
                    <input type="text" name="level" value="{{ old('level', $program?->level ?? '') }}" placeholder="مبتدئ / متوسط / متقدم" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">الفئة المستهدفة</label>
                    <input type="text" name="audience_ar" value="{{ old('audience_ar', $program?->audience_ar ?? '') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">نص التكلفة</label>
                    <input type="text" name="price_label" value="{{ old('price_label', $program?->price_label ?? 'حسب الطلب') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">السعر (اختياري)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $program?->price ?? '') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">نص الشهادة</label>
                    <input type="text" name="certificate_label" value="{{ old('certificate_label', $program?->certificate_label ?? '') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray focus:border-brand-red focus:ring focus:ring-brand-red/15 px-4 py-3">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold mb-2">يبدأ</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $program?->start_date?->format('Y-m-d') ?? '') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2">ينتهي</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $program?->end_date?->format('Y-m-d') ?? '') }}" class="w-full rounded-xl bg-brand-gray-2 border border-brand-gray px-3 py-2 text-sm">
                    </div>
                </div>
            </div>
        </aside>

    </div>
</form>

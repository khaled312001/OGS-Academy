<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('program_categories')->nullOnDelete();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->string('subtitle_ar')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->text('summary_ar')->nullable();
            $table->text('summary_en')->nullable();
            $table->longText('description_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('intro_video_url')->nullable();
            $table->string('duration_label')->nullable();   // e.g. "5 أيام · 30 ساعة"
            $table->unsignedInteger('duration_hours')->nullable();
            $table->string('level')->nullable();            // مبتدئ / متوسط / متقدم
            $table->string('language')->default('ar');
            $table->string('audience_ar')->nullable();      // الفئة المستهدفة
            $table->string('audience_en')->nullable();
            $table->json('outcomes_ar')->nullable();        // مخرجات التعلم
            $table->json('outcomes_en')->nullable();
            $table->json('prerequisites_ar')->nullable();
            $table->json('prerequisites_en')->nullable();
            $table->string('certificate_label')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('price_label')->nullable();
            $table->unsignedInteger('seats')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'is_featured']);
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};

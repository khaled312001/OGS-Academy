<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->string('subtitle_ar')->nullable();
            $table->text('excerpt_ar')->nullable();
            $table->longText('content_ar')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('category', 60)->nullable(); // news / insight / case-study / press
            $table->json('tags')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedInteger('read_minutes')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'published_at']);
            $table->index(['category', 'is_published']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

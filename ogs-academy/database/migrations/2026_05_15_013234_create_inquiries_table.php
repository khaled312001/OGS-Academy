<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('company')->nullable();
            $table->string('job_title')->nullable();
            $table->string('email');
            $table->string('phone', 32);
            $table->unsignedInteger('trainees_count')->nullable();
            $table->string('preferred_date')->nullable();
            $table->text('message')->nullable();
            $table->string('source')->nullable();   // program_page / contact_page / landing
            $table->string('status')->default('new'); // new / contacted / converted / closed
            $table->text('admin_notes')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('program_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};

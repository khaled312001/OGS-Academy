<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('company')->nullable()->after('phone');
            $table->string('job_title')->nullable()->after('company');
            $table->string('inquiry_type', 60)->default('general')->after('job_title');
            // general / training_request / partnership / press / other
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['company', 'job_title', 'inquiry_type']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            // ISO 639-1/BCP 47 code: vi, en, ja, zh-CN, pt-BR...
            $table->string('code', 20)->unique();
            // Name displayed to users in the language's native form.
            $table->string('name', 100);
            // Optional English name for administration and fallback displays.
            $table->string('name_en', 100)->nullable();
            // BCP 47 locale used by Laravel translations: vi-VN, en-US, ja-JP...
            $table->string('locale', 20)->unique();
            // Text direction: ltr for most languages, rtl for Arabic/Hebrew...
            $table->string('direction', 3)->default('ltr');
            $table->string('flag_icon')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};

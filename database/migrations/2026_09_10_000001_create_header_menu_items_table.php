<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('header_menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('icon')->nullable();
            $table->string('link_type')->default('route');
            $table->string('link_value')->nullable();
            $table->boolean('is_category')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('header_menu_item_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('header_menu_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->unique(['header_menu_item_id', 'language_id'], 'header_menu_translation_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('header_menu_item_translations');
        Schema::dropIfExists('header_menu_items');
    }
};

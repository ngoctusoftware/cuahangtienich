<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_benefits', function (Blueprint $table): void {
            $table->id();
            $table->string('icon')->default('fas fa-star');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('store_benefit_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('store_benefit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('description')->nullable();
            $table->unique(['store_benefit_id', 'language_id']);
        });

        $languageId = DB::table('languages')
            ->where('is_default', true)
            ->value('id') ?? DB::table('languages')->orderBy('id')->value('id');

        if (! $languageId) {
            return;
        }

        $benefits = [
            ['icon' => 'fas fa-shield-halved', 'title' => 'Hàng chính hãng', 'description' => 'An tâm chọn mua'],
            ['icon' => 'fas fa-truck-fast', 'title' => 'Giao hàng nhanh', 'description' => 'Toàn quốc mỗi ngày'],
            ['icon' => 'fas fa-arrows-rotate', 'title' => 'Đổi trả dễ dàng', 'description' => 'Hỗ trợ trong 7 ngày'],
            ['icon' => 'fas fa-headset', 'title' => 'Hỗ trợ tận tâm', 'description' => 'Luôn sẵn sàng 24/7'],
        ];

        foreach ($benefits as $sortOrder => $benefit) {
            $benefitId = DB::table('store_benefits')->insertGetId([
                'icon' => $benefit['icon'],
                'sort_order' => $sortOrder + 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('store_benefit_translations')->insert([
                'store_benefit_id' => $benefitId,
                'language_id' => $languageId,
                'title' => $benefit['title'],
                'description' => $benefit['description'],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('store_benefit_translations');
        Schema::dropIfExists('store_benefits');
    }
};

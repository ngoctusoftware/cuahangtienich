<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banner_translations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('banner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('cta_text')->nullable();
            $table->string('cta_link')->nullable();
            $table->timestamps();

            $table->unique(['banner_id', 'language_id']);
        });

        $defaultLanguageId = DB::table('languages')
            ->where('is_default', true)
            ->value('id') ?? DB::table('languages')->orderBy('id')->value('id');

        if (! $defaultLanguageId) {
            return;
        }

        DB::table('banners')->orderBy('id')->eachById(function (object $banner) use ($defaultLanguageId): void {
            DB::table('banner_translations')->insert([
                'banner_id' => $banner->id,
                'language_id' => $defaultLanguageId,
                'eyebrow' => $banner->eyebrow,
                'title' => $banner->title,
                'description' => $banner->description,
                'cta_text' => $banner->cta_text,
                'cta_link' => $banner->cta_link,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_translations');
    }
};

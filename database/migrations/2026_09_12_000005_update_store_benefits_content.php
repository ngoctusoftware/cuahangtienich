<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $languageId = DB::table('languages')
            ->where('is_default', true)
            ->value('id') ?? DB::table('languages')->orderBy('id')->value('id');

        if (! $languageId) {
            return;
        }

        $benefits = [
            1 => 'Sản phẩm chính hãng, cam kết chất lượng',
            2 => 'Giao hàng nhanh toàn quốc, kiểm tra trước khi thanh toán',
            3 => 'Hỗ trợ đổi trả trong 7 ngày',
            4 => 'Đa dạng phương thức thanh toán: COD, chuyển khoản, online',
            5 => 'Đội ngũ chăm sóc khách hàng 24/7',
        ];

        foreach ($benefits as $sortOrder => $title) {
            $benefitId = DB::table('store_benefits')
                ->where('sort_order', $sortOrder)
                ->value('id');

            if (! $benefitId) {
                $benefitId = DB::table('store_benefits')->insertGetId([
                    'icon' => 'fas fa-check-circle',
                    'sort_order' => $sortOrder,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('store_benefit_translations')->updateOrInsert(
                [
                    'store_benefit_id' => $benefitId,
                    'language_id' => $languageId,
                ],
                [
                    'title' => $title,
                    'description' => null,
                ],
            );
        }
    }

    public function down(): void
    {
        //
    }
};

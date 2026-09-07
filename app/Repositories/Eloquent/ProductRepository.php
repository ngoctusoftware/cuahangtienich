<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\Concerns\HandlesTaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    use HandlesTaggedCache;

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function findBySlug(string $slug, int $languageId): ?object
    {
        return $this->model
            ->whereHas('translations', fn ($q) => $q->where('slug', $slug)->where('language_id', $languageId))
            ->with(['translations', 'images', 'category.translations'])
            ->where('is_active', true)
            ->first();
    }

    // Dùng Redis cache (qua Cache facade, driver Redis cấu hình ở .env) để tăng tốc trang chủ
    public function getFeatured(int $languageId, int $limit = 8): Collection
    {
        return $this->rememberCollection(
            "products:featured:{$languageId}:{$limit}",
            fn () => $this->model->with('translations')
                ->where('is_featured', true)->where('is_active', true)
                ->latest()->limit($limit)->get()
        );
    }

    public function getBestseller(int $languageId, int $limit = 8): Collection
    {
        return $this->rememberCollection(
            "products:bestseller:{$languageId}:{$limit}",
            fn () => $this->model->with('translations')
                ->where('is_bestseller', true)->where('is_active', true)
                ->orderByDesc('sold_count')->limit($limit)->get()
        );
    }

    public function getNewest(int $languageId, int $limit = 8): Collection
    {
        return $this->rememberCollection(
            "products:newest:{$languageId}:{$limit}",
            fn () => $this->model->with('translations')
                ->where('is_active', true)
                ->latest()->limit($limit)->get()
        );
    }

    public function getByCategory(int $categoryId, int $languageId, int $perPage = 20)
    {
        return $this->model->with('translations')
            ->where('category_id', $categoryId)
            ->where('is_active', true)
            ->paginate($perPage);
    }

    /**
     * Lấy dữ liệu từ cache (tag 'products'), tự phục hồi nếu cache bị hỏng.
     *
     * Nguyên nhân của lỗi "__PHP_Incomplete_Class returned":
     * Redis lưu bản serialize() của Eloquent Collection. Nếu class model/namespace
     * thay đổi giữa lần ghi cache và lần đọc (deploy code mới, đổi tên class, v.v.)
     * hoặc composer autoload chưa được load đúng lúc unserialize, PHP không tái tạo
     * lại được object và trả về __PHP_Incomplete_Class thay vì Collection thật.
     *
     * Cách xử lý: đọc cache thủ công (không dùng remember()), kiểm tra kiểu dữ liệu.
     * Nếu sai kiểu -> coi như cache hỏng, xoá key và tính lại + ghi đè cache mới.
     */
    protected function rememberCollection(string $key, \Closure $callback, int $minutes = 30): Collection
    {
        $store = Cache::tags(['products']);

        try {
            $cached = $store->get($key);
        } catch (\Throwable $e) {
            $cached = null;
        }

        $isValid = $cached instanceof Collection && ! ($cached instanceof \__PHP_Incomplete_Class);

        if (! $isValid) {
            if ($cached !== null) {
                Log::warning("Cache hỏng cho key [{$key}], đang xoá và tính lại.", [
                    'type' => is_object($cached) ? get_class($cached) : gettype($cached),
                ]);
                $store->forget($key);
            }

            $fresh = $callback();
            $store->put($key, $fresh, now()->addMinutes($minutes));

            return $fresh;
        }

        return $cached;
    }
}
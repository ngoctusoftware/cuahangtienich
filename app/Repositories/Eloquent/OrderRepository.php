<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    // Dùng transaction để đảm bảo tạo đơn hàng + chi tiết đơn hàng toàn vẹn dữ liệu
    public function createWithItems(array $orderData, array $items)
    {
        return DB::transaction(function () use ($orderData, $items) {
            $order = $this->model->create($orderData);
            $order->items()->createMany($items);

            return $order->load('items');
        });
    }

    public function findByCode(string $code): ?object
    {
        return $this->model->with('items', 'payment')->where('order_code', $code)->first();
    }

    public function getByCustomer(int $customerId, int $perPage = 10)
    {
        return $this->model->where('customer_id', $customerId)->latest()->paginate($perPage);
    }

    public function updateStatus(int $orderId, string $status): bool
    {
        return (bool) $this->model->where('id', $orderId)->update(['status' => $status]);
    }
}

<?php

namespace App\Services;

use App\Jobs\SendOrderConfirmationEmail;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
        protected CartService $cartService,
    ) {
    }

    // Tạo đơn hàng từ giỏ hàng trong session + đẩy email xác nhận vào queue
    public function checkout(array $customerInfo, ?int $customerId = null): object
    {
        $cartItems = $this->cartService->all();
        $subtotal = $this->cartService->total();

        $order = $this->orderRepository->createWithItems(
            [
                'order_code'       => 'DH' . strtoupper(Str::random(8)),
                'customer_id'      => $customerId,
                'receiver_name'    => $customerInfo['name'],
                'receiver_phone'   => $customerInfo['phone'],
                'receiver_address' => $customerInfo['address'],
                'note'             => $customerInfo['note'] ?? null,
                'subtotal'         => $subtotal,
                'discount'         => $customerInfo['discount'] ?? 0,
                'shipping_fee'     => $customerInfo['shipping_fee'] ?? 0,
                'total'            => $subtotal + ($customerInfo['shipping_fee'] ?? 0) - ($customerInfo['discount'] ?? 0),
                'payment_method'   => $customerInfo['payment_method'] ?? 'cod',
            ],
            collect($cartItems)->map(fn ($item) => [
                'product_id'   => $item['product_id'],
                'product_name' => $item['name'],
                'price'        => $item['price'],
                'quantity'     => $item['quantity'],
                'line_total'   => $item['price'] * $item['quantity'],
            ])->toArray()
        );

        // Đưa việc gửi mail vào hàng đợi (Queue) để không làm chậm phản hồi cho khách
        SendOrderConfirmationEmail::dispatch($order);

        $this->cartService->clear();

        return $order;
    }

    public function updateStatus(int $orderId, string $status): bool
    {
        return $this->orderRepository->updateStatus($orderId, $status);
    }
}

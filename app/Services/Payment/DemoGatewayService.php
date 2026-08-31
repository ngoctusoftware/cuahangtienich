<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Cong thanh toan gia lap (demo) - dung khi chua co tai khoan
 * VNPay/Momo that. Cho phep test toan bo luong "thanh toan tu dong":
 * dat hang -> chuyen huong sang trang thanh toan gia lap -> xac nhan
 * -> he thong tu dong cap nhat trang thai don hang.
 */
class DemoGatewayService implements PaymentGatewayInterface
{
    public function createPaymentUrl(Order $order): string
    {
        return route('payment.demo.show', $order->code);
    }

    public function handleCallback(Request $request): bool
    {
        // Trong demo, coi nhu luon thanh cong khi nguoi dung bam "Xac nhan thanh toan"
        return $request->boolean('confirm', true);
    }

    public function fakeTransactionId(): string
    {
        return 'DEMO-'.strtoupper(Str::random(10));
    }
}

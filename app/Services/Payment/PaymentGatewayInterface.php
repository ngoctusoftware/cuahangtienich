<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    /**
     * Tra ve URL de redirect nguoi dung sang trang thanh toan cua cong.
     */
    public function createPaymentUrl(Order $order): string;

    /**
     * Xu ly callback/IPN tu cong thanh toan tra ve.
     * Tra ve true neu thanh toan thanh cong.
     */
    public function handleCallback(Request $request): bool;
}

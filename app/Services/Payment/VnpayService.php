<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Http\Request;

/**
 * Tich hop cong thanh toan VNPay (sandbox).
 * Can cau hinh trong .env:
 *   VNPAY_TMN_CODE=
 *   VNPAY_HASH_SECRET=
 *   VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
 *   VNPAY_RETURN_URL=${APP_URL}/payment/vnpay/return
 *
 * Neu chua co tai khoan merchant VNPay, dung DemoGatewayService de test
 * luong thanh toan tu dong ma khong can gateway that.
 */
class VnpayService implements PaymentGatewayInterface
{
    public function createPaymentUrl(Order $order): string
    {
        $vnpUrl = config('services.vnpay.url');
        $vnpTmnCode = config('services.vnpay.tmn_code');
        $vnpHashSecret = config('services.vnpay.hash_secret');
        $vnpReturnUrl = config('services.vnpay.return_url');

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnpTmnCode,
            'vnp_Amount' => (int) round($order->total_amount * 100),
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => now()->format('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => request()->ip(),
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => 'Thanh toan don hang '.$order->code,
            'vnp_OrderType' => 'other',
            'vnp_ReturnUrl' => $vnpReturnUrl,
            'vnp_TxnRef' => $order->code,
        ];

        ksort($inputData);
        $query = '';
        $hashData = '';
        foreach ($inputData as $key => $value) {
            $hashData .= ($hashData ? '&' : '').urlencode($key).'='.urlencode((string) $value);
            $query .= ($query ? '&' : '').urlencode($key).'='.urlencode((string) $value);
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnpHashSecret);

        return $vnpUrl.'?'.$query.'&vnp_SecureHash='.$secureHash;
    }

    public function handleCallback(Request $request): bool
    {
        $vnpHashSecret = config('services.vnpay.hash_secret');
        $data = $request->except('vnp_SecureHash', 'vnp_SecureHashType');
        ksort($data);

        $hashData = '';
        foreach ($data as $key => $value) {
            $hashData .= ($hashData ? '&' : '').urlencode($key).'='.urlencode((string) $value);
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnpHashSecret);

        if ($secureHash !== $request->input('vnp_SecureHash')) {
            return false;
        }

        return $request->input('vnp_ResponseCode') === '00';
    }
}

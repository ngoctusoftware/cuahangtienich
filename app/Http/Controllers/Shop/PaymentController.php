<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payment\DemoGatewayService;
use App\Services\Payment\VnpayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Trung gian dieu huong sang cong thanh toan tuong ung voi order->payment_method.
     */
    public function process(string $code): RedirectResponse
    {
        $order = Order::where('code', $code)->firstOrFail();

        // Neu da co cau hinh VNPay that thi dung VNPay, khong thi dung cong demo
        if ($order->payment_method === 'vnpay' && config('services.vnpay.tmn_code')) {
            $url = (new VnpayService)->createPaymentUrl($order);

            return redirect()->away($url);
        }

        // Momo / bank_transfer / vnpay (chua cau hinh) -> dung cong demo de co the chay thu ngay
        $url = (new DemoGatewayService)->createPaymentUrl($order);

        return redirect()->to($url);
    }

    public function showDemoGateway(string $code): View
    {
        $order = Order::where('code', $code)->firstOrFail();

        return view('shop.orders.pay-demo', compact('order'));
    }

    public function confirmDemoGateway(Request $request, string $code): RedirectResponse
    {
        $order = Order::where('code', $code)->firstOrFail();
        $gateway = new DemoGatewayService;
        $success = $gateway->handleCallback($request);

        DB::transaction(function () use ($order, $success, $gateway) {
            $payment = $order->payments()->latest()->first();

            if ($success) {
                $order->update(['payment_status' => Order::PAYMENT_PAID, 'status' => Order::STATUS_CONFIRMED]);
                $payment?->update([
                    'status' => Payment::STATUS_SUCCESS,
                    'transaction_id' => $gateway->fakeTransactionId(),
                    'paid_at' => now(),
                ]);
            } else {
                $payment?->update(['status' => Payment::STATUS_FAILED]);
            }
        });

        if ($success) {
            return redirect()->route('orders.success', $order->code)->with('success', 'Thanh toan thanh cong!');
        }

        return redirect()->route('payment.demo.show', $order->code)->with('error', 'Thanh toan that bai, vui long thu lai.');
    }

    /**
     * VNPay return URL - VNPay redirect trinh duyet khach ve day sau khi thanh toan.
     */
    public function vnpayReturn(Request $request): RedirectResponse
    {
        $service = new VnpayService;
        $success = $service->handleCallback($request);
        $code = $request->input('vnp_TxnRef');
        $order = Order::where('code', $code)->first();

        if (! $order) {
            abort(404);
        }

        DB::transaction(function () use ($order, $success, $request) {
            $payment = $order->payments()->latest()->first();

            if ($success) {
                $order->update(['payment_status' => Order::PAYMENT_PAID, 'status' => Order::STATUS_CONFIRMED]);
                $payment?->update([
                    'status' => Payment::STATUS_SUCCESS,
                    'transaction_id' => $request->input('vnp_TransactionNo'),
                    'gateway_response' => $request->all(),
                    'paid_at' => now(),
                ]);
            } else {
                $payment?->update(['status' => Payment::STATUS_FAILED, 'gateway_response' => $request->all()]);
            }
        });

        if ($success) {
            return redirect()->route('orders.success', $order->code)->with('success', 'Thanh toan VNPay thanh cong!');
        }

        return redirect()->route('cart.checkout')->with('error', 'Thanh toan VNPay that bai.');
    }
}

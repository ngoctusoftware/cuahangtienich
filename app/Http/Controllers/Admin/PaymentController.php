<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Payment::query()->with('order');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Cho phep admin xac nhan thu cong (vd: chuyen khoan ngan hang) khi can.
     */
    public function markPaid(Payment $payment): RedirectResponse
    {
        $payment->update(['status' => Payment::STATUS_SUCCESS, 'paid_at' => now()]);
        $payment->order->update(['payment_status' => Order::PAYMENT_PAID]);

        return back()->with('success', 'Da xac nhan thanh toan.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with('order')->latest()->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function updateStatus(Request $request, Payment $payment): RedirectResponse
    {
        $data = $request->validate(['status' => 'required|in:pending,paid,failed,refunded']);
        $payment->update($data);

        return back()->with('success', 'Đã cập nhật trạng thái thanh toán.');
    }
}

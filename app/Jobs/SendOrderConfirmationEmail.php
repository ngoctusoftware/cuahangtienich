<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

// Job chạy trong hàng đợi (Redis queue) để gửi email không chặn luồng request chính
class SendOrderConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(public Order $order)
    {
    }

    public function handle(): void
    {
        // Mail::to($this->order->receiver_email)->send(new OrderConfirmationMail($this->order));
        // (Thêm Mailable OrderConfirmationMail khi triển khai chi tiết ở bước sau)
    }
}

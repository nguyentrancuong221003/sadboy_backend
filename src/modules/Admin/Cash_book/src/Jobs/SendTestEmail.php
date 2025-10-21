<?php

namespace Modules\Admin\Cash_book\src\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
class SendTestEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $goodsReceipt;

    public function __construct($goodsReceipt)
    {
        $this->goodsReceipt = $goodsReceipt;
    }
    public function handle()
    {
        Log::info("Redis Queue hoạt động lúc: " . now() . " cho user: {$this->goodsReceipt}");
    }
}

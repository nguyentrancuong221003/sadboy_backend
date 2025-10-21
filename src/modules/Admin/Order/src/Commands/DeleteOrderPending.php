<?php

namespace Modules\Admin\Order\src\Commands;

use Illuminate\Console\Command;
use Modules\Admin\Order\src\Models\OrderPending;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class DeleteOrderPending extends Command
{
    protected $signature = 'delete:order-pending';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $time = Carbon::now()->subMinutes(10);

        $deletedCount = OrderPending::where('created_at', '<', $time)->delete();

        if ($deletedCount > 0) {
            Log::info("🧹 Đã xóa {$deletedCount} đơn hàng quá hạn 10 phút.");
            return true;
        }

        Log::info('Không có đơn hàng nào cần xóa.');
        return false;
    }
}

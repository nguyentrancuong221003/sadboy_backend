<?php

namespace Modules\Admin\Order\src\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Modules\Admin\Order\src\Models\OrderPending;
use Modules\Admin\Order\src\Models\Order;
use Modules\Admin\Order\src\Models\OrderSuccess;
use Modules\Admin\Product\src\Models\Product;
class HandleProfitOrder extends Command
{
    protected $signature = 'handle:order-profitable';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $profits = [];

        $orders = Order::with('detail')
            ->select('id', 'total', 'status', 'products')
            ->where('status', 'SUCCESS')
            ->get();

        // Lấy tất cả slug từ toàn bộ đơn hàng
        $allSlugs = $orders->flatMap(function ($order) {
            return collect(json_decode($order->products))->pluck('slug');
        })->unique();

        // Lấy toàn bộ product cần dùng trong 1 query duy nhất
        $products = Product::whereIn('slug', $allSlugs)->with('detail')->get()->keyBy('slug');

        foreach ($orders as $order) {
            $totalImportPrice = 0;

            foreach (json_decode($order->products) as $product) {
                $slug = $product->slug;
                $size = $product->size;

                // Lấy product từ bộ nhớ (collection), không cần query DB nữa
                $pro = $products[$slug] ?? null;

                if ($pro && $pro->detail) {
                    $importPrice = json_decode($pro->detail->import_price, true)[$size] ?? 0;
                    $totalImportPrice += $importPrice;
                }
            }

            $discount = (float) $order->detail->money_discount;
            $total = (float) $order->total;

            $profits[] = [
                'order_id' => $order->id,
                'total_import_price' => $totalImportPrice,
                'discount_price' => $discount,
                'total_sale_price' => $total,
                'total_profitable_price' => $total - $discount - $totalImportPrice,
            ];
        }

        foreach($profits as $profit) {
            OrderSuccess::create([
                'order_id' => $profit['order_id'],
                'total_import_price' => $profit['total_import_price'],
                'discount_price' => $profit['discount_price'],
                'total_sale_price' => $profit['total_sale_price'],
                'total_profitable_price' => $profit['total_profitable_price']
            ]);
        }
        
    }
}

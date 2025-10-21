<?php

namespace Modules\Admin\Order\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Order\src\Models\Order;
use Modules\Admin\Order\src\Models\OrderDetails;
class OrderDetailsSeeder extends Seeder
{

    public function run()
    {
        $orders = Order::all();
        foreach($orders as $order) {
            OrderDetails::factory()->create([
                'order_id' => $order->id,
                'subtotal' => $order->total
            ]);
        }
    }
}

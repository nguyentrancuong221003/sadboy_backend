<?php

namespace Modules\Admin\Order\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Order\src\Models\Order;
use Modules\Admin\Order\src\Models\OrderSuccess;
class OrderSuccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::where('status', 'success')->get();
        foreach($orders as $order) {
            OrderSuccess::factory()->create([
                'order_id' => $order->id
            ]);
        }
    }
}

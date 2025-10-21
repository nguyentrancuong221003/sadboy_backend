<?php

namespace Modules\Admin\Order\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Order\src\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()->count(70)->create();
    }
}

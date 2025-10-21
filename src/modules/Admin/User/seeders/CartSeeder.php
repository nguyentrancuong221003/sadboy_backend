<?php

namespace Modules\Admin\User\seeders;

use Illuminate\Database\Seeder;
use Modules\Client\Cart\src\Models\Cart;

class CartSeeder extends Seeder
{
    public function run()
    {
        Cart::factory()->count(80)->create();
    }
}

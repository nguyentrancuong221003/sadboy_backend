<?php

namespace Modules\Admin\Order\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Order\src\Models\OrderDetails;

class OrderDetailsFactory extends Factory
{
    protected $model = OrderDetails::class;
    public function definition()
    {
        return [
           'address' => $this->faker->address(),
           'pay' => 'HOMEPAY'
        ];
    }
}

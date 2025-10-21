<?php

namespace Modules\Admin\Order\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Order\src\Models\OrderSuccess;
use Modules\Admin\Order\src\Models\Order;
class OrderSuccessFactory extends Factory
{
    protected $model = OrderSuccess::class;

    public function definition()
    {
        
        return [
            'total_import_price' => $this->faker->numberBetween(1000000, 2000000),
            'discount_price' => 0,
            'total_sale_price' => $this->faker->numberBetween(9000000, 12000000),
            'total_profitable_price' => $this->faker->numberBetween(6000000, 8000000),
        ];
    }
}

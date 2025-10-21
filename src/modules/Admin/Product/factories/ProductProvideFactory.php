<?php

namespace Modules\Admin\Product\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Product\src\Models\ProductProvide;
class ProductProvideFactory extends Factory
{
    protected $model = ProductProvide::class;

    public function definition()
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 40),
            'provide_id' => $this->faker->numberBetween(1, 40)
        ];
    }
}

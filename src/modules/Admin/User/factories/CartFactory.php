<?php

namespace Modules\Admin\User\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Client\Cart\src\Models\Cart;
class CartFactory extends Factory
{

    protected $model = Cart::class;

    public function definition()
    {
        return [
            'code' => strtoupper('CAR' . $this->faker->unique()->numberBetween(1, 9999999)),
            'product_id' => $this->faker->numberBetween(1, 40),
            'user_id' => $this->faker->numberBetween(1, 40),
            'count' => $this->faker->numberBetween(1, 20),
            'size' => $this->faker->randomElement(['S', 'M', 'L'])
        ];
    }
}

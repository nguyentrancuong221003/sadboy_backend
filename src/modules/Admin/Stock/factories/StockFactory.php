<?php

namespace Modules\Admin\Stock\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Stock\src\Models\Stock;
use Illuminate\Support\Str;

class StockFactory extends Factory
{
   protected $model = Stock::class;

    public function definition()
    {
        return [
            'code' => 'CUS' . strtoupper(Str::random(8)), // mã khách hàng unique
            'address' => $this->faker->address(),
            'phone' => $this->faker->unique()->numerify('09########'),
            'email' => $this->faker->unique()->safeEmail(),

        ];
    }
}

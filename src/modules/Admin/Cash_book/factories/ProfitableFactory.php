<?php

namespace Modules\Admin\Cash_book\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Cash_book\src\Models\Profitable;
class ProfitableFactory extends Factory
{
    protected $model = Profitable::class;
    public function definition()
    {
        return [
            'code' => strtoupper('PRT' . $this->faker->unique()->numberBetween(1, 9999999)),
            'date' => $this->faker->date(),
            'money' => $this->faker->numberBetween(100000000, 9000000000),
            'description' => null
        ];
    }
}

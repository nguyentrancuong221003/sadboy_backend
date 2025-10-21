<?php

namespace Modules\Admin\Cash_book\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Cash_book\src\Models\ProvideOrderMonth;
class ProvideOrderMonthFactory extends Factory
{
    protected $model = ProvideOrderMonth::class;

    public function definition()
    {
        return [
            'code' => strtoupper('DETMON' . $this->faker->unique()->numberBetween(1, 999999)),
            'date' => $this->faker->date(),
            'count' => $this->faker->numberBetween(1, 100),
            'description' => null
        ];
    }
}

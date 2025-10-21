<?php

namespace Modules\Admin\Cash_book\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Cash_book\src\Models\DebtProvidesMonth;
class DebtProvideMonthFactory extends Factory
{
    protected $model = DebtProvidesMonth::class;

    public function definition()
    {
        return [
            'code' => strtoupper('DETMON' . $this->faker->unique()->numberBetween(1, 999999)),
            'date' => $this->faker->date(),
            'total' => $this->faker->numberBetween(5000000, 600000000),
            'description' => null
        ];
    }
}

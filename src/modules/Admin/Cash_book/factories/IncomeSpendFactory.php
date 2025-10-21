<?php

namespace Modules\Admin\Cash_book\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Cash_book\src\Models\IncomeSpend;
class IncomeSpendFactory extends Factory
{
    protected $model = IncomeSpend::class;
    public function definition()
    {
        return [
            'code' => strtoupper('INS' . $this->faker->unique()->numberBetween(1, 999999)),
            'date' => now(),
            'opening_balance' => $this->faker->numberBetween(70000000, 900000000),
            'money_in' => $this->faker->numberBetween(1000000, 9000000),
            'money_out' => $this->faker->numberBetween(500000, 6000000),
            'profitable' => $this->faker->numberBetween(6800000, 46000000),
            'profit_order' => $this->faker->numberBetween(200000, 16000000),
            'profit_vote' => $this->faker->numberBetween(300000, 6000000),
        ];
    }
}

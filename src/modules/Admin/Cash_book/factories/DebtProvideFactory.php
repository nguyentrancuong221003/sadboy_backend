<?php

namespace Modules\Admin\Cash_book\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Provide\src\Models\ProvideDetails;
use Modules\Admin\Cash_book\src\Models\DebtProvides;
class DebtProvideFactory extends Factory
{
    protected $model = DebtProvides::class;

    public function definition()
    {
        $totalDebt = ProvideDetails::sum('total_debt');
        return [
            'code' => strtoupper('DET' . $this->faker->unique()->numberBetween(1, 999999)),
            'date'   => now(),
            'initial_debt' => $totalDebt,
            'debt_arises' => 0,
            'debt_paid' => 0,
            'debt_final' => $totalDebt

        ];
    }
}

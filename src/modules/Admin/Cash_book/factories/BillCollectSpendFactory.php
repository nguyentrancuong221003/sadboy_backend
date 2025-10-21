<?php

namespace Modules\Admin\Cash_book\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Cash_book\src\Models\BillCollectSpend;
class BillCollectSpendFactory extends Factory
{
    protected $model = BillCollectSpend::class;

    public function definition()
    {
        return [
            'code' => strtoupper('DET' . $this->faker->unique()->numberBetween(1, 999999)),
            'type' => $this->faker->randomElement(['spend', 'collect']),
            'reason' => 'Phiếu thu tiền',
            'money' => $this->faker->numberBetween(500000, 5000000),
            'imgs' => json_encode([]),
            'object' => $this->faker->randomElement(['customer', 'provider', 'employee']),
            'name_object' => $this->faker->name(),
            'created_by' => $this->faker->name(),
            'updated_by' =>$this->faker->name(),
        ];
    }
}

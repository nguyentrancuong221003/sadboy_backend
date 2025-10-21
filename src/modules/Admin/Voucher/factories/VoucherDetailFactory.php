<?php

namespace Modules\Admin\Voucher\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Voucher\src\Models\VoucherDetails;
class VoucherDetailFactory extends Factory
{
    protected $model = VoucherDetails::class;
    public function definition()
    {
        return [
            'total_user' => $this->faker->numberBetween(50, 200),
            'count_use' => 0,
            'per_use' => $this->faker->numberBetween(1, 3),
            'order_price_smallest' => $this->faker->numberBetween(500000, 2000000),
            'user_apply' => $this->faker->randomElement(['VIP', 'GOLD', 'SILK', 'DIAMOND', 'NORMAL', 'NEW']),
            'category_id' => $this->faker->numberBetween(1, 5),
            'date_effect' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'date_end' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement(['ACTIVE', 'DELETE', 'EXPIRE']),
        ];
    }
}

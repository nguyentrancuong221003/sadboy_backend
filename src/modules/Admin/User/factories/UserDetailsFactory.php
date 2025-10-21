<?php

namespace Modules\Admin\User\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\User\src\Models\UserDetails;
class UserDetailsFactory extends Factory
{
    protected $model = UserDetails::class;

    public function definition()
    {
        return [
            'status' => 'active',
            'date_birth' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'date_create_account' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'money_spend' => $this->faker->numberBetween(1000000, 500000000),
            'type' => $this->faker->randomElement(['VIP', 'GOLD', 'SILK', 'DIAMOND', 'NORMAL', 'NEW']),
            'number_carts' => $this->faker->numberBetween(1, 50),
            'total_order' => $this->faker->numberBetween(1, 50),
            'total_order_cancel' => $this->faker->numberBetween(1, 50),
            'total_order_success' => $this->faker->numberBetween(1, 50),
            'comment_count' => $this->faker->numberBetween(1, 50),

        ];
    }
}

<?php

namespace Modules\Admin\Voucher\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Voucher\src\Models\UserVoucher;
class UserVoucherFactory extends Factory
{
    protected $model = UserVoucher::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 60),
            'voucher_id' => $this->faker->numberBetween(1, 40),
        ];
    }
}

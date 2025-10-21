<?php

namespace Modules\Admin\Voucher\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Voucher\src\Models\Voucher;
class VoucherFactory extends Factory
{
    protected $model = Voucher::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['percent', 'money']);

        $percent     = 0;
        $maxMoney    = 0;
        $moneyDiscount = 0;

        if ($type === 'percent') {
            $percent  = $this->faker->numberBetween(5, 50); // 5% - 50%
            $maxMoney = $this->faker->numberBetween(50000, 500000); // Giới hạn giảm
        } else {
            $moneyDiscount = $this->faker->numberBetween(20000, 500000); // Giảm trực tiếp
        }

        return [
            'code'           => strtoupper('VC' . $this->faker->unique()->numberBetween(1, 9999999)),
            'name'           => 'Mã giảm giá với nhiều ưu đãi cực khủng',
            'img'            => '/storage/images/img_voucher/img_voucher.webp',
            'type'           => $type,
            'percent'        => $percent,
            'max_money'      => $maxMoney,
            'money_discount' => $moneyDiscount,
        ];
    }
}

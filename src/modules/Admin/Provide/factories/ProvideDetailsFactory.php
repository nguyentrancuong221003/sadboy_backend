<?php

namespace Modules\Admin\Provide\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Provide\src\Models\ProvideDetails;
class ProvideDetailsFactory extends Factory
{
    protected $model = ProvideDetails::class;

    public function definition(): array
    {
        $totalOrder = $this->faker->numberBetween(10, 500);
        $returnOrder = $this->faker->numberBetween(0, intval($totalOrder / 10));
        $totalBuy = $this->faker->randomFloat(2, 10000000, 100000000);
        $totalDebt = $this->faker->randomFloat(2, 0, $totalBuy / 2);

        $banks = ['Vietcombank', 'Techcombank', 'MB Bank', 'BIDV', 'Agribank', 'ACB'];

        return [
            'total_order'   => $totalOrder,
            'return_order'  => $returnOrder,
            'total_buy'     => $totalBuy,
            'total_debt'    => $totalDebt,
            'bank'          => $this->faker->randomElement($banks),
            'account_name'  => $this->faker->name(),
            'account_phone' => $this->faker->phoneNumber(),
            'qr_img'        => '/storage/images/img_provide/qr_' . $this->faker->unique()->numberBetween(1, 40) . '.jpg',
        ];
    }
}

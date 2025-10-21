<?php

namespace Modules\Admin\Order\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Order\src\Models\OrderStatuses;
class OrderStatusesFactory extends Factory
{
    protected $model = OrderStatuses::class;
    public function definition()
    {
        $statuses = ['pending', 'confirmed', 'shipping', 'delivered', 'cancelled'];
        $locations = ['Kho Hà Nội', 'Kho Hồ Chí Minh', 'Trạm giao hàng Đà Nẵng', 'Trạm Bình Dương', null];

        return [
            'code'     => strtoupper('OS' . $this->faker->unique()->numberBetween(1000, 9999)),

            'status'   => $this->faker->randomElement($statuses),
            'location' => $this->faker->randomElement($locations),
            'note'     => $this->faker->sentence(10),
        ];
    }
}

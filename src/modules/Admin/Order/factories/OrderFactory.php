<?php

namespace Modules\Admin\Order\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Order\src\Models\Order;
use Modules\Admin\Product\src\Models\Product;
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        $sizes = ['S', 'M', 'L'];
        $products = Product::inRandomOrder()->take(rand(4, 7))->with('detail')->get();

        $orderProducts = [];
        $totalCount = 0;
        $totalPrice = 0;

        foreach ($products as $product) {
            $count = rand(1, 5); // số lượng mỗi sản phẩm
            $price = collect(json_decode($product->detail->sale_price, true))->random(); // lấy giá theo size
            $size = array_rand($sizes);

            $orderProducts[] = [
                'name'  => $product->name,
                'img'   => json_decode($product->imgs, true)[0],
                'slug' => $product->slug,
                'count' => $count,
                'size'  => $sizes[$size],
                'price' => $price
            ];

            $totalCount += $count;
            $totalPrice += $count * $price;
        }

        return [
            'code' => strtoupper($this->faker->bothify('ORD#######')),
            'name' => $this->faker->name(),
            'date_delivery' => $this->faker->dateTimeBetween('now', '+1 month'),
            'products' => json_encode($orderProducts),
            'status' => $this->faker->randomElement(['SUCCESS', 'LOCKING', 'SHIPPING', 'CANCEL', 'PENDING', 'RETURN', 'PAID']),
            'count' => $totalCount,
            'total' => $totalPrice,
            'user_id' => $this->faker->numberBetween(1, 60)
        ];
    }
}

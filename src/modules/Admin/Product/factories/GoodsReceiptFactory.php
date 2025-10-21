<?php
namespace Modules\Admin\Product\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Product\src\Models\GoodsReceipt;
use Modules\Admin\Provide\src\Models\ProductProvideSupply;

use function GuzzleHttp\json_decode;

class GoodsReceiptFactory extends Factory
{
    protected $model = GoodsReceipt::class;

    public function definition()
    {
        $sizes = ['S', 'M', 'L'];
        $productsSupply = ProductProvideSupply::inRandomOrder()->take(rand(5, 10))->get();
        $products = [];
        $totalCount = 0;
        $totalPrice = 0;

        foreach ($productsSupply as $product) {
            $count = rand(5, 25); // số lượng mỗi sản phẩm
            $price = json_decode($product->price, true); // lấy giá theo size
            $size = $sizes[array_rand($sizes)];

            $products[] = [
                'code' => $product->code,
                'name'  => $product->name,
                'img'   => $product->img,
                'size' => $size,
                'size' => [
                    $size => [
                        'price' => $price[$size],
                        'count' => $count
                    ]
                ],
                'subtotal' => $price[$size] * $count,
                'totalCount' => $count
            ];

            $totalCount += $count;
            $totalPrice += $price[$size] * $count;
        }


        return [
            'code' => strtoupper($this->faker->bothify('GORE#######')),
            'count' => $totalCount,
            'date_receive' => $this->faker->dateTimeBetween('now', '+1 month'),
            'discount' => 0,
            'subtotal' => $totalPrice,
            'total' => $totalPrice,
            'note' => null,
            'note_cancel' => null,
            'other_cost' => 0,
            'products' => json_encode($products, JSON_UNESCAPED_UNICODE),
            'status' => $this->faker->randomElement(['SUCCESS', 'SHIPPING', 'CANCEL', 'PENDING']),
            'employee_id' => $this->faker->numberBetween(1, 60),
            'stock_id' => $this->faker->numberBetween(1, 6),
            'provide_id' => $this->faker->numberBetween(1, 40),
        ];
    }
}

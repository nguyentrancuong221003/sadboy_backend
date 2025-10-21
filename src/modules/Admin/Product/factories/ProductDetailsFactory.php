<?php

namespace Modules\Admin\Product\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Product\src\Models\ProductDetails;
class ProductDetailsFactory extends Factory
{
    protected $model = ProductDetails::class;

    public function definition(): array
    {
        // giá trị cho các loại giá
        $importPrice = [
            'S' => $this->faker->numberBetween(10000, 20000),
            'M' => $this->faker->numberBetween(20001, 40000),
            'L' => $this->faker->numberBetween(40001, 60000),
        ];

        $originalPrice = [
            'S' => $importPrice['S'] + $this->faker->numberBetween(1000, 5000),
            'M' => $importPrice['M'] + $this->faker->numberBetween(1000, 5000),
            'L' => $importPrice['L'] + $this->faker->numberBetween(1000, 5000),
        ];

        $salePrice = [
            'S' => $originalPrice['S'] - $this->faker->numberBetween(500, 2000),
            'M' => $originalPrice['M'] - $this->faker->numberBetween(500, 2000),
            'L' => $originalPrice['L'] - $this->faker->numberBetween(500, 2000),
        ];

        return [
            'import_price'       => json_encode($importPrice, JSON_UNESCAPED_UNICODE),
            'original_price'     => json_encode($originalPrice, JSON_UNESCAPED_UNICODE),
            'sale_price'         => json_encode($salePrice, JSON_UNESCAPED_UNICODE),
            'count_comment'      => $this->faker->numberBetween(0, 200),
            'QR'                 => $this->faker->regexify('[A-Z0-9]{10}'),
            'proportion_discount'=> $this->faker->numberBetween(0, 50),
            'date_start_sale'    => $this->faker->dateTimeBetween('-1 month', 'now'),
            'date_end_sale'      => $this->faker->dateTimeBetween('now', '+1 month'),
            'count_stock'        => $this->faker->numberBetween(0, 500),
            'count_sale'         => $this->faker->numberBetween(0, 300),
            'status'             => $this->faker->randomElement(['ACTIVE', 'INACTIVE', 'OUT_OF_STOCK']),
            'unit'               => $this->faker->randomElement(['kg', 'gói', 'cái', 'thùng']),
            'created_by'         => 'Nguyễn Trần Cường',
            'updated_by'         => null,
        ];
    }
}

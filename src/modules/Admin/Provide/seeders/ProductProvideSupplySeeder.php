<?php

namespace Modules\Admin\Provide\seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Provide\src\Models\ProductProvideSupply;
class ProductProvideSupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ['code' => 'sad1', 'name' => 'Quả dưa hấu', 'img' => '/storage/images/img_provide_product/product_img-sgauaaaa.jpg'],
            ['code' => 'sad2', 'name' => 'Quả cam', 'img' => '/storage/images/img_provide_product/product_img-ssssss.jpg'],
            ['code' => 'sad3', 'name' => 'Quả lựu', 'img' => '/storage/images/img_provide_product/product_img-sss3.jpg'],
            ['code' => 'sad4', 'name' => 'Xúp lơ', 'img' => '/storage/images/img_provide_product/product_img-sss4.jpg'],
            ['code' => 'sad5', 'name' => 'Nho sữa', 'img' => '/storage/images/img_provide_product/product_img-sss5.jpg'],
            ['code' => 'sad6', 'name' => 'Táo đỏ', 'img' => '/storage/images/img_provide_product/product_img-sss6.png'],
            ['code' => 'sad7', 'name' => 'Chuối tiêu', 'img' => '/storage/images/img_provide_product/product_img-sss7.jpg'],
            ['code' => 'sad8', 'name' => 'Dâu tây', 'img' => '/storage/images/img_provide_product/product_img-sss8.jpg'],
            ['code' => 'sad9', 'name' => 'Mận hậu', 'img' => '/storage/images/img_provide_product/product_img-sss9.png'],
            ['code' => 'sad10', 'name' => 'Ổi xanh', 'img' => '/storage/images/img_provide_product/product_img-sss10.jpg'],
            ['code' => 'sad11', 'name' => 'Quả xoài', 'img' => '/storage/images/img_provide_product/product_img-sss11.jpg'],
            ['code' => 'sad12', 'name' => 'Dừa xiêm', 'img' => '/storage/images/img_provide_product/product_img-sss12.webp'],
            ['code' => 'sad13', 'name' => 'Na dai', 'img' => '/storage/images/img_provide_product/product_img-sss13.jpg'],
            ['code' => 'sad14', 'name' => 'Mít thái', 'img' => '/storage/images/img_provide_product/product_img-sss14.jpg'],
            ['code' => 'sad15', 'name' => 'Chôm chôm', 'img' => '/storage/images/img_provide_product/product_img-sss15.png'],
            ['code' => 'sad16', 'name' => 'Sầu riêng', 'img' => '/storage/images/img_provide_product/product_img-sss16.jpg'],
            ['code' => 'sad17', 'name' => 'Quả bưởi', 'img' => '/storage/images/img_provide_product/product_img-sss17.png'],
            ['code' => 'sad18', 'name' => 'Thanh long', 'img' => '/storage/images/img_provide_product/product_img-sss18.jpg'],
            ['code' => 'sad19', 'name' => 'Quả nhãn', 'img' => '/storage/images/img_provide_product/product_img-sss19.jpg'],
            ['code' => 'sad20', 'name' => 'Quả vải', 'img' => '/storage/images/img_provide_product/product_img-sss20.jpg'],
            ['code' => 'sad21', 'name' => 'Quả dứa', 'img' => '/storage/images/img_provide_product/product_img-sss21.jpg'],
            ['code' => 'sad22', 'name' => 'Quả đào', 'img' => '/storage/images/img_provide_product/product_img-sss22.jpg'],
            ['code' => 'sad23', 'name' => 'Quả mơ', 'img' => '/storage/images/img_provide_product/product_img-sss23.jpg'],
            ['code' => 'sad24', 'name' => 'Quả khế', 'img' => '/storage/images/img_provide_product/product_img-sss24.jpg'],
            ['code' => 'sad25', 'name' => 'Quả cà chua', 'img' => '/storage/images/img_provide_product/product_img-sss25.jpg'],
            ['code' => 'sad26', 'name' => 'Cà rốt', 'img' => '/storage/images/img_provide_product/product_img-sss26.jpg'],
            ['code' => 'sad27', 'name' => 'Khoai tây', 'img' => '/storage/images/img_provide_product/product_img-sss27.webp'],
            ['code' => 'sad28', 'name' => 'Khoai lang', 'img' => '/storage/images/img_provide_product/product_img-sss28.jpg'],
            ['code' => 'sad29', 'name' => 'Hành tây', 'img' => '/storage/images/img_provide_product/product_img-sss29.jpg'],
            ['code' => 'sad30', 'name' => 'Hành tím', 'img' => '/storage/images/img_provide_product/product_img-sss30.jpg'],
            ['code' => 'sad31', 'name' => 'Tỏi ta', 'img' => '/storage/images/img_provide_product/product_img-sss31.jpg'],
            ['code' => 'sad32', 'name' => 'Ớt hiểm', 'img' => '/storage/images/img_provide_product/product_img-sss32.png'],
            ['code' => 'sad33', 'name' => 'Quả bí đỏ', 'img' => '/storage/images/img_provide_product/product_img-sss33.jpg'],
            ['code' => 'sad34', 'name' => 'Quả bí xanh', 'img' => '/storage/images/img_provide_product/product_img-sss34.jpg'],
            ['code' => 'sad35', 'name' => 'Cải thảo', 'img' => '/storage/images/img_provide_product/product_img-sss35.webp'],
            ['code' => 'sad36', 'name' => 'Cải ngọt', 'img' => '/storage/images/img_provide_product/product_img-sss36.webp'],
            ['code' => 'sad37', 'name' => 'Rau muống', 'img' => '/storage/images/img_provide_product/product_img-sss37.jpg'],
            ['code' => 'sad38', 'name' => 'Rau ngót', 'img' => '/storage/images/img_provide_product/product_img-sss38.webp'],
            ['code' => 'sad39', 'name' => 'Rau mồng tơi', 'img' => '/storage/images/img_provide_product/product_img-sss39.jpg'],
            ['code' => 'sad40', 'name' => 'Rau cải cúc', 'img' => '/storage/images/img_provide_product/product_img-sss40.jpg'],
            ['code' => 'sad41', 'name' => 'Đậu bắp', 'img' => '/storage/images/img_provide_product/product_img-sss41.jpg'],
            ['code' => 'sad42', 'name' => 'Đậu que', 'img' => '/storage/images/img_provide_product/product_img-sss42.jpg'],
            ['code' => 'sad43', 'name' => 'Đậu phụ', 'img' => '/storage/images/img_provide_product/product_img-sss43.jpg'],
        ];

        foreach ($products as $product) {
            ProductProvideSupply::create([
                'code' => $product['code'],
                'name' => $product['name'],
                'img'  => $product['img'],
                'price'=> json_encode([
                    'S' => rand(5000, 20000),
                    'M' => rand(20000, 40000),
                    'L' => rand(40000, 60000),
                ], JSON_UNESCAPED_UNICODE),
                'provide_id' => rand(1, 40),
            ]);
        }
    }
}

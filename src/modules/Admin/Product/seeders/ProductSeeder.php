<?php

namespace Modules\Admin\Product\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Product\src\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'code' => 'product001',
                'name' => 'Quả dưa hấu',
                'slug' => 'qua-dua-hay-product001',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-1.jpg',
                    '/storage/images/img_product/product_img-1A.jpg',
                    '/storage/images/img_product/product_img-1B.jpg',
                    '/storage/images/img_product/product_img-1C.webp',
                    '/storage/images/img_product/product_img-1D.jpg',
                    '/storage/images/img_product/product_img-1E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2 ,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product002',
                'name' => 'Quả cam',
                'slug' => 'qua-cam-product002',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-2.jpg',
                    '/storage/images/img_product/product_img-2A.jpg',
                    '/storage/images/img_product/product_img-2B.jpg',
                    '/storage/images/img_product/product_img-2C.jpg',
                    '/storage/images/img_product/product_img-2D.jpg',
                    '/storage/images/img_product/product_img-2E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2 ,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product003',
                'name' => 'Nước ép lựu',
                'slug' => 'nuoc-ep-luu-product003',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-3.png',
                    '/storage/images/img_product/product_img-3A.jpg',
                    '/storage/images/img_product/product_img-3B.jpg',
                    '/storage/images/img_product/product_img-3C.jpg',
                    '/storage/images/img_product/product_img-3D.jpg',
                    '/storage/images/img_product/product_img-3E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3 ,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product004',
                'name' => 'Xuýp lơ',
                'slug' => 'xuyp-lo-product004',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-4.png',
                    '/storage/images/img_product/product_img-4A.jpg',
                    '/storage/images/img_product/product_img-4B.jpg',
                    '/storage/images/img_product/product_img-4C.jpg',
                    '/storage/images/img_product/product_img-4D.jpg',
                    '/storage/images/img_product/product_img-4E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 5,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product005',
                'name' => 'Bánh mỳ',
                'slug' => 'banh-my-product005',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-5.png',
                    '/storage/images/img_product/product_img-5A.jpg',
                    '/storage/images/img_product/product_img-5B.png',
                    '/storage/images/img_product/product_img-5C.jpg',
                    '/storage/images/img_product/product_img-5D.jpg',
                    '/storage/images/img_product/product_img-5E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 6 ,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product006',
                'name' => 'Nho sữa',
                'slug' => 'nho-sua-product006',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-6.png',
                    '/storage/images/img_product/product_img-6A.jpg',
                    '/storage/images/img_product/product_img-6B.png',
                    '/storage/images/img_product/product_img-6C.jpg',
                    '/storage/images/img_product/product_img-6D.jpg',
                    '/storage/images/img_product/product_img-6E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product007',
                'name' => 'Quả chuối',
                'slug' => 'qua-chuoi-product007',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-7.png',
                    '/storage/images/img_product/product_img-7A.webp',
                    '/storage/images/img_product/product_img-7B.webp',
                    '/storage/images/img_product/product_img-7C.jpg',
                    '/storage/images/img_product/product_img-7D.png',
                    '/storage/images/img_product/product_img-7E.png'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product008',
                'name' => 'Nước ép táo',
                'slug' => 'nuoc-ep-tao-product008',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-8.png',
                    '/storage/images/img_product/product_img-8A.jpg',
                    '/storage/images/img_product/product_img-8B.jpg',
                    '/storage/images/img_product/product_img-8C.jpg',
                    '/storage/images/img_product/product_img-8D.webp',
                    '/storage/images/img_product/product_img-8E.webp'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product009',
                'name' => 'Khoai tây chiên',
                'slug' => 'khoai-tay-chien-product009',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-9.png',
                    '/storage/images/img_product/product_img-9A.jpg',
                    '/storage/images/img_product/product_img-9B.jpg',
                    '/storage/images/img_product/product_img-9C.jpg',
                    '/storage/images/img_product/product_img-9D.jpg',
                    '/storage/images/img_product/product_img-9E.webp'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 6,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product010',
                'name' => 'Gà chiên giòn',
                'slug' => 'ga-chien-gion-product010',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-10.png',
                    '/storage/images/img_product/product_img-10A.jpg',
                    '/storage/images/img_product/product_img-10B.jpg',
                    '/storage/images/img_product/product_img-10C.jpg',
                    '/storage/images/img_product/product_img-10D.jpg',
                    '/storage/images/img_product/product_img-10E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 6,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product011',
                'name' => 'Bánh ngọt',
                'slug' => 'banh-ngot-product011',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-11.png',
                    '/storage/images/img_product/product_img-11A.jpg',
                    '/storage/images/img_product/product_img-11B.jpg',
                    '/storage/images/img_product/product_img-11C.jpg',
                    '/storage/images/img_product/product_img-11D.jpg',
                    '/storage/images/img_product/product_img-11E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 4,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product012',
                'name' => 'Nước ép dứa',
                'slug' => 'nuoc-ep-dua-product012',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-12.png',
                    '/storage/images/img_product/product_img-12A.jpg',
                    '/storage/images/img_product/product_img-12B.jpg',
                    '/storage/images/img_product/product_img-12C.jpg',
                    '/storage/images/img_product/product_img-12D.webp',
                    '/storage/images/img_product/product_img-12E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product013',
                'name' => 'Bắp cải',
                'slug' => 'bap-cai-product013',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-13.png',
                    '/storage/images/img_product/product_img-13A.jpg',
                    '/storage/images/img_product/product_img-13B.jpg',
                    '/storage/images/img_product/product_img-13C.webp',
                    '/storage/images/img_product/product_img-13D.jpg',
                    '/storage/images/img_product/product_img-13E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 5,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product014',
                'name' => 'Xu hào',
                'slug' => 'xu-hao-product014',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-14.png',
                    '/storage/images/img_product/product_img-14A.webp',
                    '/storage/images/img_product/product_img-14B.webp',
                    '/storage/images/img_product/product_img-14C.jpg',
                    '/storage/images/img_product/product_img-14D.jpg',
                    '/storage/images/img_product/product_img-14E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 5,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product015',
                'name' => 'Quả cà chua',
                'slug' => 'qua-ca-chua-product015',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-15.jpg',
                    '/storage/images/img_product/product_img-15A.jpg',
                    '/storage/images/img_product/product_img-15B.jpg',
                    '/storage/images/img_product/product_img-15C.jpg',
                    '/storage/images/img_product/product_img-15D.jpg',
                    '/storage/images/img_product/product_img-15E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 5,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product016',
                'name' => 'Nước ép nho',
                'slug' => 'nuoc-ep-nho-product006',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-16.png',
                    '/storage/images/img_product/product_img-16A.webp',
                    '/storage/images/img_product/product_img-16B.jpg',
                    '/storage/images/img_product/product_img-16C.jpg',
                    '/storage/images/img_product/product_img-16D.jpeg',
                    '/storage/images/img_product/product_img-16E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product017',
                'name' => 'Quả đào',
                'slug' => 'qua-dao-product017',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-17.png',
                    '/storage/images/img_product/product_img-17A.jpg',
                    '/storage/images/img_product/product_img-17B.webp',
                    '/storage/images/img_product/product_img-17C.jpg',
                    '/storage/images/img_product/product_img-17D.jpg',
                    '/storage/images/img_product/product_img-17E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product018',
                'name' => 'Quả táo',
                'slug' => 'qua-tao-product018',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-18.png',
                    '/storage/images/img_product/product_img-18A.jpg',
                    '/storage/images/img_product/product_img-18B.jpp',
                    '/storage/images/img_product/product_img-18C.jpg',
                    '/storage/images/img_product/product_img-18D.jpg',
                    '/storage/images/img_product/product_img-18E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product019',
                'name' => 'Nước ép dưa hấu',
                'slug' => 'nuoc-ep-dua-hau-product019',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-19.png',
                    '/storage/images/img_product/product_img-19A.webp',
                    '/storage/images/img_product/product_img-19B.webp',
                    '/storage/images/img_product/product_img-19C.jpg',
                    '/storage/images/img_product/product_img-19D.jpg',
                    '/storage/images/img_product/product_img-19E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product020',
                'name' => 'Quả dâu tây',
                'slug' => 'qua-dau-tay-product020',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-20.png',
                    '/storage/images/img_product/product_img-20A.jpg',
                    '/storage/images/img_product/product_img-20B.png',
                    '/storage/images/img_product/product_img-20C.jpg',
                    '/storage/images/img_product/product_img-20D.jpeg',
                    '/storage/images/img_product/product_img-20E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 1,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product021',
                'name' => 'Nước ép chuối',
                'slug' => 'nuoc-ep-chuoi-product021',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-21.png',
                    '/storage/images/img_product/product_img-21A.jpg',
                    '/storage/images/img_product/product_img-21B.jpg',
                    '/storage/images/img_product/product_img-21C.jpg',
                    '/storage/images/img_product/product_img-21D.jpg',
                    '/storage/images/img_product/product_img-21E.webp'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product022',
                'name' => 'Nước ép cherry',
                'slug' => 'nuoc-ep-chuoi-product022',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-22.png',
                    '/storage/images/img_product/product_img-22A.png',
                    '/storage/images/img_product/product_img-22B.jpg',
                    '/storage/images/img_product/product_img-22C.jpg',
                    '/storage/images/img_product/product_img-22D.png',
                    '/storage/images/img_product/product_img-22E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product023',
                'name' => 'Nước ép mận',
                'slug' => 'nuoc-ep-man-product023',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-23.png',
                    '/storage/images/img_product/product_img-23A.jpg',
                    '/storage/images/img_product/product_img-23B.jpg',
                    '/storage/images/img_product/product_img-23C.jpg',
                    '/storage/images/img_product/product_img-23D.jpg',
                    '/storage/images/img_product/product_img-23E.webp'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product024',
                'name' => 'Quả việt quất',
                'slug' => 'qua-viet-quat-product024',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-24.png',
                    '/storage/images/img_product/product_img-24A.jpg',
                    '/storage/images/img_product/product_img-24B.jpg',
                    '/storage/images/img_product/product_img-24C.jpg',
                    '/storage/images/img_product/product_img-24D.jpg',
                    '/storage/images/img_product/product_img-24E.webp'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product025',
                'name' => 'Nước ép đào',
                'slug' => 'nuoc-ep-dao-product025',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-25.png',
                    '/storage/images/img_product/product_img-25A.webp',
                    '/storage/images/img_product/product_img-25B.webp',
                    '/storage/images/img_product/product_img-25C.jpg',
                    '/storage/images/img_product/product_img-25D.jpg',
                    '/storage/images/img_product/product_img-25E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product026',
                'name' => 'Quả măng cụt',
                'slug' => 'qua-mang-cut-product026',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-26.png',
                    '/storage/images/img_product/product_img-26A.jpg',
                    '/storage/images/img_product/product_img-26B.jpg',
                    '/storage/images/img_product/product_img-26C.jpg',
                    '/storage/images/img_product/product_img-26D.jpg',
                    '/storage/images/img_product/product_img-26E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product027',
                'name' => 'Quả me',
                'slug' => 'qua-me-product027',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-27.png',
                    '/storage/images/img_product/product_img-27A.jpg',
                    '/storage/images/img_product/product_img-27B.webp',
                    '/storage/images/img_product/product_img-27C.jpg',
                    '/storage/images/img_product/product_img-27D.jpg',
                    '/storage/images/img_product/product_img-27E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product028',
                'name' => 'Quả hồng xiêm',
                'slug' => 'qua-hong-xiem-product028',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-28.png',
                    '/storage/images/img_product/product_img-28A.jpg',
                    '/storage/images/img_product/product_img-28B.jpg',
                    '/storage/images/img_product/product_img-28C.jpg',
                    '/storage/images/img_product/product_img-28D.jpg',
                    '/storage/images/img_product/product_img-28E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product029',
                'name' => 'Quả vú sữa',
                'slug' => 'qua-vu-sua-product029',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-29.png',
                    '/storage/images/img_product/product_img-29A.webp',
                    '/storage/images/img_product/product_img-29B.jpg',
                    '/storage/images/img_product/product_img-29C.jpg',
                    '/storage/images/img_product/product_img-29D.webp',
                    '/storage/images/img_product/product_img-29E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product030',
                'name' => 'Nước ép cà rốt',
                'slug' => 'nuoc-ep-ca-rot-product030',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-30.png',
                    '/storage/images/img_product/product_img-30A.webp',
                    '/storage/images/img_product/product_img-30B.jpg',
                    '/storage/images/img_product/product_img-30C.jpg',
                    '/storage/images/img_product/product_img-30D.jpeg',
                    '/storage/images/img_product/product_img-30E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product031',
                'name' => 'Quả chôm chôm',
                'slug' => 'qua-chom-chom-product031',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-31.png',
                    '/storage/images/img_product/product_img-31A.jpeg',
                    '/storage/images/img_product/product_img-31B.jpg',
                    '/storage/images/img_product/product_img-31C.jpg',
                    '/storage/images/img_product/product_img-31D.jpg',
                    '/storage/images/img_product/product_img-31E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product032',
                'name' => 'Quả roi đỏ',
                'slug' => 'qua-roi-do-product032',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-32.png',
                    '/storage/images/img_product/product_img-32A.jpg',
                    '/storage/images/img_product/product_img-32B.jpg',
                    '/storage/images/img_product/product_img-32C.webp',
                    '/storage/images/img_product/product_img-32D.webp',
                    '/storage/images/img_product/product_img-32E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product033',
                'name' => 'Quả sầu riêng',
                'slug' => 'qua-sau-rieng-product033',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-33.png',
                    '/storage/images/img_product/product_img-33A.jpg',
                    '/storage/images/img_product/product_img-33B.webp',
                    '/storage/images/img_product/product_img-33C.webp',
                    '/storage/images/img_product/product_img-33D.webp',
                    '/storage/images/img_product/product_img-33E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội'
            ],
            [
                'code' => 'product034',
                'name' => 'Quả kiwi',
                'slug' => 'qua-kiwi-product034',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-34.png',
                    '/storage/images/img_product/product_img-34A.jpg',
                    '/storage/images/img_product/product_img-34B.jpg',
                    '/storage/images/img_product/product_img-34C.jpg',
                    '/storage/images/img_product/product_img-34D.jpg',
                    '/storage/images/img_product/product_img-34E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product035',
                'name' => 'Quả bơ',
                'slug' => 'qua-bo-product035',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-35.png',
                    '/storage/images/img_product/product_img-35A.webp',
                    '/storage/images/img_product/product_img-35B.webp',
                    '/storage/images/img_product/product_img-35C.webp',
                    '/storage/images/img_product/product_img-35D.jpg',
                    '/storage/images/img_product/product_img-35E.webp'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product036',
                'name' => 'Hambuger',
                'slug' => 'hambuger-product036',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-36.png',
                    '/storage/images/img_product/product_img-36A.jpg',
                    '/storage/images/img_product/product_img-36B.jpg',
                    '/storage/images/img_product/product_img-36C.jpg',
                    '/storage/images/img_product/product_img-36D.webp',
                    '/storage/images/img_product/product_img-36E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 6,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product037',
                'name' => 'Nước ép ổi',
                'slug' => 'nuoc-ep-oi-product037',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-37.jpg',
                    '/storage/images/img_product/product_img-37A.jpg',
                    '/storage/images/img_product/product_img-37B.jpg',
                    '/storage/images/img_product/product_img-37C.webp',
                    '/storage/images/img_product/product_img-37D.jpg',
                    '/storage/images/img_product/product_img-37E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 3,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product038',
                'name' => 'Quả dừa',
                'slug' => 'qua-dua-product038',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-38.png',
                    '/storage/images/img_product/product_img-38A.webp',
                    '/storage/images/img_product/product_img-38B.jpg',
                    '/storage/images/img_product/product_img-38C.jpg',
                    '/storage/images/img_product/product_img-38D.jpg',
                    '/storage/images/img_product/product_img-38E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product039',
                'name' => 'Quả hồng táo',
                'slug' => 'qua-hong-tao-product039',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-39.jpg',
                    '/storage/images/img_product/product_img-39A.webp',
                    '/storage/images/img_product/product_img-39B.jpg',
                    '/storage/images/img_product/product_img-39C.jpg',
                    '/storage/images/img_product/product_img-39D.webp',
                    '/storage/images/img_product/product_img-39E.jpg'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ],
            [
                'code' => 'product040',
                'name' => 'Quả nho trái tim',
                'slug' => 'qua-nho-trai-tim-product040',
                'imgs'=> json_encode([
                    '/storage/images/img_product/product_img-40.jpg',
                    '/storage/images/img_product/product_img-40A.jpg',
                    '/storage/images/img_product/product_img-40B.jpg',
                    '/storage/images/img_product/product_img-40C.jpg',
                    '/storage/images/img_product/product_img-40D.jpg',
                    '/storage/images/img_product/product_img-40E.png'
                ], JSON_UNESCAPED_UNICODE),
                'category_id' => 2,
                'place' => 'Hà Nội',
                'gift' => 'yes'
            ]


        ];
        foreach ($products as $product) {
            Product::create([
                'code' => $product['code'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'imgs' => $product['imgs'],
                'interest' => rand(300, 1000),
                'provide_id' => rand(1, 40),
                'category_id' => $product['category_id'],
                'place' => $product['place'],
                'gift' => $product['gift'] ?? 'no'
             ]);
        }

    }
}

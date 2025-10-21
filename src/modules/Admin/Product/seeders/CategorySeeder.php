<?php

namespace Modules\Admin\Product\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Product\src\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['code' => 'All', 'name' => 'Tất cả' ],
            ['code' => 'Fruit', 'name' => 'Trái cây' ],
            ['code' => 'Fruit Juicy', 'name' => 'Nước ép trái cây' ],
            ['code' => 'Cake', 'name' => 'Bánh ngọt' ],
            ['code' => 'Vegetable', 'name' => 'Rau củ' ],
            ['code' => 'Fast Food', 'name' => 'Đồ ăn nhanh' ],

        ];

        foreach ($categories as $category) {
            Category::create([
                'code' => $category['code'],
                'name' => $category['name'],
            ]);
        }
    }
}

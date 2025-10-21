<?php

namespace Modules\Admin\Comment\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Comment\src\Models\Comment;
use Modules\Admin\Product\src\Models\Product;
class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        foreach ($products as $product) {
            // bình luận cha
            $parent = Comment::factory()->create([
                'content' => 'Sản phẩm ' . $product->name . ' thật sự rất tốt, mình rất hài lòng!',
                'product_id' => $product->id,
                'parent_id' => null,
            ]);

            // bình luận con
            Comment::factory()->count(2)->create([
                'content' => 'Mình đồng ý với nhận xét trên về ' . $product->name,
                'product_id' => $product->id,
                'parent_id' => $parent->id,
            ]);
        }
    }
}

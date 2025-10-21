<?php

namespace Modules\Admin\Chat\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Chat\src\Models\Message;
use Modules\Admin\Order\src\Models\Order;
use Modules\Admin\Product\src\Models\Product;
class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['text', 'order', 'product', 'image', 'video']);
        $order = Order::first();
        $product = Product::with('detail')->first();

        $content = null;
        $meta = null;
        $path= null;
        if($type === 'text') {
            $content='Tôi muốn hỏi về một số sản phẩm, bạn tư vấn giúp tôi nhé';
        }
        else if($type === 'order') {
            $meta = [
                'order_code' => $order->code,
                'count' => $order->count,
                'total' => $order->total,
                'products' => json_decode($order->products, true)

            ];
        }
        else if($type === 'product') {
            $salePrice = json_decode($product->detail->sale_price, true);
            $meta = [
                'img_product' => $product->imgs[0],
                'name_product' => $product->name,
                'price' => $salePrice['S'] ?? null
            ];
        }
        else if($type === 'image') {
            $path = '/storage/images/img_chat/product_img-2.jpg';
        }
        else if($type === 'video') {
            $path = '/storage/images/img_chat/chat1.mov';
        }
        return [
            'conversation_id' => $this->faker->numberBetween(1, 40),
            'sender_id' => $this->faker->numberBetween(1, 60),
            'sender_type' => $this->faker->randomElement(['user', 'admin']),
            'type' => $type,
            'content' => $content,
            'file_path' => $path,
            'meta_data' => json_encode($meta)
        ];
    }
}

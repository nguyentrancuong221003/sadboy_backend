<?php

namespace Modules\Client\Cart\src\Repositories;

use Modules\Client\Cart\src\Repositories\CartRepositoryInterface;
use App\Repositories\BaseRepository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\isEmpty;
use Modules\Client\Cart\src\Models\Cart;
class CartRepository extends BaseRepository implements CartRepositoryInterface {
    public function getModel()
    {
        return Cart::class;
    }

    public function getModelDetail(){
        return Cart::class;
    }

    public function getListCart($user_id, $page) {
        $host = env('APP_URL');
        $carts = $this->model::select('id', 'code', 'product_id', 'user_id', 'count', 'size')
            ->with([
                'product' => function($query) {
                    $query->select('id', 'code', 'name', 'imgs');
                }
            ])
            ->latest()
            ->where('user_id', $user_id)
            ->paginate(10);
        if ($carts->total() === 0) {
            return [];
        }
        $carts = $carts->getCollection()->map(function($cart) use($host) {
            return [
                'id' => $cart->id,
                'code' => $cart->code,
                'product' => [
                    'name' => $cart?->product?->name,
                    'img' => $host.json_decode($cart?->product?->imgs, true)[0]
                ],
                'price' => json_decode($cart?->product?->detail?->sale_price, true)[$cart->size] ??
                    json_decode($cart?->product?->detail?->original_price, true)[$cart->size],
                'count' => $cart->count,
                'size' => $cart->size
            ];
        });
        return $carts;
    }

    public function deleteCart($id) {
        $user=auth()->guard('user')->user();
        $cart = $this->model::find($id);
        if(!$cart) {
            throw new \Exception('Không tìm thấy sản phẩm hợp lệ để xoá.', 404);
        }
        $cart->delete();

    }

    public function addProductCart($data) {
        $user = auth()->guard('user')->user();
        $cart = $this->model->create([
            'code' => $data['code'],
            'product_id' => $data['product_id'],
            'user_id' => $user->id,
            'count' => $data['count'],
            'size' => $data['size']
        ]);
        if (!$cart) {
            throw new \Exception("Thêm sản phẩm vào giỏ hàng không thành công", 400);
        }
        $host = env('APP_URL');
        $data = [
            'id' => $cart->id,
            'code' => $cart->code,
            'product' => [
                'name' => $cart?->product?->name,
                'img' => $host.json_decode($cart?->product?->imgs, true)[0]
            ],
            'price' => json_decode($cart?->product?->detail?->sale_price, true)[$cart->size] ??
                json_decode($cart?->product?->detail?->original_price, true)[$cart->size],
            'count' => $cart->count,
            'size' => $cart->size
        ];

        return $data;
    }
}

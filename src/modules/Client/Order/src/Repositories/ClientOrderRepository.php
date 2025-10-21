<?php

namespace Modules\Client\Order\src\Repositories;

use Modules\Client\Order\src\Repositories\ClientOrderRepositoryInterface;
use App\Repositories\BaseRepository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\isEmpty;
use Modules\Admin\Order\src\Models\Order;
use Modules\Admin\Voucher\src\Models\VoucherUsages;
use Illuminate\Support\Str;
use Modules\Admin\Voucher\src\Models\Voucher;
use Modules\Admin\Order\src\Models\OrderPending;
class ClientOrderRepository extends BaseRepository implements ClientOrderRepositoryInterface {
    public function getModel()
    {
        return Order::class;
    }

    public function getModelDetail(){
        return Order::class;
    }

    public function getDetailBase($order) {
        $host =  env('APP_URL');
        $data = [
            'id' => $order->id,
            'code' => $order->code,
            'name' => $order->name,
            'created_at' => Carbon::parse($order->created_at)->format('Y-m-d H:i:s'),
            'date_delivery' => $order->date_delivery,
            'pay' => $order->detail->pay,
            'discount_code' => $order->detail->discount_code,
            'status' => $order->status,
            'unit_shipping' => $order->detail->unit_shipping,
            'note' => $order->detail->note,
            'note_cancel' => $order->detail->note_cancel,
            'products' => collect(json_decode($order->products, true))->map(function($product) use($host) {
                return [
                    'name' => $product['name'],
                    'img' => $host.$product['img'],
                    'count' => $product['count'],
                    'size' => $product['size'],
                    'price' => $product['price']
                ];
            })->toArray(),
            'count' => $order->count,
            'address' => str_replace("\n", ' ', $order->detail->address),
            'subtotal' => number_format($order->detail->subtotal, 0, '.', ''),
            'money_discount' => number_format($order->detail->money_discount, 0, '.', ''),
            'money_ship' => number_format($order->detail->money_ship, 0, '.', ''),
            'total' => number_format($order->total, 0, '.', ''),

        ];
        return $data;
    }

    public function createOrder($data) {

        return DB::transaction(function () use ($data) {

            $user=auth()->guard('user')->user();

            $products = collect($data['products'])->map(function($product) {
                return [
                    'name' => $product['product']['name'],
                    'img' => Str::replace('http://localhost:8000', '', $product['product']['img']),
                    'size' => $product['size'],
                    'count' => $product['count'],
                    'price' => $product['price']
                ];
            });

            $order = $this->model->create([
                'code' => $data['code'],
                'name' => $data['name'],
                'date_delivery' => $data['date_delivery'],
                'products' => $products,
                'status' => 'PENDING',
                'count' => $data['count'],
                'total' => $data['total'],
                'user_id' => $user->id,

            ]);

            $orderDetail = $order->detail()->create([
                'order_id' => $order->id,
                'address' => $data['address'],
                'pay' => $data['pay'],
                'discount_code' => $data['discount_code'] ?? NULL,
                'unit_shipping' => $data['unit_shipping'] ?? NULL,
                'note' => $data['note'] ?? NULL,
                'subtotal' => $data['subtotal'],
                'money_discount' => $data['money_discount'],
                'money_ship' => $data['money_ship'],

            ]);

            if (!$order || !$orderDetail) {
                throw new \Exception("Thêm sản phẩm không thành công", 400);
            }

            if(!empty($data['discount_code'])) {
                VoucherUsages::create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'voucher_code' => $data['discount_code']
                ]);
            }

            $data = $this->getDetailBase($order);

            return $data;

        });
    }

    public function createOrderPending($data) {

        return DB::transaction(function () use ($data) {
            $host = env('APP_URL');
            $order_key = "order_pending_$data[code]";

            $order = Cache::tags(['orders_pending', "order_pending_code_$data[code]"])->get($order_key);
            if ($order) {
                return $order;
            }
            $user=auth()->guard('user')->user();

            $products = collect($data['products'])->map(function($product) {
                return [
                    'name' => $product['product']['name'],
                    'img' => Str::replace('http://localhost:8000', '', $product['product']['img']),
                    'size' => $product['size'],
                    'count' => $product['count'],
                    'price' => $product['price']
                ];
            });

            $order = OrderPending::create([
                'code' => $data['code'],
                'name' => $data['name'],
                'date_delivery' => $data['date_delivery'],
                'products' => $products,
                'status' => 'PENDING',
                'count' => $data['count'],
                'total' => $data['total'],
                'user_id' => $user->id,
                'address' => $data['address'],
                'pay' => $data['pay'],
                'discount_code' => $data['discount_code'] ?? NULL,
                'unit_shipping' => $data['unit_shipping'] ?? NULL,
                'note' => $data['note'] ?? NULL,
                'subtotal' => $data['subtotal'],
                'money_discount' => $data['money_discount'],
                'money_ship' => $data['money_ship'],
            ]);

            if (!$order) {
                throw new \Exception("Thêm sản phẩm không thành công", 400);
            }
            $data = [
                'id' => $order->id,
                'code' => $order->code,
                'name' => $order->name,
                'created_at' => Carbon::parse($order->created_at)->format('Y-m-d H:i:s'),
                'date_delivery' => $order->date_delivery,
                'pay' => $order->pay,
                'discount_code' => $order->discount_code,
                'status' => $order->status,
                'unit_shipping' => $order->unit_shipping,
                'note' => $order->note,
                'note_cancel' => $order->note_cancel,
                'products' => collect(json_decode($order->products, true))->map(function($product) use($host) {
                    return [
                        'name' => $product['name'],
                        'img' => $host.$product['img'],
                        'count' => $product['count'],
                        'size' => $product['size'],
                        'price' => $product['price']
                    ];
                })->toArray(),
                'count' => $order->count,
                'address' => str_replace("\n", ' ', $order->address),
                'subtotal' => number_format($order->subtotal, 0, '.', ''),
                'money_discount' => number_format($order->money_discount, 0, '.', ''),
                'money_ship' => number_format($order->money_ship, 0, '.', ''),
                'total' => number_format($order->total, 0, '.', ''),
            ];
            Cache::tags(['orders_pending', "order_pending_code_$data[code]"])->put($order_key, $data, 600);

            return $data;

        });
    }

    public function getListOrder($user_id, $page, $count) {
        $orders = $this->model::with([
            'detail' => function($query) {
                $query->select('order_id', 'address', 'pay', 'note' ,'subtotal', 'money_discount', 'money_ship', 'paid');
            }
        ])
        ->where('user_id', $user_id)
        ->latest()
        ->select('id', 'code', 'name', 'products', 'status', 'count', 'total', 'date_delivery')
        ->paginate($count);

        if($orders->isEmpty()) {
            throw new \Exception('Không tìm thấy đơn hàng trong khoảng yêu cầu', 404);
        }

        return collect($orders->items())->map(function($order) {
            return $this->getDetailBase($order);
        });
    }

    public function getDetailOrder($user_id, $code) {
        $host = env('APP_URL');
        $order = $this->model::with(['detail', 'statuses' => function($query) {
            $query->orderBy('id', 'desc');
        }])
        ->where('code', $code)
        ->first();

        if (!$order) {
            throw new \Exception("Không tìm thấy đơn hàng phù hợp yêu cầu", 404);
        }

        $data = [
            'id' => $order->id,
            'order_code' => $order->code,
            'status' => $order->status,
            'address' => $order->detail->address,
            'status_detail' => $order->statuses->map(function($status, $index) {
                return [
                    'time' => Carbon::parse($status->created_at)->format('y-m-d H:i:s'),
                    'status' => $status->status,
                    'note' => $status->note,
                    'active' => $index === 0,
                ];
            }),
            'products' => collect(json_decode($order->products, true))->map(function($product) use($host) {
                return [
                    'name' => $product['name'],
                    'img' => $host.$product['img'],
                    'count' => $product['count'],
                    'size' => $product['size'],
                    'price' => $product['price']
                ];
            })->toArray(),
            'count' => $order->count,
            'subtotal' => number_format($order->detail->subtotal, 0, '.', ''),
            'money_discount' => number_format($order->detail->money_discount, 0, '.', ''),
            'money_ship' => number_format($order->detail->money_ship, 0, '.', ''),
            'total' => number_format($order->total, 0, '.', ''),
            'paid' => number_format($order->detail->paid, 0, '.', ''),
            'pay' => $order->detail->pay == 'HOMEPAY' ? 'Thanh toán khi nhận hàng' : 'Thanh toán trực tuyến'
        ];

        return $data;
    }

    public function findOrder($user_id, $page, $code, $count) {

        $orders = $this->model::with([
            'detail' => function($query) {
                $query->select('order_id', 'address', 'pay', 'note' ,'subtotal', 'money_discount', 'money_ship', 'paid');
            }
        ])
        ->where('code', 'like', '%' . $code . '%')
        ->where('user_id', $user_id)
        ->select('id', 'code', 'name', 'products', 'status', 'count', 'total', 'date_delivery')
        ->paginate($count);

        if ($orders->isEmpty()) {
            throw new \Exception("Không tìm thấy đơn hàng phù hợp", 404);
        }
        return collect($orders->items())->map(function($order) {
            return $this->getDetailBase($order);
        });
    }

    public function payOrderPending($code, $money, $date) {
        $order = OrderPending::where('code', $code)->first();
        if (!$order) {
            throw new \Exception("Không tìm thấy đơn hàng phù hợp yêu cầu", 404);
        }

        $dateOrder = Carbon::parse($order->created_at)->addMinutes(10);
        $MoneyOrder = number_format($order->total, 0, '.', '');

        if($money >= $MoneyOrder && $dateOrder->gte($date)) {
            return DB::transaction(function () use ($order, $money) {
                $createOrder = $this->model->create([
                    'code' => $order->code,
                    'name' => $order->name ?? NULL,
                    'date_delivery' => $order->date_delivery,
                    'products' => $order->products,
                    'status' => 'PENDING',
                    'count' => $order->count,
                    'total' => $order->total,
                    'user_id' => $order->user_id
                ]);

                $createOrderDetail = $createOrder->detail()->create([
                    'order_id' => $createOrder->id,
                    'address' => $order->address,
                    'pay' => $order->pay,
                    'discount_code' => $order->discount_code ?? NULL,
                    'unit_shipping' => $order->unit_shipping ?? NULL,
                    'note' => $order->note,
                    'subtotal' => $order->subtotal,
                    'money_discount' => $order->money_discount,
                    'money_ship' => $order->money_ship,
                    'paid' => $money
                ]);

                if (!$createOrder || !$createOrderDetail) {
                    throw new \Exception("Thêm đơn hàng không thành công", 400);
                }

                if(!empty($order->discount_code)) {
                    VoucherUsages::create([
                        'user_id' => $order->user_id,
                        'order_id' => $createOrder->id,
                        'voucher_code' => $order->discount_code
                    ]);
                }
                Cache::tags(['orders_pending', "order_pending_code_$order->code]"])->flush();
                $order->delete();

                return 11111;
            });

        }
        throw new \Exception("Thanh toán không thành công", 402);

    }

    public function checkOrderPay($user_id, $code) {
        $order = $this->model::with('detail')
        ->where('code', $code)
        ->where('status', 'PENDING')
        ->where('user_id', $user_id)
        ->whereHas('detail', function ($query) {
            $query->where('paid', '>', 0);
        })
        ->first();

        if (!$order) {
            throw new \Exception("Không tìm thấy đơn hàng phù hợp yêu cầu", 404);
        }

        return [];

    }
}

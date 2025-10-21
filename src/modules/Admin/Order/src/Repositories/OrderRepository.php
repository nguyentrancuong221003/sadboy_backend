<?php
namespace Modules\Admin\Order\src\Repositories;
use Modules\Admin\Order\src\Repositories\OrderRepositoryInterface;
use App\Repositories\BaseRepository;
use Modules\Admin\Order\src\Models\Order;
use Modules\Admin\Order\src\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface {
    public function getModel() {
        return Order::class;
    }
    public function getModelDetail() {
        return OrderDetails::class;
    }
    public function getDetailBase($order) {
        $host = env('APP_URL');
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
            'name_user' => $order->user->name,
            'email' => $order->user->email,
            'phone' => $order->user->phone
        ];

        return $data;
    }
    public function getListOrder($start, $end){
        $count = $end - $start;
        $orders = $this->model::with([
            'detail' => function($query) {
                $query->select('order_id', 'address');
            }

        ])->select('id', 'code', 'total', 'status', 'created_at')
        ->latest()
        ->skip($start)->take($count)
        ->get();

        if($orders->isEmpty()) {
            throw new \Exception('Không tìm thấy đơn hàng trong khoảng yêu cầu', 404);
        }

        $orders = $orders->map(function($order) {
            return [
                'id' => $order->id,
                'code' => $order->code,
                'total' => number_format($order->total, 0, '.', ''),
                'created_at' => Carbon::parse($order->created_at)->format('Y-m-d H:i:s'),
                'status' => $order->status,
                'address' => str_replace("\n", ' ', $order->detail->address)

            ];
        });
        return $orders;
    }

    public function deleteOrder($ids) {
        return DB::transaction(function () use ($ids) {
            if (is_array($ids)) {
                $users = $this->model::whereIn('id', $ids)->whereNull('deleted_at');
                if(!$users->exists()) {
                    throw new \Exception('Không tìm thấy đơn hàng hợp lệ để xoá.', 404);
                }
                Cache::tags(array_merge(array_map(fn($id) => "order_id_$id", $ids)))->flush();
                $users->delete();
                $this->modelDetail::whereIn('order_id', $ids)->delete();
            }
            else {
                $user = $this->model::with('detail')->find($ids);
                if(!$user) {
                    throw new \Exception('Không tìm thấy đơn hàng hợp lệ để xoá.', 404);
                }
                if ($user->detail) {
                    $user->detail()->delete();
                }
                $user->delete();
                Cache::tags(["order_id_$ids"])->flush();
            }

        });
    }

    public function OrderConfirmAll() {
        $orders = $this->model::where('status', 'PENDING')->whereNotNull('user_id');
        $count = $orders->count(); // đếm trước

        if ($count === 0) {
            throw new \Exception('Không tìm thấy bản ghi phù hợp', 404);
        }

        $data = $orders->update([
            'status' => 'SHIPPING'
        ]);
        Cache::tags(['orders'])->flush();
        return $data;
    }

    public function getDetailOrder($id) {
        $order_key = "order_$id";
        return Cache::tags(['orders', "order_id_$id"])->remember($order_key, 600, function() use($id){
            $order = $this->model::with(['detail'])->find($id);
            if (!$order) {
                throw new \Exception("Không tìm thấy đơn hàng phù hợp yêu cầu", 404);
            }
            return $this->getDetailBase($order);
        });
    }

    public function editOrder($id, $data){
        return DB::transaction(function () use ($id, $data) {
            $order = $this->model::with('detail')->find($id);
            if(!$order) {
                throw new \Exception("Không tìm thấy đơn hàng phù hợp", 404);
            }
            $updated = $order->update($data);
            if (!$updated) {
                throw new \Exception("Cập nhập thông tin thất bại", 400);
            }

            $order->load(['detail']);
            // Xoá cache cũ
            Cache::tags(["order_id_$id"])->flush();

            // Lưu cache mới
            Cache::tags(['orders', "order_id_$id"])->put("order_$id", $this->getDetailBase($order), 600);
            return $this->getDetailBase($order);

        });
    }

    public function getListForceDelete($start, $end) {
        $count = $end - $start;
        $orders = $this->model::with([
            'detail' => function($query) {
                $query->select('order_id', 'address');
            },
        ])->select('id', 'code', 'name', 'date_delivery', 'status', 'deleted_at')->onlyTrashed()
        ->latest()
        ->skip($start)->take($count)->get();

        if ($orders->isEmpty()) {
            throw new \Exception("Không tìm thấy đơn hàng trong khoảng yêu cầu", 404);
        }

        $orders =  $orders->map(function($order) {
            return [
                'id' => $order->id,
                'code' => $order->code,
                'name' => $order->name,
                'phone' => $order->phone,
                'date_delivery' => $order->date_delivery,
                'status' => $order->status,
                'address' =>  str_replace("\n", ' ', $order->detail->address),
                'deleted_at' => Carbon::parse($order->deleted_at)->format('Y-m-d H:i:s')
            ];
        });
        return $orders;
    }

    public function forceDelete($id){
        $order = $this->model::with('detail')->onlyTrashed()->find($id);
        if(!$order) {
            throw new \Exception('Không tìm thấy đơn hàng', 404);
        }
        if ($order->detail) {
            $order->detail()->forceDelete();
            $order->forceDelete();
        }
    }

    public function recoverOrderDelete($id) {
        $order = $this->model::with([
            'detail' => function ($query) {
                $query->select('order_id', 'address');
            }
        ])
        ->select('id', 'code', 'name', 'date_delivery', 'status', 'deleted_at')
        ->onlyTrashed()
        ->find($id);

        if (!$order) {
            throw new \Exception("Không tìm thấy đơn hàng phù hợp yêu cầu", 404);
        }
        if($order->detail) {
            $order->detail()->restore();
            $order->restore();
        }
        else {
            throw new \Exception("Phục hồi đơn hàng không thành công", 400);
        }
        $response = [
            'id' => $order->id,
            'code' => $order->code,
            'name' => $order->name,
            'date_delivery' => $order->date_delivery,
            'status' => $order->status,
            'address' => $order->detail->address
        ];
        return $response;
    }

    public function findOrder($page, $find, $count) {

        $orders = $this->model::where('code', 'like', '%' . $find . '%')
        ->select('id', 'code', 'name', 'created_at', 'status', 'total')
        ->paginate($count);

        if ($orders->isEmpty()) {
            throw new \Exception("Không tìm thấy đơn hàng phù hợp", 404);
        }
        $orders = $orders->getCollection()->map(function($order) {
            return [
                'id' => $order->id,
                'code' => $order->code,
                'total' => number_format($order->total, 0, '.', ''),
                'created_at' => Carbon::parse($order->created_at)->format('Y-m-d H:i:s'),
                'status' => $order->status,
                'address' => str_replace("\n", ' ', $order->detail->address)

            ];
        });
        return $orders;

    }
}

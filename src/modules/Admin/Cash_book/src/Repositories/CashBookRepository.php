<?php

namespace Modules\Admin\Cash_book\src\Repositories;

use  Modules\Admin\Cash_book\src\Repositories\CashBookRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\Product\src\Models\GoodsReceipt;
use Modules\Admin\Cash_book\src\Models\DebtProvides;
use Modules\Admin\Cash_book\src\Models\DebtProvidesMonth;
use Modules\Admin\Cash_book\src\Models\ProvideOrderMonth;
use Modules\Admin\Cash_book\src\Models\IncomeSpend;
use Modules\Admin\Order\src\Models\OrderSuccess;
use Modules\Admin\Cash_book\src\Models\BillCollectSpend;


class CashBookRepository extends BaseRepository implements CashBookRepositoryInterface {
    public function getModel() {
        return GoodsReceipt::class;
    }

    public function getModelDetail() {
        return GoodsReceipt::class;
    }

    public function getDetailBaseReceipt($goodsReceipt) {

        $host = env('APP_URL');
        $data = [
            'id' => $goodsReceipt->id,
            'code' => $goodsReceipt->code,
            'count' => $goodsReceipt->count,
            'date_receive' => $goodsReceipt->date_receive,
            'created_at' => Carbon::parse($goodsReceipt->created_at)->format('Y-m-d H:i:s'),
            'discount' => number_format($goodsReceipt->discount, 0, '.', ''),
            'employee' => $goodsReceipt->employee,
            'note' => $goodsReceipt->note ?? '',
            'other_cost' => number_format($goodsReceipt->other_cost, 0, '.', ''),
            'products' => collect(json_decode($goodsReceipt->products, true))->map(function($product) use($host){
                return [
                    'code' => $product['code'] ?? '',
                    'img' => $host.$product['img'] ?? '',
                    'name' => $product['name'],
                    'size' => $product['size'],
                    'subtotal' => $product['subtotal'],
                    'totalCount' => $product['totalCount'],
                ];
            })->toArray(),
            'provide' => [
                'id' => $goodsReceipt->provide->id,
                'code' => $goodsReceipt->provide->code,
                'name' => $goodsReceipt->provide->name,
                'address' => str_replace("\n", ' ', $goodsReceipt->provide->address),
                'phone' => $goodsReceipt->provide->phone,
                'email' => $goodsReceipt->provide->email,
                'total_debt' => number_format($goodsReceipt->provide->detail->total_debt, 0, '.', ''),
                'bank' => $goodsReceipt->provide->detail->bank,
                'account_name' => $goodsReceipt->provide->detail->account_name,
                'account_phone' => $goodsReceipt->provide->detail->account_phone,
                'QR_IMG' => $host.$goodsReceipt->provide->detail->QR_IMG,
            ],
            'stock' => $goodsReceipt->stock,
            'subtotal' => number_format($goodsReceipt->subtotal, 0, '.', ''),
            'total' => number_format($goodsReceipt->total, 0, '.', ''),
            'status' => $goodsReceipt->status

        ];
        return $data;
    }
    public function getListGoodsReceipt($start, $end) {
        $count = $end - $start;
        $goodsReceipts = $this->model::with([
            'provide' => function($query) {
                $query->select('id', 'name');
            },
            'stock' => function($query) {
                $query ->select('id', 'name');
            }
        ])
        ->skip($start)->take($count)
        ->select('id', 'code', 'created_at', 'status', 'total', 'provide_id', 'stock_id')
        ->get();

        if ($goodsReceipts->isEmpty()) {
            throw new \Exception("Không tìm thấy phiếu mua hàng trong khoảng yêu cầu", 404);
        }
        $host = env('APP_URL');
        $goodsReceipts = $goodsReceipts->map(function($goodsReceipt) {
            return [
                'id' => $goodsReceipt->id,
                'code' => $goodsReceipt->code,
                'created_at' => Carbon::parse($goodsReceipt->created_at)->format('Y-m-d h:i:s'),
                'provide_name' => $goodsReceipt->provide?->name,
                'stock_name' => $goodsReceipt->stock?->name,
                'status' => $goodsReceipt->status,
                'total' => number_format($goodsReceipt->total, 0, '.', ''),
            ];
        });
        return $goodsReceipts;
    }

    public function findGoodsReceipt($page, $code, $count) {
        $goodReceipts = $this->model::with([
            'provide' => function($query) {
                $query->select('id', 'name');
            },
            'stock' => function($query) {
                $query ->select('id', 'name');
            }
        ])
        ->where('code', 'like', '%' . $code . '%')
        ->select('id', 'code', 'created_at', 'status', 'total', 'provide_id', 'stock_id')
        ->paginate($count);

        if ($goodReceipts->isEmpty()) {
            throw new \Exception("Không tìm thấy đơn hàng phù hợp", 404);
        }
        $goodReceipts = $goodReceipts->getCollection()->map(function($goodsReceipt) {
            return [
                'id' => $goodsReceipt->id,
                'code' => $goodsReceipt->code,
                'created_at' => Carbon::parse($goodsReceipt->created_at)->format('Y-m-d h:i:s'),
                'provide_name' => $goodsReceipt->provide?->name,
                'stock_name' => $goodsReceipt->stock?->name,
                'status' => $goodsReceipt->status,
                'total' => number_format($goodsReceipt->total, 0, '.', ''),
            ];
        });
        return $goodReceipts;
    }

    public function getDetailGoodsReceipt($id) {
        $goodsReceipt_key = "goodsReceipt_$id";
        return Cache::tags(['goodsReceipts', "goodsReceipt_id_$id"])->remember($goodsReceipt_key, 600, function() use($id){
            $goodsReceipt = $this->model::with([
                'employee' => function($query) {
                    $query->select('id', 'code', 'name');
                },
                'stock' => function($query) {
                    $query->select('id', 'code', 'name', 'address', 'phone', 'email');
                },
            ])->find($id);
            if (!$goodsReceipt) {
                throw new \Exception("Không tìm thấy phiếu mua hàng phù hợp yêu cầu", 404);
            }

            return $this->getDetailBaseReceipt($goodsReceipt);
        });


    }

    public function editGoodsReceipt($id, $data) {
        return DB::transaction(function () use ($id, $data) {
            $goodsReceipt = $this->model->find($id);
            if(!$goodsReceipt) {
                throw new \Exception("Không tìm thấy phiếu mua hàng phù hợp", 404);
            }
            $updated = $goodsReceipt->update($data);
            if (!$updated) {
                throw new \Exception("Cập nhập thông tin thất bại", 400);
            }

            $goodsReceipt->load(['provide', 'employee', 'stock']);
            // Xoá cache cũ
            Cache::tags(["goodsReceipt_id_$id"])->flush();

            // Lưu cache mới
            Cache::tags(['goodsReceipts', "goodsReceipt_id_$id"])->put("goodsReceipt_$id", $this->getDetailBaseReceipt($goodsReceipt), 600);
            return $this->getDetailBaseReceipt($goodsReceipt);

        });
    }


    public function getDebtProvide($date) {
        $date = Carbon::parse($date)->format('Y-m-d');
        $year = Carbon::parse($date)->year;
        $total = DebtProvides::whereDate('date', $date)
        ->selectRaw('
            SUM(initial_debt) as total_initial_debt,
            SUM(debt_arises) as total_debt_arises,
            SUM(debt_paid) as total_debt_paid,
            SUM(debt_final) as total_debt_final
        ')
        ->first();

        $debtMonths = DebtProvidesMonth::whereDate('date', '<=' ,$date)
        ->whereDate('date', '>=', "$year-01-01")
        ->select('id', 'date', 'total')
        ->get()
        ;

        $orderMonths = ProvideOrderMonth::whereDate('date', '<=' ,$date)
        ->whereDate('date', '>=', "$year-01-01")
        ->select('id', 'date', 'count')
        ->get()
        ;
        $data = [
            'date' => $date,
            'initial_debt' => number_format($total['total_initial_debt'], 0, '.', ''),
            'debt_arises' => number_format($total['total_debt_arises'], 0, '.', ''),
            'debt_paid' => number_format($total['total_debt_paid'], 0, '.', ''),
            'debt_final' => number_format($total['total_debt_final'], 0, '.', ''),
            'debt' => collect($debtMonths)->map(function($debtMonth){
                return number_format($debtMonth['total'], 0, '.', '');
            })->toArray(),
            'order' => collect($orderMonths)->map(function($orderMonth){
                return $orderMonth['count'];
            })->toArray(),
        ];
        return $data;
    }

    public function getListIncomeSpend($date, $page) {
        $date = Carbon::parse($date)->format('Y-m-d');
        $year = Carbon::parse($date)->year;
        $total = IncomeSpend::whereDate('date', $date)
        ->selectRaw('
            SUM(opening_balance) as total_opening_balance,
            SUM(money_in) as total_money_in,
            SUM(money_out) as total_money_out,
            SUM(profitable) as total_profitable,
            SUM(profit_order) as total_profit_order,
            SUM(profit_vote) as total_profit_vote'
        )
        ->first();

        $orders= OrderSuccess::select('order_id', 'total_import_price', 'discount_price', 'total_sale_price', 'total_profitable_price')
        ->paginate(10)->items();

        $votes = BillCollectSpend::select('id', 'code', 'type', 'reason', 'created_at', 'money', 'name_object')
        ->paginate(10)
        ->items();

        $data = [
            'date' => $date,
            'opening_balance' => number_format($total['total_opening_balance'], 0, '.', ''),
            'money_in' => number_format($total['total_money_in'], 0, '.', ''),
            'money_out' => number_format($total['total_money_out'], 0, '.', ''),
            'profitable' => number_format($total['total_profitable'], 0, '.', ''),
            'total_profit_order' => number_format($total['total_profit_order'], 0, '.', ''),
            'total_profit_vote' => number_format($total['total_profit_vote'], 0, '.', ''),
            'orders' =>collect($orders)->map(function($order) {
                return  [
                    'id' => $order['order_id'],
                    'code' => $order?->order?->code,
                    'import_price' => number_format($order['total_import_price'], 0, '.', ''),
                    'discount' => number_format($order['discount_price'], 0, '.', ''),
                    'sale_price' => number_format($order['total_sale_price'], 0, '.', ''),
                    'profit_price' => number_format($order['total_profitable_price'], 0, '.', ''),
                ];
            })->toArray(),
            'votes' => collect($votes)->map(function($vote) {
                return [
                    'id' => $vote['id'],
                    'code' => $vote['code'],
                    'type' => $vote['type'],
                    'reason' => $vote['reason'],
                    'created_at' => Carbon::parse($vote['created_at'])->format('y:m:d h:i:s'),
                    'name' => $vote['name_object'],
                    'money' => number_format($vote['money'], 0, '.', '')
                ];
            })->toArray()
        ];
        return $data;
    }

    public function findBillCollectSpend($page, $date, $code, $count) {
        $date = Carbon::parse($date)->format('Y-m-d');
        $votes = BillCollectSpend::select('id', 'code', 'type', 'reason', 'created_at', 'money', 'name_object')
        ->latest()
        ->where('code', 'like', '%' . $code . '%')
        ->paginate($count)
        ->items();

        if (empty($votes)) {
            throw new \Exception("Không tìm thấy phiếu trong khoảng yêu cầu", 404);
        }
        $data = collect($votes)->map(function($vote) {
            return [
                'id' => $vote['id'],
                'code' => $vote['code'],
                'type' => $vote['type'],
                'reason' => $vote['reason'],
                'created_at' => Carbon::parse($vote['created_at'])->format('y:m:d h:i:s'),
                'name' => $vote['name_object'],
                'money' => number_format($vote['money'], 0, '.', '')
            ];
        })->toArray();

        return $data;
    }

    public function getOrderSuccess($start, $end) {
        $count = $end - $start;
        $orders = OrderSuccess::skip($start)->take($count)
        ->get();
        if ($orders->isEmpty()) {
            throw new \Exception("Không tìm thấy phiếu mua hàng trong khoảng yêu cầu", 404);
        }
        $orders = $orders->map(function($order) {
            return [
                'id' => $order['order_id'],
                'code' => $order?->order?->code,
                'import_price' => number_format($order['total_import_price'], 0, '.', ''),
                'discount' => number_format($order['discount_price'], 0, '.', ''),
                'sale_price' => number_format($order['total_sale_price'], 0, '.', ''),
                'profit_price' => number_format($order['total_profitable_price'], 0, '.', ''),
            ];
        });
        return $orders;
    }

    public function createBill($data) {
        $employee=auth()->guard('employee')->user();

        $created = $vote = BillCollectSpend::create([
            'code' => $data['code'],
            'type' => $data['type'],
            'reason' => $data['reason'],
            'money' => $data['money'],
            'imgs' => json_encode($data['imgs']),
            'object' => $data['receiver'],
            'name_object' => $data['name'],
            'created_by' => $employee->name,
            'updated_by' => $employee->name
        ]);

        if (!$created) {
            throw new \Exception("Thêm phiếu thu chi không thành công", 400);
        }

        $data = [
            'id' => $vote->id,
            'code' => $vote->code,
            'type' => $vote->type,
            'reason' => $vote->reason,
            'created_at' => Carbon::parse($vote->created_at)->format('y:m:d h:i:s'),
            'name' => $vote->name_object,
            'money' => number_format($vote->money, 0, '.', '')
        ];

        return $data;
    }
}


<?php

namespace Modules\Admin\Provide\src\Repositories;

use Modules\Admin\Provide\src\Repositories\ProvideRepositoryInterface;
use App\Repositories\BaseRepository;
use Modules\Admin\Provide\src\Models\Provide;
use Modules\Admin\Provide\src\Models\ProvideDetails;
use Modules\Admin\Product\src\Models\GoodsReceipt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;

class ProvideRepository extends BaseRepository implements ProvideRepositoryInterface {
    public function getModel() {
        return Provide::class;
    }

    public function getModelDetail() {
        return ProvideDetails::class;
    }

    public function getDetailBase($provide) {
        $host = env('APP_URL');
        $data = [
            'id' => $provide->id,
            'code' => $provide->code,
            'name' => $provide->name,
            'phone' => $provide->phone,
            'address' => str_replace("\n", ' ', $provide->address),
            'email' => $provide->email,
            'img' => $host.$provide->img,
            'note' => $provide->note,
            'status' => $provide->status,
            'total_order' => $provide->detail->total_order,
            'return_order' => $provide->detail->return_order,
            'total_buy' => number_format($provide->detail->total_buy, 0, '.', ''),
            'total_debt' => number_format($provide->detail->total_debt, 0, '.', ''),
            'bank' => $provide->detail->bank,
            'account_name' => $provide->detail->account_name,
            'account_phone' => $provide->detail->account_phone,
            'QR_IMG' => $provide->detail->QR_IMG,
            'orders' => $provide->goodsReceipt->map(function($order) {
                return [
                    'id' => $order->id,
                    'code' => $order->code,
                    'created_at' => Carbon::parse($order->created_at)->format('Y-m-d H:m:s'),
                    'stock' => $order->stock->name,
                    'count' => $order->count,
                    'status' => $order->status,
                    'total' => number_format($order->total, 0, '.', ''),
                ];
            }) ?? []
        ];
        return $data;
    }
    public function getListProvide($start, $end) {
        $count = $end - $start;
        $provides = $this->model::skip($start)->take($count)
        ->latest()
        ->select('id', 'code', 'name', 'phone', 'address', 'email')
        ->get();

        if ($provides->isEmpty()) {
            throw new \Exception("Không tìm thấy nhà cung cấp trong khoảng yêu cầu", 404);
        }
        $provides = $provides->map(function($provide) {
            return [
                'id' => $provide->id,
                'code' => $provide->code,
                'name' => $provide->name,
                'phone' => $provide->phone,
                'address' => str_replace("\n", ' ', $provide->address),
                'email' => $provide->email,
                'initial_debt' => $provide->detail->total_buy,
                'debt_final' => $provide->detail->total_debt
            ];
        });
        return $provides;
    }

    public function findProvide($page, $name, $count) {
        $provides = $this->model::where('name', 'like', '%' . $name . '%')
            ->select('id', 'code', 'name', 'phone', 'address', 'email')
            ->paginate($count);
        if ($provides->total() === 0) {
            throw new \Exception("Không tìm thấy nhà cung cấp phù hợp", 404);
        }
        $provides = $provides->getCollection()->map(function($provide) {
            return [
                'id'       => $provide->id,
                'code'     => $provide->code,
                'name'     => $provide->name,
                'phone' => $provide->phone,
                'address' => str_replace("\n", ' ', $provide->address),
                'email' => $provide->email
            ];
        });
        return $provides;
    }

    public function deleteProvide($ids) {
        return DB::transaction(function () use ($ids) {
            if (is_array($ids)) {
                $provides = $this->model::whereIn('id', $ids)->whereNull('deleted_at');
                if(!$provides->exists()) {
                    throw new \Exception('Không tìm thấy nhà cung cấp hợp lệ để xoá.', 404);
                }
                Cache::tags(array_merge(array_map(fn($id) => "provide_id_$id", $ids)))->flush();
                $provides->delete();
                $this->modelDetail::whereIn('provide_id', $ids)->delete();
            }
            else {
                $provide = $this->model::with('detail')->find($ids);
                if(!$provide) {
                    throw new \Exception('Không tìm thấy nhà cung cấp hợp lệ để xoá.', 404);
                }

                if ($provide->detail) {
                    $provide->detail()->delete();
                }
                $provide->delete();
                Cache::tags(["provide_id_$ids"])->flush();
            }

        });
    }

    public function createProvide($data) {
        $employee=auth()->guard('employee')->user();

        $created = $provide = $this->model->create([
            'code' => $data['code'],
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'email' => $data['email'],
            'img' => $data['img'] ?? '/storage/images/img_provide/img_provide.jpg',
            'note' => $data['note'] ?? NULL,
            'created_by' => $employee->name

        ]);

        if (!$created) {
            throw new \Exception("Thêm nhà cung cấp không thành công", 400);
        }
        $dataProvide = [
            'id' => $provide->id,
            'code' => $provide->code,
            'name' => $provide->name,
            'phone' => $provide->phone,
            'address' => $provide->address,
            'email' => $provide->email,
            'img' => $provide->img,
            'note' => $provide->note,
            'status' => $provide->status,
            'created_by' => $provide->created_by
        ];

        Cache::tags(['provides', "provide_id_{$provide->id}"])
            ->put("provide_{$provide->id}", $dataProvide, 600);
        return $dataProvide;
    }

    public function getDetailProvide($id, $page) {
        $provide_key = "provide_$id";
        $provideData = Cache::tags(['provides', "provide_id_$id"])
            ->remember($provide_key, 600, function () use ($id) {
                $provide = $this->model::with(['detail',
                    'goodsReceipt' => function($query) {
                        $query->select('id', 'code', 'created_at', 'stock_id', 'provide_id', 'employee_id', 'count', 'status', 'total');
                    }
                ])->find($id);

                if (!$provide) {
                    throw new \Exception("Không tìm thấy nhà cung cấp phù hợp yêu cầu", 404);
                }

                return $this->getDetailBase($provide);
            });

        return $provideData;
    }

    public function loadAddOrderProvide($id, $page) {
        $orders = GoodsReceipt::where('provide_id', $id)
        ->select('id', 'code', 'created_at', 'stock_id', 'provide_id', 'employee_id', 'count', 'status', 'total')
        ->paginate(10);
        if ($orders->isEmpty()) {
            throw new \Exception("Không tìm thấy nhà cung cấp phù hợp", 404);
        }

        $orders = $orders->map(function($order) {
            return [
                'id' => $order->id,
                'code' => $order->code,
                'created_at' => Carbon::parse($order->created_at)->format('Y-m-d H:m:s'),
                'stock' => $order->stock->name,
                'count' => $order->count,
                'status' => $order->status,
                'total' => number_format($order->total, 0, '.', ''),

            ];
        });
        return $orders;
    }

    public function EditProvide($id, $data) {
        return DB::transaction(function () use ($id, $data) {
            $employee=auth()->guard('employee')->user();
            $provide = $this->model::with('detail')->find($id);
            if(!$provide) {
                throw new \Exception('Không tìm thấy nhà cung cấp hợp lệ để xoá.', 404);
            }
            $data['updated_by'] = $employee->name;
            $updated = $provide->update($data);
            if (!$updated) {
                throw new \Exception("Cập nhập thông tin thất bại", 400);
            }

            $provide->load([
                'detail',
                'goodsReceipt'
            ]);
            $provideData = $this->getDetailBase($provide);

            // Xoá cache cũ
            Cache::tags(["provide_id_$id"])->flush();

            //Lưu cache mới
            Cache::tags(['provides', "provide_id_$id"])->put("provide_$id", $provideData, 600);
            return $provideData;

        });
    }

    public function getListProvideDelete($start, $end) {
        $count = $end - $start;
        $provides = $this->model::skip($start)->take($count)
        ->select('id', 'code', 'name', 'phone', 'address', 'email', 'img', 'deleted_at')
        ->latest()
        ->onlyTrashed()
        ->get();

        if ($provides->isEmpty()) {
            throw new \Exception("Không tìm thấy nhà cung cấp trong khoảng yêu cầu", 404);
        }
        $host = env('APP_URL');
        $provides = $provides->map(function($provide) use($host){
            return [
                'id' => $provide->id,
                'code' => $provide->code,
                'name' => $provide->name,
                'phone' => $provide->phone,
                'address' => str_replace("\n", ' ', $provide->address),
                'email' => $provide->email,
                'img' => $host.$provide->img,
                'deleted_at' => Carbon::parse($provide->deleted_at)->format('Y-m-d H:m:s')
            ];
        });
        return $provides;
    }

    public function forceDelete($id) {
        $provide = $this->model::with('detail')->onlyTrashed()->find($id);
        if(!$provide) {
            throw new \Exception('Không tìm thất nhà cung cấp', 404);
        }
        if ($provide->detail) {
            $provide->detail()->forceDelete();
            $provide->forceDelete();
        }
    }

    public function recoverProvideDelete($id) {
        $provide = $this->model::with([
            'detail' => function($query) {
                $query->select('provide_id', 'deleted_at');
            }
        ])
        ->select('id', 'code', 'name', 'phone', 'address', 'email')
        ->onlyTrashed()
        ->find($id);

        if (!$provide) {
            throw new \Exception("Không tìm thấy nhà cung cấp phù hợp yêu cầu", 404);
        }

        if($provide->detail) {
            $provide->detail()->restore();
            $provide->restore();
        }
        else {
            throw new \Exception("Phục hồi nhà cung cấp không thành công", 400);
        }
        $host = env('APP_URL');
        $response = [
            'id' => $provide->id,
            'code' => $provide->code,
            'name' => $provide->name,
            'phone' => $provide->phone,
            'address' => str_replace("\n", ' ', $provide->address),
            'email' => $provide->email,
            'img' => $host.$provide->img,
            'deleted_at' => Carbon::parse($provide->deleted_at)->format('Y-m-d H:m:s')
        ];
        return $response;
    }
}

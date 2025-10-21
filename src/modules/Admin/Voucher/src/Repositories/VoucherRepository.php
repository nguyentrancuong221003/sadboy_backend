<?php
namespace Modules\Admin\Voucher\src\Repositories;
use Modules\Admin\Voucher\src\Repositories\VoucherRepositoryInterface;
use App\Repositories\BaseRepository;
use Modules\Admin\Voucher\src\Models\Voucher;
use Modules\Admin\Voucher\src\Models\VoucherDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\User\src\Models\User;
use function PHPUnit\Framework\isEmpty;

class VoucherRepository extends BaseRepository implements VoucherRepositoryInterface {
    public function getModel()
    {
        return Voucher::class;
    }

    public function getModelDetail()
    {
        return VoucherDetails::class;
    }

    public function getDetailBase($voucher) {
        $host = env('APP_URL');
        $data =  [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'name' => $voucher->name,
            'img' => $host.$voucher->img,
            'type' => $voucher->type,
            'percent' => $voucher->percent,
            'total_user' => $voucher->detail->total_user,
            'count_use' => $voucher->detail->count_use,
            'per_use' => $voucher->detail->per_use,
            'order_price_smallest' => number_format($voucher->detail->order_price_smallest, 0, '.', ''),
            'list_user_monoply' => $voucher->monopoly ?? [],
            'user_apply' => $voucher->detail->user_apply,
            'product_apply' => $voucher->category->code,
            'date_effect' => $voucher->detail->date_effect,
            'date_end' => $voucher->detail->date_effect,
            'status' => $voucher->detail->status,
            'max_money' => number_format($voucher->max_money, 0, '.', ''),
            'money_discount' => number_format($voucher->money_discount, 0, '.', ''),

        ];
        return $data;
    }
    public function getListVoucher($start, $end) {
        $count = $end - $start;
        $vouchers = $this->model::with([
            'detail' => function($query) {
                $query->select('voucher_id', 'status');
            }

        ])->select('id', 'code', 'name', 'img', 'type', 'percent', 'max_money', 'money_discount', 'created_at')
        ->skip($start)->take($count)
        ->latest()
        ->get();

        if($vouchers->isEmpty()) {
            throw new \Exception('Không tìm thấy bình luận trong khoảng yêu cầu', 404);
        }

        $host = env('APP_URL');

        $vouchers = $vouchers->map(function($voucher) use ($host) {
            return [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'created_at' => Carbon::parse($voucher->created_at)->format('Y-m-d H:m:s'),
                'img' => $host.$voucher->img,
                'money_discount' => number_format($voucher->money_discount, 0, '.', ''),
                'percent' => $voucher->percent,
                'status' => $voucher->detail->status,
                'type' => $voucher->type
            ];
        });
        return $vouchers;
    }

    public function deleteVoucher($ids) {
        return DB::transaction(function () use ($ids) {
            if (is_array($ids)) {
                $vouchers = $this->model::whereIn('id', $ids)->whereNull('deleted_at');
                if(!$vouchers->exists()) {
                    throw new \Exception('Không tìm thấy mã giảm giá hợp lệ để xoá.', 404);
                }
                Cache::tags(array_merge(array_map(fn($id) => "voucher_id_$id", $ids)))->flush();
                $vouchers->delete();
                $this->modelDetail::whereIn('voucher_id', $ids)->delete();
            }
            else {
                $voucher = $this->model::with('detail')->find($ids);
                if(!$voucher) {
                    throw new \Exception('Không tìm thấy mã giảm giá hợp lệ để xoá.', 404);
                }
                if ($voucher->detail) {
                    $voucher->detail()->delete();
                }
                $voucher->delete();
                Cache::tags(["voucher_id_$ids"])->flush();
            }

        });
    }

    public function createVoucher($data) {
        return DB::transaction(function () use ($data) {
            $created = $voucher = $this->model->create([
                'code' => $data['code'],
                'name' => $data['name'],
                'img' => $data['img'] ?? '/storage/images/img_voucher/img_voucher.webp',
                'type' => $data['type'],
                'percent' => $data['percent'],
                'max_money' => $data['max_money'],
                'money_discount' => $data['money_discount']
            ]);

            $createdDetail = $voucher->detail()->create([
                'total_user' => $data['total_user'],
                'per_use' => $data['per_use'],
                'order_price_smallest' => $data['order_price_smallest'],
                'user_apply' => $data['user_apply'],
                'category_id' => $data['category_id'],
                'date_effect' => $data['date_effect'],
                'date_end' => $data['date_end'],
                'status' => $data['status']
            ]);

            if (!$created || !$createdDetail) {
                throw new \Exception("Thêm sản phẩm không thành công", 400);
            }

            $data = $this->getDetailBase($voucher);
            Cache::tags(['vouchers', "voucher_id_{$voucher->id}"])
                ->put("voucher_{$voucher->id}", $data, 600);
            return $data;
        });
    }

    public function findVoucher($page, $code, $count) {
        $vouchers = $this->model::where('code', 'like', '%' . $code . '%')
        ->select('id', 'code', 'name', 'img', 'type', 'percent', 'max_money', 'money_discount', 'created_at')
        ->paginate($count);
        if ($vouchers->isEmpty()) {
            throw new \Exception("Không tìm thấy mã giảm giá phù hợp", 404);
        }
        $host = env('APP_URL');

        $vouchers = $vouchers->map(function($voucher) use ($host) {
            return [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'created_at' => Carbon::parse($voucher->created_at)->format('Y-m-d H:m:s'),
                'img' => $host.$voucher->img,
                'money_discount' => number_format($voucher->money_discount, 0, '.', ''),
                'percent' => $voucher->percent,
                'status' => $voucher->detail->status,
                'type' => $voucher->type
            ];
        });
        return $vouchers;

    }

    public function getDetailVoucher($id) {
        $voucher_key = "voucher_$id";
        return Cache::tags(['vouchers', "voucher_id_$id"])->remember($voucher_key, 600, function() use($id){
            $voucher = $this->model::with(['detail', 'category',
                'monopoly' => function($query) {
                    $query->select('users.id', 'users.code', 'users.name');
                }
            ])->find($id);
            if (!$voucher) {
                throw new \Exception("Không tìm thấy mã giảm giá phù hợp yêu cầu", 404);
            }

            return $this->getDetailBase($voucher);
        });
    }

    public function getListVoucherDelete($start, $end){
        $count = $end - $start;
        $vouchers = $this->model::with([
            'detail' => function($query) {
                $query->select('voucher_id', 'status');
            }
        ])->select('id', 'code', 'name', 'img', 'money_discount', 'percent', 'type', 'deleted_at')->onlyTrashed()
        ->latest()
        ->skip($start)->take($count)->get();

        if ($vouchers->isEmpty()) {
            throw new \Exception("Không tìm thấy mã giảm giá trong khoảng yêu cầu", 404);
        }

        $host = env('APP_URL');
        $vouchers =  $vouchers->map(function($voucher) use($host) {
            return [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'name' => $voucher->name,
                'img' => $host.$voucher->img,
                'percent' => $voucher->percent,
                'money_discount' => number_format($voucher->money_discount, 0, '.', ''),
                'status' => $voucher->detail->status,
                'type' => $voucher->type,
                'deleted_at' => Carbon::parse($voucher->deleted_at)->format('Y-m-d H:i:s')
            ];
        });
        return $vouchers;
    }

    public function forceDelete($id) {
        $voucher = $this->model::with('detail')->onlyTrashed()->find($id);
        if(!$voucher) {
            throw new \Exception('Không tìm thấy nhân viên', 404);
        }
        if ($voucher->detail) {
            $voucher->detail()->forceDelete();
            $voucher->forceDelete();
        }
    }

    public function recoverVoucherDelete($id) {
        $voucher = $this->model::with([
            'detail' => function ($query) {
                $query->select('voucher_id', 'status');
            }
        ])
        ->select('id', 'code', 'name', 'img', 'money_discount', 'percent', 'type', 'created_at')
        ->onlyTrashed()
        ->find($id);

        if (!$voucher) {
            throw new \Exception("Không tìm thấy mã giảm giá phù hợp yêu cầu", 404);
        }
        if($voucher->detail) {
            $voucher->detail()->restore();
            $voucher->restore();
        }
        else {
            throw new \Exception("Phục hồi mã giảm giá không thành công", 400);
        }
        $host = env('APP_URL');
        $response = [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'name' => $voucher->name,
            'img' => $host.$voucher->img,
            'percent' => $voucher->percent,
            'money_discount' => number_format($voucher->money_discount, 0, '.', ''),
            'status' => $voucher->detail->status,
            'type' => $voucher->type,
            'created_at' => Carbon::parse($voucher->created_at)->format('Y-m-d H:i:s')
        ];
        return $response;
    }

    public function editVoucher($id, $data) {

        return DB::transaction(function () use ($id, $data) {
            $voucher = $this->model::with('detail')->find($id);
            if(!$voucher) {
                throw new \Exception("Không tìm thấymã giảm giá phù hợp", 404);
            }
            $fieldVoucher = ['code', 'name', 'img', 'type', 'percent', 'max_money', 'money_discount	'];
            $vou = [];
            foreach ($fieldVoucher as $field) {
                if (!empty($data[$field])) {
                    $vou[$field] = $data[$field];
                }
            }

            $fieldVoucherDetail = ['voucher_id', 'total_user', 'count_use', 'per_use', 'order_price_smallest',
                'user_apply', 'category_id', 'date_effect', 'date_end', 'status'
            ];

            $vouDetail = [];
            foreach ($fieldVoucherDetail as $field) {
                if (!empty($data[$field])) {
                    $vouDetail[$field] = $data[$field];
                }
            }

            if(!empty($data['add_user_monoply'])) {
                $user = User::select('id', 'code', 'name')->where('code', $data['add_user_monoply'])->first();
                $voucher->monopoly()->attach($user->id);
            }

            if(!empty($data['delete_user_monoply'])) {
                $voucher->monopoly()->detach($data['delete_user_monoply']);
            }

            $updated = $voucher->update($vou);
            $updatedDetail = $voucher->detail()->update($vouDetail);


            if (!$updated || !$updatedDetail) {
                throw new \Exception("Cập nhập thông tin thất bại", 400);
            }

            $voucher->load([
                'detail',
                'category',
                'monopoly' => function($query) {
                    $query->select('users.id', 'users.code', 'users.name');
                }
            ]);

            Cache::tags(["voucher_id_$id"])->flush();
            Cache::tags(['vouchers', "voucher_id_$id"])->put("voucher_$id", $this->getDetailBase($voucher), 600);

            return $this->getDetailBase($voucher);

        });
    }
}

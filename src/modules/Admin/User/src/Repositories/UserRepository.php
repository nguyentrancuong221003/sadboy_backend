<?php
namespace Modules\Admin\User\src\Repositories;
use Modules\Admin\User\src\Repositories\UserRepositoryInterface;
use App\Repositories\BaseRepository;
use Modules\Admin\User\src\Models\User;
use Modules\Admin\User\src\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
class UserRepository extends BaseRepository implements UserRepositoryInterface {
    public function getModel()
    {
        return User::class;
    }

    public function getModelDetail()
    {
        return UserDetails::class;
    }

    public function getDetailBase($user) {
        $host = env('APP_URL');
        $data= [
            'id' => $user->id,
            'code' => $user->code,
            'name' => $user->name,
            'email' => $user->email,
            'img' => $host.$user->img,
            'date_birth' => $user->detail->date_birth,
            'date_create_account' => $user->detail->date_create_account,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'status' => $user->detail->status,
            'money_spend' => number_format($user->detail->money_spend, 0, '.', ''),
            'type' => $user->detail->type,
            'total_order' => $user->detail->total_order,
            'total_order_cancel' => $user->detail->total_order_cancel,
            'total_order_success' => $user->detail->total_order_success,
            'comment_count' => $user->detail->comment_count,
            'vouchers_user' => $user->vouchers
        ];
        return $data;
    }

    public function getListUser($start, $end)
    {
        $count = $end - $start;
        $users = $this->model::with([
            'detail' => function($query) {
                $query->select('user_id', 'type');
            }

        ])->select('id', 'code', 'name', 'email', 'img')
        ->latest()
        ->skip($start)->take($count)
        ->get();

        if($users->isEmpty()) {
            throw new \Exception('Không tìm thấy người dùng trong khoảng yêu cầu', 404);
        }

        $host = env('APP_URL');

        $users = $users->map(function($user) use ($host) {
            return [
                'id' => $user->id,
                'code' => $user->code,
                'name' => $user->name,
                'img' => $host.$user->img,
                'email' => $user->email,
                'type' => $user->detail->type ?? NULL
            ];
        });
        return $users;

    }
    public function deleteUser($ids) {
        return DB::transaction(function () use ($ids) {
            if (is_array($ids)) {
                $users = $this->model::whereIn('id', $ids)->whereNull('deleted_at');
                if(!$users->exists()) {
                    throw new \Exception('Không tìm thấy nhân viên hợp lệ để xoá.', 404);
                }
                Cache::tags(array_merge(array_map(fn($id) => "user_id_$id", $ids)))->flush();
                $users->delete();
                $this->modelDetail::whereIn('user_id', $ids)->delete();
            }
            else {
                $user = $this->model::with('detail')->find($ids);
                if(!$user) {
                    throw new \Exception('Không tìm thấy nhân viên hợp lệ để xoá.', 404);
                }
                if ($user->detail) {
                    $user->detail()->delete();
                }
                $user->delete();
                Cache::tags(["user_id_$ids"])->flush();
            }

        });
    }
    public function getDetailUser($id){
        $user_key = "user_$id";
        return Cache::tags(['users', "user_id_$id"])->remember($user_key, 600, function() use($id){
            $user = $this->model::with(['detail',
                'vouchers' => function($query) {
                    $query->select('user_voucher.id', 'vouchers.code', 'vouchers.name', 'vouchers.type', 'vouchers.percent', 'vouchers.max_money', 'vouchers.money_discount');
                }
            ])->find($id);
            if (!$user) {
                throw new \Exception("Không tìm thấy người dùng phù hợp yêu cầu", 404);
            }
            return $this->getDetailBase($user);
        });

    }

    public function editUser($id, $data) {
        return DB::transaction(function () use ($id, $data) {

            $user = $this->model::with('detail')->find($id);
            if(!$user) {
                throw new \Exception("Không tìm thấy người dùng phù hợp", 404);
            }
            $fieldUser= ['code', 'name', 'email', 'img', 'phone', 'gender'];
            $exp = [];
            foreach ($fieldUser as $field) {
                if (!empty($data[$field])) {
                    $exp[$field] = $data[$field];
                }
            }

            $fieldUserDetail = ['user_id', 'status', 'date_birth', 'date_create_account', 'money_spend', 'type',
            'number_carts', 'total_order', 'total_order_cancel', 'total_order_success', 'comment_count'];

            $expDetail = [];
            foreach ($fieldUserDetail as $field) {
                if (!empty($data[$field])) {
                    $expDetail[$field] = $data[$field];
                }
            }
            $updated = $user->update($exp);
            $updatedDetail = $user->detail()->update($expDetail);
            if (!$updated || !$updatedDetail) {
                throw new \Exception("Cập nhập thông tin thất bại", 400);
            }

            $user->load([ 'detail']);
            // Xoá cache cũ
            Cache::tags(["user_id_$id"])->flush();

            //Lưu cache mới
            Cache::tags(['users', "user_id_$id"])->put("user_$id", $this->getDetailBase($user), 600);
            return $this->getDetailBase($user);

        });
    }

    public function findUser($page, $name, $count) {
        $users = $this->model::where('name', 'like', '%' . $name . '%')
        ->select('id', 'code', 'name', 'img', 'email')
        ->paginate($count);

        if ($users->isEmpty()) {
            throw new \Exception("Không tìm thấy nhân viên phù hợp", 404);
        }
        $host = env('APP_URL');

        $users = $users->getCollection()->map(function($user) use ($host) {
            return [
                'id' => $user->id,
                'code' => $user->code,
                'name' => $user->name,
                'img' => $host.$user->img,
                'email' => $user->email,
                'type' => $user->detail->type
            ];
        });
        return $users;
    }

    public function getListForceDelete($start, $end) {
        $count = $end - $start;
        $users = $this->model::with([
            'detail' => function($query) {
                $query->select('user_id', 'type');
            }
        ])->select('id', 'code', 'name', 'img', 'email', 'deleted_at')->onlyTrashed()
        ->latest()
        ->skip($start)->take($count)->get();

        if ($users->isEmpty()) {
            throw new \Exception("Không tìm thấy nhân viên trong khoảng yêu cầu", 404);
        }

        $host = env('APP_URL');
        $users =  $users->map(function($user) use($host) {
            return [
                'id' => $user->id,
                'code' => $user->code,
                'name' => $user->name,
                'img' => $host.$user->img,
                'email' => $user->email,
                'type' => $user->detail->type,
                'deleted_at' => Carbon::parse($user->deleted_at)->format('Y-m-d H:i:s')
            ];
        });
        return $users;
    }

    public function forceDelete($id) {
        $user = $this->model::with('detail')->onlyTrashed()->find($id);
        if(!$user) {
            throw new \Exception('Không tìm thấy nhân viên', 404);
        }
        if ($user->detail) {
            $user->detail()->forceDelete();
            $user->forceDelete();
        }
    }

    public function recoverUserDelete($id) {
        $user = $this->model::with([
            'detail' => function ($query) {
                $query->select('user_id', 'type');
            }
        ])
        ->select('id', 'code', 'name', 'email', 'img', 'deleted_at')
        ->onlyTrashed()
        ->find($id);

        if (!$user) {
            throw new \Exception("Không tìm thấy nhân viên phù hợp yêu cầu", 404);
        }
        if($user->detail) {
            $user->detail()->restore();
            $user->restore();
        }
        else {
            throw new \Exception("Phục hồi nhân viên không thành công", 400);
        }

        $host = env('APP_URL');
        $response = [
            'id' => $user->id,
            'code' => $user->code,
            'name' => $user->name,
            'img' => $host.$user->img,
            'phone' => $user->phone,
            'type' => $user->detail->type,
        ];
        return $response;
    }
}

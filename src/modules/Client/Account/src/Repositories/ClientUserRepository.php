<?php

namespace Modules\Client\Account\src\Repositories;

use Modules\Client\Account\src\Repositories\ClientUserRepositoryInterface;
use App\Repositories\BaseRepository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\isEmpty;
use Modules\Admin\User\src\Models\User;
use Illuminate\Support\Str;
use Modules\Client\Account\src\Jobs\SendWelcomeEmail;
class ClientUserRepository extends BaseRepository implements ClientUserRepositoryInterface {
    public function getModel()
    {
        return User::class;
    }

    public function getModelDetail(){
        return User::class;
    }

    public function createUser($data) {
        return DB::transaction(function () use ($data) {
            $user = $this->model->create([
                'code' => Str::random(10),
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $userDetail = $user->detail()->create([
                'user_id' => $user->id,
                'status' => 'active'
            ]);
            if (!$user || !$userDetail) {
                throw new \Exception("Đăng ký tài khoản thất bại", 400);
            }
            SendWelcomeEmail::dispatch($user)->delay(now()->addMinutes(15));
            $data = [

            ];
            return $data;

        });

    }

    public function editUser($id, $data) {
        return DB::transaction(function () use ($id, $data) {
            $host = env('APP_URL');
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

            $data = [
                'name' => $user->name,
                'img' => $host.$user->img,
                'email' => $user->email,
                'phone' => $user->phone,
                'gender' => $user->gender,
                'date_birth' => $user->date_birth
            ];
            return $data;

        });
    }

    public function voucherMonopoly($id, $page, $count) {
        $host = env('APP_URL');
        $user = $this->model::find($id);
        if (!$user) {
            throw new \Exception("Không tìm thấy người dùng phù hợp yêu cầu", 404);
        }
        $vouchers = $user->vouchers()->paginate($count);
        $vouchers =$vouchers->map(function($voucher) use($host){
            return [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'name' => $voucher->name,
                'count' => $voucher?->detail?->total_user - $voucher?->detail?->count_use,
                'date_end' => $voucher?->detail?->date_end,
                'img' => $host.$voucher->img
            ];
        });
        return $vouchers;
    }

}

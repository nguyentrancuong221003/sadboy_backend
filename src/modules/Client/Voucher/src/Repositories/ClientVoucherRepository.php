<?php

namespace Modules\Client\Voucher\src\Repositories;

use Modules\Client\Voucher\src\Repositories\ClientVoucherRepositoryInterface;
use App\Repositories\BaseRepository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\isEmpty;
use Modules\Admin\Voucher\src\Models\Voucher;
use Illuminate\Support\Facades\Storage;
class ClientVoucherRepository extends BaseRepository implements ClientVoucherRepositoryInterface {
    public function getModel()
    {
        return Voucher::class;
    }

    public function getModelDetail(){
        return Voucher::class;
    }

    public function infoVoucher($voucher) {
        $host = env('APP_URL');
        $data = [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'name' => $voucher->name,
            'img' => $host.$voucher->img,
            'type' => $voucher->type,
            'percent' => $voucher->percent,
            'max_money' => number_format($voucher->max_money, 0, '.', ''),
            'money_discount' => number_format($voucher->money_discount, 0, '.', ''),
        ];

        return $data;
    }
    public function findVoucher($code) {

        $user = auth()->guard('user')->user();
        $user_id = $user->id;
        $voucher = $this->model::with(['monopoly',
            'detail' => function($query) {
                $query->select('voucher_id', 'user_apply');
            }
        ])
        ->select('id', 'code', 'name', 'img', 'type', 'percent', 'max_money', 'money_discount', 'created_at')
        ->where('code', $code)
        ->get()->first();

        if (!$voucher) {
            throw new \Exception("Không tìm thấy mã giảm giá phù hợp", 404);
        }

        $userMonopoly = $voucher->monopoly()->find($user_id);

        if($userMonopoly) {
            return $this->infoVoucher($voucher);
        }

        if($user->detail->type == 'DIAMOND') {
            return $this->infoVoucher($voucher);
        }

        if($user->detail->type ==  $voucher->detail->user_apply) {
            return $this->infoVoucher($voucher);
        }
        return [];
    }

}

<?php

namespace Modules\Admin\Stock\src\Repositories;

use Modules\Admin\Stock\src\Repositories\StockRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Stock\src\Models\Stock;
class StockRepository extends BaseRepository implements StockRepositoryInterface {
    public function getModel() {
        return Stock::class;
    }

    public function getModelDetail() {
        return Stock::class;
    }

    public function getListStock($start, $end) {
        $count = $end - $start;
        $stocks = $this->model::select('id', 'code', 'name', 'address', 'phone', 'email')
        ->latest()
        ->skip($start)->take($count)->get();

        if ($stocks->isEmpty()) {
            throw new \Exception("Không tìm thấy giỏ hàng trong khoảng yêu cầu", 404);
        }
        $host = env('APP_URL');
        $stocks = $stocks->map(function($stock) use($host){
            return [
                'id' => $stock->id,
                'code' => $stock->code,
                'name' => $stock->name,
                'address' => $stock->address,
                'phone' => $stock->phone,
                'email' => $stock->email
            ];
        });
        return $stocks;
    }

}

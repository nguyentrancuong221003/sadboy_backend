<?php

namespace Modules\Admin\Stock\src\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Stock\src\Repositories\StockRepositoryInterface;
use App\Http\Requests\CheckStartEndRequest;
class StockController extends Controller
{
    protected $stockRepo;

    public function __construct(StockRepositoryInterface $stockRepo)
    {
        $this->stockRepo = $stockRepo;
    }

    public function index(CheckStartEndRequest $request) {
        try {
            $start = $request->input('start');      // bắt đầu từ bản ghi nào
            $end = $request->input('end');

            $stocks = $this->stockRepo->getListStock($start, $end);

            return response()->json([
                'status' => 'success',
                'message' => 'Danh sách kho hàng',
                'data' => $stocks,
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy danh sách kho hàng thất bại ở trong StockController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

}

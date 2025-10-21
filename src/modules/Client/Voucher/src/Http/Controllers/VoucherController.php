<?php

namespace Modules\Client\Voucher\src\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Client\Voucher\src\Repositories\ClientVoucherRepositoryInterface;
use Illuminate\Support\Facades\Log;
class VoucherController extends Controller
{
    protected $voucherRepo;

    public function __construct(ClientVoucherRepositoryInterface $voucherRepo)
    {
        $this->voucherRepo = $voucherRepo;
    }

    public function show(Request $request) {
        try {
            $code = $request->input('code');
            $voucher = $this->voucherRepo->findVoucher($code);

            return response()->json([
                'status' => 'success',
                'message' => 'Lấy mã giảm giá thành công',
                'data' => $voucher
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy danh sách mã giảm giá thất bại ở trong voucherController: '
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

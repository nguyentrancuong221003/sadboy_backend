<?php

namespace Modules\Client\Cart\src\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Client\Cart\src\Repositories\CartRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\AuthorizationException;
use Modules\Client\Cart\src\Http\Requests\CartRequest;
class CartController extends Controller
{
    protected $cartRepo;

    public function __construct(CartRepositoryInterface $cartRepo)
    {
        $this->cartRepo = $cartRepo;
    }

    public function index(Request $request) {
        try {

            $page = $request->input('page', 1);
            $user=auth()->guard('user')->user();
            $carts = $this->cartRepo->getListCart($user->id, $page);
            return response()->json([
                'status' => 'success',
                'message' => 'Giỏ hàng của người dùng',
                'data' => $carts,
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy giỏ hàng thất bại ở trong cartController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function destroy(Request $request) {
        try {
            $id = $request->input('id');
            $this->cartRepo->deleteCart($id);
            return response()->noContent();
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('xoá sản phẩm trong giỏ hàng không thành công: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function create(CartRequest $request) {
        try {
            $data = $request->only(['count', 'product_id', 'size', 'code']);
            $employee = $this->cartRepo->addProductCart($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Đã thêm một sản phẩm vào giỏ hàng',
                'data' => $employee
            ], 201, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Thêm một sản phẩm vào giỏ hàng thất bại employeeController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $statusCode);
        }
    }
}

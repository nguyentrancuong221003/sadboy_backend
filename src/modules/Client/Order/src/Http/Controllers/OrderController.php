<?php

namespace Modules\Client\Order\src\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Client\Order\src\Repositories\ClientOrderRepositoryInterface;
use Modules\Client\Order\src\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
class OrderController extends Controller
{
    protected $orderRepo;

    public function __construct(ClientOrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function create(OrderRequest $request){
        try {
            $data = $request->only([
                'code', 'name', 'date_delivery', 'address', 'note', 'pay', 'discount_code', 'subtotal',
                'money_discount', 'money_ship', 'total', 'count', 'unit_shipping', 'products'
            ]);

            if($data['pay'] == 'HOMEPAY') {
                $product = $this->orderRepo->createOrder($data);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Đặt hàng thành công',
                    'data' => $product
                ], 201, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            }
            else {
                $product = $this->orderRepo->createOrderPending($data);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Đặt hàng thành công',
                    'data' => $product
                ], 201, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            }


        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Đặt hàng thất bại productController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $statusCode);
        }
    }

    public function index(Request $request) {
        try {
            $user = auth()->guard('user')->user();

            $user_id = $user->id;
            $page = $request->input('page', 1);
            $count = $request->input('count', 10);
            $order = $this->orderRepo->getListOrder($user_id, $page, $count);
            return response()->json([
                'status' => 'success',
                'message' => 'Lấy danh sách đơn hàng thành công',
                'data' => $order
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy danh sách đơn hàng thất bại orderController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function show($code) {
        try {
            $user = auth()->guard('user')->user();
            $user_id = $user->id;
            $order = $this->orderRepo->getDetailOrder($user_id, $code);

            return response()->json([
                'status' => 'success',
                'message' => 'Thông tin chi tiết của đơn hàng',
                'data' => $order,

            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin đơn hàng thất bại OrderController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function findOrderCode(Request $request){
        try {
            $user = auth()->guard('user')->user();
            $user_id = $user->id;
            $page = $request->input('page', 1);
            $code = $request->input('code');
            $count = $request->input('count', 10);

            $order = $this->orderRepo->findOrder($user_id, $page, $code, $count);

            return response()->json([
                'status' => 'success',
                'message' => 'Danh sách đơn hàng',
                'data' => $order,

            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Client lấy danh sách đơn hàng thất bại OrderController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function payOrder(Request $request) {
        try {

            $expectedKey = env('SEPAY_SECRET');
            $authHeader = $request->header('Authorization');
            if (!$authHeader || $authHeader !== 'Apikey ' . $expectedKey) {
                Log::warning('🚨 Sai API Key từ Sepay!', ['header' => $authHeader]);
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $data = $request->all();
            $content = $request->content;
            $code = '';
            $date = $request->transactionDate;
            $money = $request->transferAmount;
            if (preg_match('/(\S+)$/', trim($content), $matches)) {
                $code = $matches[1];
            }
            $filePath = public_path('pay.txt');
            file_put_contents($filePath, $code, FILE_APPEND | LOCK_EX);

            $order = $this->orderRepo->payOrderPending($code, $money, $date);

            return response()->json([
                'status' => 'success',
                'message' => 'Thanh toán thành công',
                'data' => $order
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy danh sách đơn hàng thất bại OrderController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

    }

    public function orderCheckPay($code) {
        try {
            $user = auth()->guard('user')->user();
            $user_id = $user->id;
            $order = $this->orderRepo->checkOrderPay($user_id, $code);

            return response()->json([
                'status' => 'success',
                'message' => 'Thông tin chi tiết của đơn hàng',
                'data' => $order,

            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin đơn hàng thất bại OrderController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }
}

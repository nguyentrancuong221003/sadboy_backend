<?php

namespace Modules\Admin\Cash_book\src\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Modules\Admin\Cash_book\src\Repositories\CashBookRepositoryInterface;
use App\Http\Requests\CheckStartEndRequest;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Cash_book\src\Http\Requests\FindBillRequest;
use Modules\Admin\Cash_book\src\Http\Requests\AddBillRequest;
use Modules\Admin\Product\src\Models\Product;
use Modules\Admin\Cash_book\src\Models\DebtProvides;
use Modules\Admin\Cash_book\src\Models\IncomeSpend;
use Modules\Admin\Cash_book\src\Models\BillCollectSpend;
class CashBookController extends Controller
{
    protected $cashBookRepo;

    public function __construct(CashBookRepositoryInterface $cashBookRepo)
    {
        $this->cashBookRepo = $cashBookRepo;
    }

    public function index(CheckStartEndRequest $request) {
        try {
            $this->authorize('GoodsReceipt', Product::class);
            $start = $request->input('start');      // bắt đầu từ bản ghi nào
            $end = $request->input('end');
            $goodsReceipts = $this->cashBookRepo->getListGoodsReceipt($start, $end);

            return response()->json([
                'status' => 'success',
                'message' => 'Danh sách phiếu nhập hàng',
                'data' => $goodsReceipts
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy danh sách phiếu nhập hàng thất bại ở trong CashBookController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function GoodsReceiptsCode(Request $request) {
        try {
            $this->authorize('GoodsReceipt', Product::class);
            $code = $request->input('code', '');
            $count = $request->input('count', 5);
            $page = $request->input('page', 1);
            if($count < 0 ){
                throw new \Exception("Yêu cầu count không được âm", 400);
            }
            $goodsReceipts = $this->cashBookRepo->findGoodsReceipt($page, $code, $count);

            return response()->json([
                'status' => 'success',
                'data' => $goodsReceipts
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy danh sách sản phẩm thất bại ở trong CashBookController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function show($id) {
        try {
            $this->authorize('GoodsReceipt', Product::class);
            
            $order = $this->cashBookRepo->getDetailGoodsReceipt($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Thông tin chi tiết của phiếu mua hàng',
                'data' => $order,

            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin phiếu mua hàng thất bại OrderController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function update(Request $request, $id) {
        try {
            $this->authorize('GoodsReceipt', Product::class);
            $data = $request->only([
                'status',
                'note_cancel'
            ]);
            $order = $this->cashBookRepo->editGoodsReceipt($id, $data);
            return response()->json([
                'status' => 'success',
                'message' => 'Chỉnh sửa thông tin phiếu mua hàng thành công',
                'data' => $order
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin phiếu mua hàng thất bại OrderController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function indexDebtProvide(Request $request) {
        try {
            $this->authorize('viewDebt', DebtProvides::class);
            $date = $request->input('date');

            if (!Carbon::hasFormat($date, 'Y-m-d H:i:s')) {
                throw new \Exception("Không phải ngày hợp lệ", 400);
            }
            $debt = $this->cashBookRepo->getDebtProvide($date);
            return response()->json([
                'status' => 'success',
                'message' => 'Lấy thông tin công nợ thành công',
                'data' => $debt
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin công nợ thất bại CashBookController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function indexIncomeSpend(Request $request) {
        try {
            $this->authorize('viewIncomeSpend', IncomeSpend::class);
            $date = $request->input('date');
            $page = $request->input('page');
            if (!Carbon::hasFormat($date, 'Y-m-d')) {
                throw new \Exception("Không phải ngày hợp lệ", 400);
            }
            $incomeSpend = $this->cashBookRepo->getListIncomeSpend($date, $page);
            return response()->json([
                'status' => 'success',
                'message' => 'Lấy thông tin phiếu thu thành công',
                'data' => $incomeSpend
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin phiếu thu thất bại CashBookController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function IncomeSpendCode(FindBillRequest $request) {
        try {
            $this->authorize('viewIncomeSpend', IncomeSpend::class);
            $date = $request->input('date');
            $page = $request->input('page');
            $code = $request->input('code');
            $count = $request->input('count');

            $incomeSpends = $this->cashBookRepo->findBillCollectSpend($page, $date, $code, $count);
            return response()->json([
                'status' => 'success',
                'message' => 'Lấy thông tin phiếu thu thành công',
                'data' => $incomeSpends
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin phiếu thu thất bại CashBookController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function orderSuccess(CheckStartEndRequest $request) {
        try {
            $this->authorize('viewIncomeSpend', IncomeSpend::class);
            $start = $request->input('start');      // bắt đầu từ bản ghi nào
            $end = $request->input('end');
            $goodsReceipts = $this->cashBookRepo->getOrderSuccess($start, $end);

            return response()->json([
                'status' => 'success',
                'message' => 'Danh sách đơn hàng thành công',
                'data' => $goodsReceipts
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy danh sách đơn hàng thành công thất bại ở trong CashBookController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function createBill(AddBillRequest $request) {
        try {
            $this->authorize('addBill', BillCollectSpend::class);
            $data = $request->only(['code', 'money', 'reason', 'receiver', 'name', 'type', 'imgs']);

            if ($request->hasFile('imgs')) {
                $paths = [];
                foreach ($request->file('imgs') as $img) {
                    $filename = $request->code . '_' . time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $path = $img->storeAs(
                        'images/img_cash_book',
                        $filename,
                        'public'
                    );
                    $paths[] = '/storage/' . $path;
                }
                $data['imgs'] = $paths;
            }
            else {
                $data['imgs'] = NULL;
            }
            //return $data;
            $bills = $this->cashBookRepo->createBill($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Đã thêm sản phẩm thành công',
                'data' => $bills
            ], 201, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Thên sản phẩm mới thất bại productController: '
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

<?php

namespace Modules\Admin\Provide\src\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Provide\src\Repositories\ProvideRepositoryInterface;
use App\Http\Requests\CheckStartEndRequest;
use Modules\Admin\Provide\src\Http\Requests\ProvideRequest;
use Modules\Admin\Provide\src\Models\Provide;
class ProvideController extends Controller
{
    protected $provideRepo;

    public function __construct(ProvideRepositoryInterface $provideRepo)
    {
        $this->provideRepo = $provideRepo;
    }

    public function index(CheckStartEndRequest $request) {
        try {
            $this->authorize('viewAny', Provide::class);
            $start = $request->input('start');      // bắt đầu từ bản ghi nào
            $end = $request->input('end');
            $provides = $this->provideRepo->getListProvide($start, $end);

            return response()->json([
                'status' => 'success',
                'message' => 'Danh sách nhà cung cấp',
                'data' => $provides
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            // 🔹 Xử lý riêng lỗi phân quyền
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy danh sách nhà cung cấp thất bại ở trong provideController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function findProvideName(Request $request) {
        try {
            $this->authorize('find', Provide::class);
            $name = $request->input('name', '');
            $count = $request->input('count', 5);
            $page = $request->input('page', 1);
            if($count < 0 ){
                throw new \Exception("Yêu cầu count không được âm", 400);
            }
            $provide = $this->provideRepo->findProvide($page, $name, $count);

            return response()->json([
                'status' => 'success',
                'data' => $provide
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            // 🔹 Xử lý riêng lỗi phân quyền
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy danh sách nhà cung cấp thất bại ở trong provideController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function delete(Request $request) {
        try {
            $this->authorize('delete', Provide::class);
            $ids = $request->input('ids');
            $this->provideRepo->deleteProvide($ids);
            return response()->noContent();
        }
        catch (AuthorizationException $e) {
            // 🔹 Xử lý riêng lỗi phân quyền
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('xoá nhân viên không thành công: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function create(ProvideRequest $request) {
        try {
            $this->authorize('create', Provide::class);
            $data = $request->only(['code', 'name', 'phone', 'address', 'email', 'img', 'note']);

            if ($request->hasFile('img')) {
                $filename = $request->code.''.time(). '.' . $request->file('img')->getClientOriginalExtension();

                $path = $request->file('img')->storeAs(
                    'images/img_provide', // thư mục trong disk
                    $filename,   // tên file tuỳ chỉnh
                    'public'     // disk
                );

                $data['img'] = '/storage/'.$path;
            }

            $provide = $this->provideRepo->createProvide($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Đã thêm nhà cung cấp thành công',
                'data' => $provide
            ], 201, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            // 🔹 Xử lý riêng lỗi phân quyền
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Thên nhân viên mới thất bại provideController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $statusCode);
        }

    }

    public function show(Request $request, $id) {
        try {
            $this->authorize('view', Provide::class);
            if (!is_numeric($id) || $id <= 0) {
                throw new \Exception("ID phải là số dương", 400);
            }
            $page = $request->input('page', 1);
            $provide = $this->provideRepo->getDetailProvide($id, $page);
            return response()->json([
                'status' => 'success',
                'message' => 'Thông tin chi tiết của nhà cung cấp',
                'data' => $provide,

            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            // 🔹 Xử lý riêng lỗi phân quyền
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin nhà cung cấp thất bại provideController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function loadOrder(Request $request, $id) {
        try {
            $this->authorize('view', Provide::class);
            $page = $request->input('page', 1);
            $provide = $this->provideRepo->loadAddOrderProvide($id, $page);
            return response()->json([
                'status' => 'success',
                'message' => 'Thông tin chi tiết của nhà cung cấp',
                'data' => $provide,

            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            // 🔹 Xử lý riêng lỗi phân quyền
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin nhà cung cấp thất bại provideController: '
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function update(ProvideRequest $request, $id) {
        try {
            $this->authorize('update', Provide::class);
            $data = $request->only([
                'name', 'address', 'note', 'email', 'phone', 'status'
            ]);
            $provide = $this->provideRepo->editProvide($id, $data);
            return response()->json([
                'status' => 'success',
                'message' => 'Chỉnh sửa thông tin nhà cung cấp thành công',
                'data' => $provide
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        }
        catch (AuthorizationException $e) {
            // 🔹 Xử lý riêng lỗi phân quyền
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error($e->getMessage(). ' ở provideController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $statusCode);
        }
    }

    public function indexForce(CheckStartEndRequest $request) {
        try {
            $this->authorize('viewDelete', Provide::class);
            $start = $request->input('start', 0);      // bắt đầu từ bản ghi nào
            $end = $request->input('end', 10);

            $provides = $this->provideRepo->getListProvideDelete($start, $end);

            return response()->json([
                'status' => 'success',
                'message' => 'Danh sách nhà cung cấp đã bị xoá',
                'data' => $provides,
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (AuthorizationException $e) {
            // 🔹 Xử lý riêng lỗi phân quyền
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy danh sách nhà cung cấp xoá mềm thất bại: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function forceDelete($id) {
        try {
            $this->authorize('forceDelete', Provide::class);
            $this->provideRepo->forceDelete($id);
            return response()->noContent();
        }
        catch (AuthorizationException $e) {
            // 🔹 Xử lý riêng lỗi phân quyền
            Log::warning('Bạn không có quyền thực hiện hành động này '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Bạn không có quyền truy cập chức năng này.'
            ], 403, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e){
            $statusCode = $e->getCode() ?: 500;
            Log::error('Bắt buộc xoá nhà cung cấp không thành công: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function restore($id) {
        try {
            $this->authorize('restore', Provide::class);
            $provide = $this->provideRepo->recoverProvideDelete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Phục hồi sản phẩm thành công',
                'data' => $provide,

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
            Log::error('Phục hồi sản phẩm đã bị xoá thất bại: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),

            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }
}

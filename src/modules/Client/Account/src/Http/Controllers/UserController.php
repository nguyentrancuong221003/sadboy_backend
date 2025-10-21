<?php

namespace Modules\Client\Account\src\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Client\Account\src\Repositories\ClientUserRepositoryInterface;
use Modules\Client\Account\src\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    protected $accountRepo ;

    public function __construct(ClientUserRepositoryInterface $accountRepo)
    {
        $this->accountRepo = $accountRepo;
    }

    public function create(UserRequest $request) {
        try {
            $data = $request->only(['name', 'password', 'email']);
            $user = $this->accountRepo->createUser($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Đăng ký tài khoản thành công',
                'data' => $user
            ], 201, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Người dùng đăng ký tài khoản thất bại ở userController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function update(UserRequest $request){
        try {
            $user=auth()->guard('user')->user();
            $id = $user->id;
            $user = $this->accountRepo->find($id);
            if(!$user) {
                throw new \Exception("Không tìm thấy người dùng phù hợp", 404);
            }

            $data = $request->only([
                'email', 'phone', 'gender', 'date_birth'
            ]);
            if ($request->hasFile('img')) {
                if ($user->img) {
                    $oldPath = str_replace('/storage/', '', $user->img);
                    if (!strpos($oldPath, 'img_user.jpg')) {
                        if (Storage::disk('public')->exists($oldPath)) {
                            Storage::disk('public')->delete($oldPath);
                        }
                    }
                }
                $filename = $request->code
                    ? $request->code . time() . '.' . $request->file('img')->getClientOriginalExtension()
                    : $user->code . time() . '.' . $request->file('img')->getClientOriginalExtension();
                $path = $request->file('img')->storeAs(
                    'images/img_user',
                    $filename,
                    'public'
                );
                $data['img'] = '/storage/' . $path;
            }
            $user = $this->accountRepo->editUser($id, $data);
            return response()->json([
                'status' => 'success',
                'message' => 'Chỉnh sửa thông tin nhân viên thành công',
                'data' => $user
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error($e->getMessage(). ' ở userController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], $statusCode, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

    public function getUserVouchers(Request $request) {
        try {
            $user=auth()->guard('user')->user();

            $id = $user->id;
            $page = $request->input('page', 1);
            $count = $request->input('count', 10);
            $vouchers = $this->accountRepo->voucherMonopoly($id, $page, $count);
            return response()->json([
                'status' => 'success',
                'message' => 'Danh sách mã giảm giá',
                'data' => $vouchers
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch(\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('CLient lấy danh sách mã giảm giá thất ở userController: '
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

<?php

namespace Modules\Admin\Dashboard\src\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Admin\Dashboard\src\Repositories\DashboardRepositoryInterface;
use Illuminate\Support\Facades\Log;
class DashboardController extends Controller
{
    protected $dashboardRepo;

    public function __construct(DashboardRepositoryInterface $dashboardRepo)
    {
        $this->dashboardRepo = $dashboardRepo;
    }

    public function index(Request $request) {
        try {
            $dashboards = $this->dashboardRepo->getInfoDashBoard();

            return response()->json([
                'status' => 'success',
                'message' => 'Thông tin của trang',
                'data' => $dashboards,
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            Log::error('Lấy thông tin thất bại ở trong dashboardController: '
                . ' tại file ' . $e->getFile()
                . ' dòng ' . $e->getLine()
            );
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], $statusCode , [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

}

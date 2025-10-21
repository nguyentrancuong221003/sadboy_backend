<?php

namespace Modules\Admin\Dashboard\src\Repositories;

use Modules\Admin\Dashboard\src\Repositories\DashboardRepositoryInterface;
use App\Repositories\BaseRepository;
use Modules\Admin\Comment\src\Models\Comment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\User\src\Models\User;
use Modules\Admin\Employee\src\Models\Employee;
use Modules\Admin\Provide\src\Models\Provide;
use Modules\Admin\Product\src\Models\Product;
use Modules\Admin\Order\src\Models\Order;
use Modules\Admin\Voucher\src\Models\Voucher;
use Modules\Admin\Cash_book\src\Models\DebtProvidesMonth;
use Modules\Admin\Cash_book\src\Models\Profitable;
use Modules\Admin\Cash_book\src\Models\ProvideOrderMonth;


class DashboardRepository extends BaseRepository implements DashboardRepositoryInterface {
    public function getModel() {
        return Comment::class;
    }

    public function getModelDetail() {
        return Comment::class;
    }

    public function getInfoDashBoard() {

        $dashboard_key = "dashboards";
        $dashboard = cache::get($dashboard_key);
        if($dashboard) {
            return $dashboard;
        }

        $total_user = User::count();
        $total_employee = Employee::count();
        $total_provide = Provide::count();
        $total_product = Product::count();
        $total_order = Order::count();
        $total_voucher = Voucher::count();

        $host = env('APP_URL');
        $orders = Order::with(['user' => function($query) {
            $query->select('id', 'code', 'name');
        }])
        ->select('id', 'code', 'total', 'status', 'user_id')
        ->latest()->take(5)->get();

        $today = Carbon::now()->toDateString();
        $year = Carbon::parse($today)->year;
        $debtMonths = DebtProvidesMonth::whereDate('date', '<=' ,$today)
        ->whereDate('date', '>=', "$year-01-01")
        ->select('id', 'date', 'total')
        ->get();

        $users = User::with(['detail' => function($query) {
            $query->select('user_id', 'date_birth', 'type');
        }])
        ->select('id', 'code', 'name', 'email', 'img', 'phone', 'gender')
        ->latest()->take(5)->get();

        $profits = Profitable::whereDate('date', '<=' ,$today)
        ->whereDate('date', '>=', "$year-01-01")
        ->select('id', 'date', 'money')
        ->get();

        $orderImportExport = ProvideOrderMonth::whereDate('date', '<=' ,$today)
        ->whereDate('date', '>=', "$year-01-01")
        ->select('id', 'date', 'count')
        ->get();

        $products = Product::with(['detail' => function($query) {
            $query->select('product_id', 'count_sale', 'import_price', 'original_price', 'sale_price')->whereNotNull('sale_price');
        }])
        ->select('id', 'code', 'name', 'imgs', 'category_id')
        ->latest()->take(9)->get();


        $data = [
            'total_user' => $total_user,
            'total_employee' => $total_employee,
            'total_provide' => $total_provide,
            'total_product' => $total_product,
            'total_order' => $total_order,
            'total_voucher' => $total_voucher,
            'orders' => $orders->map(function($order) {
                return [
                    'id' => $order->id,
                    'code' => $order->code,
                    'name_user' => $order->user->name,
                    'total' => number_format($order->total, 0, '.', ''),
                    'status' => $order->status
                ];
            }),
            'debts' => collect($debtMonths)->map(function($debtMonth){
                return number_format($debtMonth['total'], 0, '.', '');
            })->toArray(),
            'users' => $users->map(function($user) use($host) {
                return [
                    'id' => $user->code,
                    'code' => $user->code,
                    'name' => $user->name,
                    'img' => $host.$user->img ?? NULL,
                    'email' => $user->email,
                    'type' => $user->detail->type ?? NULL,
                    'phone' => $user->phone ?? NULL,
                    'date' => $user->detail->date_birth ?? NULL
                ];
            }),
            'profits' => collect($profits)->map(function($profit){
                return number_format($profit['money'], 0, '.', '');
            })->toArray(),
            'order_import_export' => [
                'order_import' => collect($orderImportExport)->map(function($count){
                    return $count['count'];
                })->toArray(),
                'order_export' => collect($orderImportExport)->map(function($count){
                    return $count['count'] + array_sum(range(1,5));
                })->toArray(),
            ],
            'product_sale' => collect($products)->map(function($product) use ($host) {
                return [
                    'id'       => $product->id,
                    'code'     => $product->code,
                    'name'     => $product->name,
                    'img' => $host.((json_decode($product->imgs ?? '[]', true)[0] ?? null)),
                    'price'    => json_decode($product->detail->sale_price ?? '', true)['S'] ?? 0,
                    'category' => $product->category->code,
                ];
            })->chunk(3)
            ->map(fn($chunk) => $chunk->values())
            ->values()
            ->toArray(),


        ];
        Cache::put($dashboard_key, $data, 1200);
        return $data;
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\Admin\Provide\seeders\ProvideSeeder;
use Modules\Admin\Provide\seeders\ProvideDetailsSeeder;
use Modules\Admin\Provide\seeders\ProductProvideSupplySeeder;
use Modules\Admin\Product\Seeders\CategorySeeder;
use Modules\Admin\Product\Seeders\ProductSeeder;
use Modules\Admin\Product\seeders\ProductDetailsSeeder;
use Modules\Admin\Product\seeders\ProductProvideSeeder;
use Modules\Admin\Employee\seeders\ContrastSeeder;
use Modules\Admin\Employee\seeders\DepartmentSeeder;
use Modules\Admin\Employee\seeders\GrantSeeder;
use Modules\Admin\Employee\seeders\PositionSeeder;
use Modules\Admin\Employee\seeders\WorkShiftsSeeder;
use Modules\Admin\Employee\seeders\EmployeeSeeder;
use Modules\Admin\Employee\seeders\EmployeeDetailsSeeder;
use Modules\Admin\User\seeders\UserSeeder;
use Modules\Admin\User\seeders\UserDetailsSeeder;
use Modules\Admin\Voucher\seeders\VoucherSeeder;
use Modules\Admin\Voucher\seeders\VoucherDetailSeeder;
use Modules\Admin\Voucher\seeders\UserVoucherSeeder;
use Modules\Admin\Order\seeders\OrderSeeder;
use Modules\Admin\Order\seeders\OrderDetailsSeeder;
use Modules\Admin\Order\seeders\OrderStatusesSeeder;
use Modules\Admin\Comment\seeders\CommentSeeder;
use Modules\Admin\Stock\seeders\StockSeeder;
use Modules\Admin\Product\seeders\GoodsReceiptSeeder;
use Modules\Admin\Cash_book\seeders\DebtProvideSeeder;
use Modules\Admin\Cash_book\seeders\DebtProvideMonthSeeder;
use Modules\Admin\Cash_book\seeders\ProvideOrderMonthSeeder;
use Modules\Admin\Cash_book\seeders\IncomeSpendSeeder;
use Modules\Admin\Cash_book\seeders\BillCollectSpendSeeder;
use Modules\Admin\Chat\seeders\ConversationSeeder;
use Modules\Admin\Chat\seeders\MessageSeeder;
use Modules\Admin\Order\seeders\OrderSuccessSeeder;
use Modules\Admin\Cash_book\seeders\ProfitableSeeder;
use Modules\Admin\Employee\seeders\ModuleSeeder;
use Modules\Admin\User\seeders\CartSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(ProvideSeeder::class); //1
         $this->call(ProvideDetailsSeeder::class); //2
        $this->call(ProductProvideSupplySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
         $this->call(ProductDetailsSeeder::class);
        $this->call(ProductProvideSeeder::class);
        $this->call(ContrastSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(GrantSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(WorkShiftsSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(EmployeeDetailsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserDetailsSeeder::class);

        $this->call(VoucherSeeder::class);
        $this->call(VoucherDetailSeeder::class);
        $this->call(UserVoucherSeeder::class);

        $this->call(OrderSeeder::class);
        $this->call(OrderDetailsSeeder::class);
        $this->call(OrderStatusesSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(StockSeeder::class);
        $this->call(GoodsReceiptSeeder::class);
        $this->call(DebtProvideSeeder::class);
        $this->call(DebtProvideMonthSeeder::class);
        $this->call(ProvideOrderMonthSeeder::class);
        $this->call(IncomeSpendSeeder::class);
        $this->call(BillCollectSpendSeeder::class);
        $this->call(ConversationSeeder::class);
        $this->call( MessageSeeder::class);
        $this->call(OrderSuccessSeeder::class);
        $this->call(ProfitableSeeder::class);

        $this->call(ModuleSeeder::class);
        $this->call(CartSeeder::class);
    }
}

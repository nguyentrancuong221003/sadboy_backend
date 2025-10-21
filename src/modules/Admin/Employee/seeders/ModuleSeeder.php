<?php

namespace Modules\Admin\Employee\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Employee\src\Models\Module;
class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::create(
            [
                'employee_id' => 1,
                'permissions' => json_encode([
                    'employee' => ['view', 'viewAny', 'viewDelete'],
                    'user' => ['view', 'viewAny', 'viewDelete'],
                    'order' => ['view', 'viewAny', 'viewDelete'],
                    'product' => ['view', 'viewAny', 'viewDelete'],
                    'comment' => ['view', 'viewAny', 'viewDelete'],
                    'voucher' => ['view', 'viewAny', 'viewDelete'],
                    'provide' => ['view', 'viewAny', 'viewDelete'],
                    'cash_book' => ['viewDebt', 'viewIncomeSpend', 'addBill'],
                ])
            ]
        );
    }
}
//view, viewAny,'restore' , 'update', 'delete', 'find', 'viewDelete', 'add', ,forceDelete
// 'permissions' => json_encode([
//                     'employee' => ['view', 'viewAny', 'add', 'delete', 'viewDelete', 'forceDelete'],
//                     'user' => ['viewAny', 'delete', 'viewDelete', 'view'],
//                     'order' => ['viewAny', 'delete', 'viewDelete', 'view', 'find'],
//                     'product' => ['all'],//'GoodsReceipt'
//                     'comment' => ['viewAny', 'delete', 'viewDelete', 'view'],
//                     'voucher' => ['viewAny', 'delete', 'viewDelete', 'view'],
//                     'provide' => ['viewAny', 'delete', 'viewDelete', 'view'],
//                     'cash_book' => ['viewDebt', 'viewIncomeSpend', 'addBill'] //addBill
//                 ])

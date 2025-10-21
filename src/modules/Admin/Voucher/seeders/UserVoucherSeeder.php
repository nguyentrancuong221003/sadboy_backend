<?php

namespace Modules\Admin\Voucher\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Voucher\src\Models\UserVoucher;
class UserVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserVoucher::factory()->count(60)->create();
    }
}

<?php

namespace Modules\Admin\Voucher\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Voucher\src\Models\Voucher;
class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Voucher::factory()->count(40)->create();
    }
}

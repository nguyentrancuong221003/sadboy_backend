<?php

namespace Modules\Admin\Voucher\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Voucher\src\Models\VoucherDetails;
class VoucherDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1, 40) as $id) {
            VoucherDetails::factory()->create([
                'voucher_id' => $id
            ]);
        }

    }
}

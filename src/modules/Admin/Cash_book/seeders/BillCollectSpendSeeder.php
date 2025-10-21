<?php

namespace Modules\Admin\Cash_book\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Cash_book\src\Models\BillCollectSpend;
class BillCollectSpendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BillCollectSpend::factory()->count(70)->create();
    }
}

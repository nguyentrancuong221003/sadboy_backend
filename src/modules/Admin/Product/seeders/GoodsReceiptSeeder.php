<?php
namespace Modules\Admin\Product\seeders;

use Illuminate\Database\Seeder;
use  Modules\Admin\Product\src\Models\GoodsReceipt;

class GoodsReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GoodsReceipt::factory()->count(60)->create();
    }
}

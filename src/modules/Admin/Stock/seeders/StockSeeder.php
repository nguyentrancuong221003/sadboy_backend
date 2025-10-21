<?php

namespace Modules\Admin\Stock\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Stock\src\Models\Stock;
class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stocks = ['Kho hoàng mai', 'Kho vĩnh hưng', 'Kho tân mai', 'kho lĩnh nam', 'Kho vĩnh tuy', 'Kho Thanh xuân'];
        foreach($stocks as $stock) {
            Stock::factory()->create([
                'name' => $stock
            ]);
        }
    }
}

<?php

namespace Modules\Admin\Cash_book\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Cash_book\src\Models\IncomeSpend;
use Carbon\Carbon;
class IncomeSpendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 30; $i++){
            IncomeSpend::factory()->create([
                'date' => Carbon::create(2025, 8, $i),
            ]);
        }
        for ($i = 1; $i <= 30; $i++){
            IncomeSpend::factory()->create([
                'date' => Carbon::create(2025, 7, $i),
            ]);
        }
        for ($i = 1; $i <= 30; $i++){
            IncomeSpend::factory()->create([
                'date' => Carbon::create(2025, 7, $i),
            ]);
        }
    }
}

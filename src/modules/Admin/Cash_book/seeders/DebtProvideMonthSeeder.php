<?php

namespace Modules\Admin\Cash_book\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Cash_book\src\Models\DebtProvidesMonth;
use Carbon\Carbon;
class DebtProvideMonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($m = 1; $m <= 8; $m++) {
            DebtProvidesMonth::factory()->create([
                'date'  => Carbon::create(2025, $m, 1), // ngày đầu tiên của tháng
            ]);
        }
        for ($m = 1; $m <= 12; $m++) {
            DebtProvidesMonth::factory()->create([
                'date'  => Carbon::create(2024, $m, 1), // ngày đầu tiên của tháng
            ]);
        }
        for ($m = 1; $m <= 12; $m++) {
            DebtProvidesMonth::factory()->create([
                'date'  => Carbon::create(2023, $m, 1), // ngày đầu tiên của tháng
            ]);
        }
        for ($m = 1; $m <= 12; $m++) {
            DebtProvidesMonth::factory()->create([
                'date'  => Carbon::create(2022, $m, 1), // ngày đầu tiên của tháng
            ]);
        }
    }
}

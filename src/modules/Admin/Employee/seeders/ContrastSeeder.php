<?php

namespace Modules\Admin\Employee\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Employee\src\Models\Contrast;
class ContrastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contrasts = [
            [
                'code' => 'C001',
                'name' => 'Hợp đồng lao động chính thức',
                'status' => 'ACT'
            ],
            [
                'code' => 'C002',
                'name' => 'Hợp đồng thử việc',
                'status' => 'ACT'
            ],
            [
                'code' => 'C003',
                'name' => 'Mức lương cơ bản',
                'status' => 'ACT'
            ],
            [
                'code' => 'C004',
                'name' => 'Thời gian làm việc',
                'status' => 'ACT'
            ],
            [
                'code' => 'C005',
                'name' => 'Chế độ nghỉ phép',
                'status' => 'ACT'
            ],
            [
                'code' => 'C006',
                'name' => 'Thưởng lễ tết',
                'status' => 'ACT'
            ],
            [
                'code' => 'C007',
                'name' => 'Bảo hiểm xã hội',
                'status' => 'ACT'
            ]
        ];
        foreach($contrasts as $contrast){
            Contrast::create($contrast);
        }
    }
}

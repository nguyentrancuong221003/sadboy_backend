<?php

namespace Modules\Admin\Employee\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Employee\src\Models\Grant;
class GrantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grants = [
            [
                'code' => "GR001",
                'name' => "Trợ cấp học tập",
                'money' => 1000000,
                'type' => "Học bổng",
                'status' => "ACT",
                'description' => "Trợ cấp dành cho sinh viên có thành tích học tập xuất sắc"
            ],
            [
                'code' => "GR002",
                'name' => "Trợ cấp khó khăn",
                'money' => 500000,
                'type' => "Hỗ trợ xã hội",
                'status' => "ACT",
                'description' => "Trợ cấp hỗ trợ cho người gặp khó khăn tài chính"
            ],
            [
                'code' => "GR003",
                'name' => "Trợ cấp công tác",
                'money' => 200,
                'type' => "Hỗ trợ công tác",
                'status' => "EXP",
                'description' => "Trợ cấp dành cho nhân viên đi công tác nước ngoài"
            ],
            [
                'code' => "GR004",
                'name' => "Trợ cấp y tế",
                'money' => 1500000,
                'type' => "Hỗ trợ y tế",
                'status' => "ACT",
                'description' => "Trợ cấp cho nhân viên điều trị bệnh"
            ],
            [
                'code' => "GR005",
                'name' => "Trợ cấp nhà ở",
                'money' => 3000000,
                'type' => "Hỗ trợ nhà ở",
                'status' => "ACT",
                'description' => "Trợ cấp hỗ trợ chi phí nhà ở cho nhân viên"
            ],
            [
                'code' => "GR006",
                'name' => "Trợ cấp năng suất",
                'money' => 100,
                'type' => "Thưởng",
                'status' => "ACT",
                'description' => "Thưởng năng suất làm việc cao"
            ]
        ];

        foreach($grants as $grant) {
            Grant::create($grant);
        }
    }
}

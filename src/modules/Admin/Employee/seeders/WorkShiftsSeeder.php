<?php

namespace Modules\Admin\Employee\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Employee\src\Models\WorkShifts;
class WorkShiftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workShifts = [
            [
                'code' => 'WS1',
                'name' => 'Ca sáng',
                'start_hour' => '07:00',
                'end_hour' => '11:00',
                'duration' => '4h',
                'status' => 'ACTIVE',
                'description' => 'Ca làm việc buổi sáng từ 7h đến 11h'
            ],
            [
                'code' => 'WS2',
                'name' => 'Ca trưa',
                'start_hour' => '11:00',
                'end_hour' => '15:00',
                'duration' => '4h',
                'status' => 'ACTIVE',
                'description' => 'Ca làm việc buổi trưa từ 11h đến 15h'
            ],
            [
                'code' => 'WS3',
                'name' => 'Ca chiều',
                'start_hour' => '13:00',
                'end_hour' => '17:00',
                'duration' => '4h',
                'status' => 'ACTIVE',
                'description' => 'Ca làm việc buổi chiều từ 13h đến 17h'
            ],
            [
                'code' => 'WS4',
                'name' => 'Ca tối',
                'start_hour' => '17:00',
                'end_hour' => '21:00',
                'duration' => '4h',
                'status' => 'ACTIVE',
                'description' => 'Ca làm việc buổi tối từ 17h đến 21h'
            ],
            [
                'code' => 'WS5',
                'name' => 'Ca đêm',
                'start_hour' => '22:00',
                'end_hour' => '06:00',
                'duration' => '8h',
                'status' => 'ACTIVE',
                'description' => 'Ca làm việc ban đêm từ 22h hôm trước đến 6h hôm sau'
            ],
            [
                'code' => 'WS6',
                'name' => 'Ca hành chính',
                'start_hour' => '08:00',
                'end_hour' => '17:00',
                'duration' => '8h',
                'status' => 'ACTIVE',
                'description' => 'Ca hành chính toàn thời gian, nghỉ trưa từ 12h đến 13h'
            ],
            [
                'code' => 'WS7',
                'name' => 'Ca linh hoạt',
                'start_hour' => '09:00',
                'end_hour' => '15:00',
                'duration' => '6h',
                'status' => 'ACTIVE',
                'description' => 'Ca làm việc linh hoạt dành cho bán thời gian hoặc part-time'
            ]
        ];

        foreach($workShifts as $workShift){
            WorkShifts::create($workShift);
        }
    }
}

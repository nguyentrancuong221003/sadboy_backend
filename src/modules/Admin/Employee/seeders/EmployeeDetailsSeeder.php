<?php

namespace Modules\Admin\Employee\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Employee\src\Models\EmployeeDetails;
class EmployeeDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployeeDetails::create([
            'employee_id' => 1,
            'date_birth' => '2003-10-22',
            'date_start_work' => '2025-08-08',
            'salary' => '456876',
            'diploma' => 'DAIHOC',
            'status' => 'DOCTHAN',
            'date_sign_contrast' => '2025-02-19',
            'date_effect_contrast' => '2004-12-22',
            'date_end_contrast' => '2028-10-15',
            'work_shift_id' => 1,
            'position_id' => 1,
            'department_id' => 1,
            'grant_id' => 1,
            'contrast_id' => 1,
        ]);
        foreach (range(2, 61) as $id) {
            EmployeeDetails::factory()->create([
                'employee_id' => $id
            ]);
        }

    }
}


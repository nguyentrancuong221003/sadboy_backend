<?php

namespace Modules\Admin\Employee\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Employee\src\Models\Employee;
use Illuminate\Support\Facades\Hash;
class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'code' => 'sadboyhaycuoi',
            'name' => 'Nguyễn Trần Cường',
            'email' => 'nguyentrancuong58@gmail.com',
            'password' => Hash::make('Cuonga@123'),
            'phone' => '0988870434',
            'img'     => '/storage/images/img_employee/img_employee.jpg',
            'address' => '259 vĩnh hưng, hoàng mai, hà nội',
            'gender' => 'nam'
        ]);
        Employee::factory()->count(60)->create();


    }
}

<?php

namespace Modules\Admin\Employee\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Employee\src\Models\Employee;
use Illuminate\Support\Facades\Hash;
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'code'    => strtoupper('EMP' . $this->faker->unique()->numberBetween(1, 999999)),
            'name'    => $this->faker->name(),
            'email'   => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('Cuonga@123'),
            'phone'   => $this->faker->unique()->numerify('0#########'), // SĐT 10 số
            'img'     => '/storage/images/img_employee/img_employee.jpg',
            'address' => $this->faker->address(),
            'gender'  => $this->faker->randomElement(['nam', 'nu']),
        ];
    }
}

<?php

namespace Modules\Admin\Employee\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Employee\src\Models\EmployeeDetails;
use Illuminate\Support\Facades\Hash;
class EmployeeDetailsFactory extends Factory
{
    protected $model = EmployeeDetails::class;
    public function definition()
    {
        $dateBirth = $this->faker->dateTimeBetween('-60 years', '-18 years');
        $dateStartWork = $this->faker->dateTimeBetween(
            $dateBirth->modify('+18 years'),
            'now'
        );
        $dateSignContract = $this->faker->dateTimeBetween(
            $dateStartWork,
            'now'
        );
        $dateEffectContract = $this->faker->dateTimeBetween(
            $dateSignContract,
            '+1 month'
        );
        $dateEndContract = $this->faker->dateTimeBetween(
            $dateEffectContract,
            '+5 years'
        );

        return [
            'date_birth'          => $dateBirth->format('Y-m-d'),
            'date_start_work'     => $dateStartWork->format('Y-m-d'),
            'salary' => $this->faker->numberBetween(15000000, 500000000),
            'diploma' => $this->faker->randomElement(['DAIHOC', 'THPT', 'THCS', 'CAODANG']),
            'status' => $this->faker->randomElement(['KETHON', 'DOCTHAN', 'LYTHAN', 'THAISAN', 'NGHIVIEC']),
            'date_sign_contrast'  => $dateSignContract->format('Y-m-d'),
            'date_effect_contrast'=> $dateEffectContract->format('Y-m-d'),
            'date_end_contrast'   => $dateEndContract->format('Y-m-d'),
            'work_shift_id' => $this->faker->numberBetween(1, 7),
            'position_id' => $this->faker->numberBetween(1, 13),
            'department_id' => $this->faker->numberBetween(1, 12),
            'grant_id' => $this->faker->numberBetween(1, 6),
            'contrast_id' => $this->faker->numberBetween(1, 7),
        ];
    }
}

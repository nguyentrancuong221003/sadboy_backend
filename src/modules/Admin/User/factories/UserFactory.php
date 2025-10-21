<?php

namespace Modules\Admin\User\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Admin\User\src\Models\User;
use Illuminate\Support\Facades\Hash;
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'code' => strtoupper('USER' . $this->faker->unique()->numberBetween(1, 999999)),
            'name' => $this->faker->name(),
            'img' => '/storage/images/img_user/img_user.jpg',
            'email' => $this->faker->unique()->safeEmail(),
            'phone'   => $this->faker->unique()->numerify('0#########'), // SĐT 10 số
            'password' => Hash::make('Cuonga@123'), // Cuonga@123
        ];
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

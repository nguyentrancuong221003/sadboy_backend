<?php
namespace Modules\Admin\Provide\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Provide\src\Models\Provide;

class ProvideFactory extends Factory
{
    protected $model = Provide::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->bothify('PRV######')),
            'name' => 'Công ty ' . $this->faker->company(),
            'phone' => $this->faker->unique()->numerify('0#########'),
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'img' => '/storage/images/img_provide/img_provide.jpg',
            'note' => $this->faker->sentence(6),
            'status' => 'ACTIVE',
            'created_by' => 'Seeder',
            'updated_by' => null,
        ];
    }
}

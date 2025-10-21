<?php

namespace Modules\Admin\Chat\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Chat\src\Models\Conversation;
class ConversationFactory extends Factory
{
    protected $model = Conversation::class;
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 60),
            'employee_id' => $this->faker->numberBetween(1, 60)
        ];
    }
}

<?php

namespace Modules\Admin\Comment\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Comment\src\Models\Comment;
use Illuminate\Support\Str;
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'code' => 'CMT' . Str::random(10),
            'imgs' => json_encode([]),
            'likes' => $this->faker->numberBetween(0, 50),
            'dislikes' => $this->faker->numberBetween(0, 10),
            'star' => $this->faker->numberBetween(3, 5),
            'user_id' => $this->faker->numberBetween(1, 60),
        ];
    }
}

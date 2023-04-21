<?php

namespace Database\Factories;

use App\Models\Good;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'    => $this->faker->randomElement(User::where('is_locked', 0)->pluck('id')),
            'goods_id'   => $this->faker->randomElement(Good::where('is_on', 1)->whereIn('id', [1,2,3])->pluck('id')),
            'rate'       => $this->faker->numberBetween(1, 3),
            'content'    => $this->faker->text(50),
            'reply'      => $this->faker->text(50),
            'pics'       => [
                'http://placeimg.com/640/480/any',
                'http://placeimg.com/640/480/any',
                'http://placeimg.com/640/480/any',
            ],
        ];
    }
}

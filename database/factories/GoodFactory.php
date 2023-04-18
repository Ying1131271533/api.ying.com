<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Good>
 */
class GoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'      => 1,
            'category_id'  => $this->faker->randomElement(Category::where(['level' => 3, 'status' => 1, 'group' => 'goods'])->pluck('id')),
            'title'        => $this->faker->text(20),
            'description'  => $this->faker->text(40),
            'price'        => $this->faker->randomFloat(2, 1000, 10000),
            'stock'        => $this->faker->numberBetween(10, 100),
            'cover'        => 'http://placeimg.com/640/480/any',
            'pics'         => [
                'http://placeimg.com/640/480/any',
                'http://placeimg.com/640/480/any',
                'http://placeimg.com/640/480/any',
            ],
            'is_on'        => $this->faker->numberBetween(0, 1),
            'is_recommend' => $this->faker->numberBetween(0, 1),
            'details'      => $this->faker->paragraphs(4, true),
        ];
    }
}

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
            'user_id' => 1,
            'category_id' => $this->faker->text(20),
            'title' => $this->faker->randomElement(Category::where(['level' => 3, 'status' => 1, 'group' => 'goods'])->pluck('id')),
            'description' => $this->faker->text(),
            'price' => $this->faker->text(),
            'stock' => $this->faker->text(),
            'cover' => $this->faker->text(),
            'pics' => $this->faker->text(),
            'is_on' => $this->faker->text(),
            'is_recommend' => $this->faker->text(),
            'details' => $this->faker->text(),
        ];
    }
}

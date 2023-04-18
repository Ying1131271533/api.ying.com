<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slied>
 */
class SlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'  => $this->faker->text(20),
            'url'    => '',
            'img'    => 'http://placeimg.com/1920/400/any',
            'status' => 1,
            'sort'   => $this->faker->numberBetween(1, 999),
        ];
    }
}

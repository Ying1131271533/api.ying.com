<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\GoodsType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Good>
 */
class GoodsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'admin_id'      => $this->faker->randomElement([1, 2]),
            'category_id'   => $this->faker->randomElement(Category::where(['level' => 3, 'status' => 1])->pluck('id')),
            'brand_id'      => $this->faker->randomElement(Brand::where('status', 1)->pluck('id')),
            'goods_type_id' => $this->faker->randomElement(GoodsType::pluck('id')),
            'title'         => $this->faker->text(25),
            'cover'         => 'http://placeimg.com/640/480/any',
            'market_price'  => $this->faker->randomFloat(2, 1000, 10000),
            'shop_price'    => $this->faker->randomFloat(2, 1000, 10000) - 200,
            'stock'         => $this->faker->numberBetween(50, 100),
            'sales'         => $this->faker->numberBetween(50, 100),
            'is_on'         => $this->faker->numberBetween(0, 1),
            'is_recommend'  => $this->faker->numberBetween(0, 1),
        ];
    }
}

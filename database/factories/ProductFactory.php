<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\MeasureUnit;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'brand' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'unit_id' => MeasureUnit::factory(),
            'part_num' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'category_id' => Category::factory(),
        ];
    }
}

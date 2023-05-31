<?php

namespace Database\Factories\Product;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{

    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => Str::uuid(),
            'name' => $this->faker->colorName, //I didn't find a property for products name
            'description' => $this->faker->text(),
            'price' => $this->faker->numberBetween(10,1000),
            'deactivated_at' => null
        ];
    }
}

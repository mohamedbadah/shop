<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name=$this->faker->unique()->word(2,true);
        return [
            "name"=>$name,
            'slug'=>Str::slug($name),
            "image"=>$this->faker->imageUrl(200,200),
            "description"=>$this->faker->sentence(15),
            "price"=>$this->faker->randomFloat(1,1,499),
            "price_compare"=>$this->faker->randomFloat(1,500,999),
            "store_id"=>Store::inRandomOrder()->first()->id,
            "category_id"=>Category::inRandomOrder()->first()->id,
            'featured'=>rand(0,1)

        ];
    }
}

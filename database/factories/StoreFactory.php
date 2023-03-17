<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name=$this->faker->word(2,true);
        return [
            "name"=>$name,
            "slug"=>Str::slug($name),
            "logo"=>$this->faker->imageUrl(200,200),
            "description"=>$this->faker->sentence(15),
        ];
    }
}

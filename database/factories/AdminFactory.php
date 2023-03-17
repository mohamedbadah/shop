<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'username'=>$this->faker->unique()->userName,
            'phone'=>$this->faker->unique()->phoneNumber,
            'super_admin'=>$this->faker->boolean,
            'email'=>$this->faker->unique()->email,
            'password'=>Hash::make("password")
        ];
    }
}

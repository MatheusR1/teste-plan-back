<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $min = Brand::orderBy('id')->first()->id;
        $max = Brand::orderByDesc('id')->first()->id;

        $voltages = [110, 220];

        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'brand_id' => rand($min, $max),
            'voltage' => $voltages[rand(0,1)]
        ];
    }
}

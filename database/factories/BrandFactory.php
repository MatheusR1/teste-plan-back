<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $data = ['Electrolux', 'Brastemp', 'Fischer', 'Samsung', 'LG'];

        return [
            'name'  => $data[shuffle($data)]
        ];
    }
}

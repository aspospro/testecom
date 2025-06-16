<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    // Tell Laravel which model this factory is for
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name'        => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'price'       => $this->faker->randomFloat(2, 5, 100),
            'image_url'   => '', // you can fill later
        ];
    }
}

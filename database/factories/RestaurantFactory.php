<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use App\Models\Category;
use App\Models\Cuisine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RestaurantFactory extends Factory
{
    protected $model = Restaurant::class;

    public function definition(): array
    {
        $name = $this->faker->company;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(10),
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'zip_code' => $this->faker->regexify('[0-9]{5}-[0-9]{3}'),
            'phone' => $this->faker->regexify('\([1-9]{2}\) [0-9]{5}-[0-9]{4}'),
            'email' => $this->faker->unique()->safeEmail,
            'website' => $this->faker->url,
            'opening_hours' => 'Seg-Dom: 12h-23h',
            'latitude' => $this->faker->latitude(-33, -2),
            'longitude' => $this->faker->longitude(-56, -34),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'cuisine_id' => Cuisine::factory(),
            'is_active' => true,
        ];
    }
}

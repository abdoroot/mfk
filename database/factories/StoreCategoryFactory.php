<?php

namespace Database\Factories;

use App\Models\StoreCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreCategoryFactory extends Factory
{

    protected $model = StoreCategory::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => [
                'ar' => $this->faker->word,
                'en' => $this->faker->word,
            ],
            'status' => 1,
            'is_featured' => 0,
            'color' => '',
            'description' => [
                'ar' => $this->faker->text,
                'en' => $this->faker->text,
            ]
        ];
    }
}

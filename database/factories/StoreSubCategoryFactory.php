<?php

namespace Database\Factories;

use App\Models\StoreSubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreSubCategoryFactory extends Factory
{
    protected $model = StoreSubCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => [
                'ar' => $this->faker->name,
                'en' => $this->faker->name,
            ],
            'store_category_id' => $this->faker->numberBetween(1,10),
            'status' => 1,
            'is_featured' => 0,
            'description' => [
                'ar' => $this->faker->text,
                'en' => $this->faker->text,
            ]
        ];
    }
}

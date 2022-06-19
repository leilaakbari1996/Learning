<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GuidanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'Title'=>$this->faker->title,
            'Description'=>$this->faker->text,
            'Order'=>rand(1,6),
            'Slug'=>$this->faker->unique()->slug,
            'IconURL'=>$this->faker->url,
            'ImageURL'=>$this->faker->url,
            'VideoURL'=>$this->faker->url,
            'IsEnable'=>rand(0,1),
            'IsSpecial'=>rand(0,1)
        ];
    }
}

<?php

namespace Database\Factories;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\blog>
 */
class BlogFactory extends Factory
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
            'Text'=>$this->faker->text,
            'ImageURl'=>$this->faker->imageUrl,
            'ThumbnailURl'=>$this->faker->imageUrl,
            'Views'=>rand(1,10000),
            'Save'=>rand(1,1000),
            'Like'=>rand(1,1000),
            'Slug'=>$this->faker->slug,
            'IsNew'=>rand(0,1),
            'IsEnable'=>rand(0,1),
            'SeoTitle'=>$this->faker->unique()->slug,
            'SeoDescription'=>$this->faker->title,
            'author_id'=> rand(1,20),
        ];
    }
}

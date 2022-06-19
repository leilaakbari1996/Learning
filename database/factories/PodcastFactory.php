<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Podcast>
 */
class PodcastFactory extends Factory
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
            'Slug'=>$this->faker->unique()->slug,
            'AudioURl'=>$this->faker->url,
            'ImageURL'=>$this->faker->url,
            'ThumbnailURl'=>$this->faker->url,
            'IsEnable'=>rand(0,1),
            'IsNew'=>rand(0,1),
            'IsSpecial'=>rand(0,1),
            'Order'=>rand(1,5),
            'SeoTitle'=>$this->faker->unique()->slug,
            'SeoDescription'=>$this->faker->title,
        ];
    }
}

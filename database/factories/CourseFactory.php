<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'Title'=>$this->faker->name(),
            'Description'=>$this->faker->name(),
            'AfterBuyDescription'=>$this->faker->name(),
            'Slug'=>$this->faker->unique()->name(),
            'Price'=>$this->faker->numerify,
            'Discount'=>rand(1,100),
            'Images'=>'{}',
            'Videos'=>'{}',
            'PreviewImageURl'=>$this->faker->name,
            'Type'=>'Online',
            'Order'=>rand(1,4),
            'Views'=>rand(1,8766554),
            'Likes'=>rand(1,99999),
            'TotalTime'=>rand(1000,8999999),
            'NumberOfBuys'=>rand(1,6666),
            'IsFree'=>rand(0,1),
            'IsSpecial'=>rand(0,1),
            'IsNew'=>rand(0,1),
            'IsEnable'=>rand(0,1),
            'Level'=>rand(1,4),
            'Status'=>'End',
            'UpdateDate'=>$this->faker->dateTime,
            'FAQ'=>'{}',
            'SeoTitle'=>$this->faker->name(),
            'SeoDescription'=>$this->faker->name(),
        ];
    }
    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

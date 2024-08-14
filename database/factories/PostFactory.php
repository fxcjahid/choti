<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * 
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $faker = \Faker\Factory::create('bn_BD');

        return [
            'title'   => $faker->sentence(6), // Title in Bangla
            'user_id' => 11,
            'content' => $faker->paragraph(6), // Content in Bangla
            'summary' => $faker->text(100), // Summary in Bangla
            'status'  => 'publish',
        ];
    }
}
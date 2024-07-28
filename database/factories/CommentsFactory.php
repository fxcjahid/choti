<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentsFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'user_id' =>  User::factory(),
			'post_id' =>  Post::factory(),
			'text'	  =>  $this->faker->sentence(5),
			'status'  => 'publish',
		];
	}
}
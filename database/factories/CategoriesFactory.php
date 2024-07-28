<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriesFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'name' 		=> $this->faker->unique()->word(),
			'user_id' 	=> User::factory(),
			'is_active' => $this->faker->boolean(),
		];
	}
}
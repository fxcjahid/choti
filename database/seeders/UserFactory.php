<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

class UserFactory extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// User::create([
		// 	'first_name' 	=> 'Fxc',
		// 	'last_name' 	=> 'Jahid',
		// 	'username' 		=> 'fxcjahid',
		// 	'email' 		=> 'fxcjahid3@gmail.com',
		// 	'password' 		=> bcrypt(123456),
		// 	'email_verified_at' => now(),
		// ]);
		User::create([
			'first_name' 	=> 'Youssef',
			'last_name' 	=> 'akiki',
			'username' 		=> 'youssef.akiki',
			'email' 		=> 'youssef.akiki@gmail.com',
			'password' 		=> bcrypt(123456),
			'email_verified_at' => now(),
		]);
	}
}
<?php

use App\Models\City;
use Illuminate\Support\Str;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
	$this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fxcjahid', function () {
	$this->comment('Hi this is Fxcjaihd <fxcjahid3@gmail.com>');
})->purpose('Show developer profile');

Artisan::command('generate:city-slug', function () {

	$cities = City::where('city_slug', '=', '')
		->get();

	foreach ($cities as $city) {
		City::where('id', $city->id)
			->update([
				'city_slug' => str::slug($city->city_name),
			]);
	}
	$this->info('slug generate done');
});

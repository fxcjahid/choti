<?php

namespace App\Support\ReadTimeLocales;

use Illuminate\Support\Str;
use Leshkens\LaravelReadTime\Contracts\LocaleInterface;

class Fr implements LocaleInterface
{
	protected $unitMap = [
		'second' => 'seconde',
		'minute' => 'minute',
		'hour'   => 'heure'
	];

	public function result(int $number, string $unit): string
	{
		$unit = Str::plural($this->unitMap[$unit], $number);
		$text = sprintf('environ %s %s', $number, $unit);
		return $text;
	}
}
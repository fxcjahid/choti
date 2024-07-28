<?php

return [

	/*
     * Global options
     */
	'options' => [
		'words_per_minute' => 300,
		'strip_tags'       => true,  // Clear result string of html tags
		'units'            => [
			/*
             * How many seconds does a new unit start with
             */
			'second' => 0,
			'minute' => 60,
			//'hour'   => 3600
		]
	],

	/*
     * Words counter
     */
	'counter' => Leshkens\LaravelReadTime\Counter::class,

	'locales' => [
		'en' => Leshkens\LaravelReadTime\Locales\En::class,
		'fr' => App\Support\ReadTimeLocales\Fr::class
	]
];
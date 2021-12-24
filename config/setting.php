<?php

use MichaelNabil230\LaravelSetting\Models\Setting;

return [
	/*
	|--------------------------------------------------------------------------
	| Default Settings Store
	|--------------------------------------------------------------------------
	|
	| This option controls the default settings store that gets used while
	| using this settings library.
	|
	| Supported: "json", "database"
	|
	*/
	'default' => 'json',

	/*
	|--------------------------------------------------------------------------
	| Drivers Store
	|--------------------------------------------------------------------------
	|
	| The settings are stored.
	|
	*/

	'drivers' => [
		'database' => [
			'model' => Setting::class,
			'table' => 'settings', // name of tabele in dataBase
			'keyColumn' => 'key', // the key of key
			'valueColumn' => 'value', // the key of value

			'cache' => [
				'enableCache' => false,
				'forgetCacheByWrite' => true, // Whether to reset the cache when changing a setting.
				'cacheTtl' => 15, // TTL in seconds.
			]
		],

		'json' => [
			'path' => storage_path('settings.json'),
		],
	],
];

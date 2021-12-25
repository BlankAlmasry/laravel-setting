# Laravel Setting

[![Issues](https://img.shields.io/github/issues/michaelnabil230/laravel-setting)](https://github.com/michaelnabil230/laravel-setting/issues)
[![Stars](https://img.shields.io/github/stars/michaelnabil230/laravel-setting)](https://github.com/michaelnabil230/laravel-setting/stargazers)
![Forks](https://img.shields.io/github/forks/michaelnabil230/laravel-setting)
[![License](https://img.shields.io/github/license/michaelnabil230/laravel-setting)](https://github.com/michaelnabil230/laravel-setting/blob/main/LICENSE)

Persistent, application-wide settings for Laravel.

Despite the package name, this package should work with Laravel 8 (though some versions are not automatically tested).

## Installation

1. `composer require michaelnabil230/laravel-setting`
2. Publish the config file by
   running `php artisan vendor:publish --provider="MichaelNabil230\LaravelSetting\SettingServiceProvider" --tag="config"`
   . The config file will give you control over which storage engine to use as well as some storage-specific settings.

## Usage

Call `setting()->save()` explicitly to save changes made.

You could also use the `setting()` helper:

```php
// Get the store instance
setting();

// Get values
setting('foo');
setting('foo.bar');
setting('foo', 'default value');
setting()->get('foo');
setting()->get('foo.bar');

// Set values
setting(['foo' => 'bar'])->save();
setting(['foo.bar' => 'baz'])->save();
setting()->set('foo', 'bar')->save();

// Method chaining
setting(['foo' => 'bar'])->save();
```

### Command line helper

```
php artisan setting:forget foo
php artisan setting:get || php artisan setting:get foo
php artisan setting:set-or-update foo bar
```

### Database storage

#### Using Migration File

If you use the database store you need to
run `php artisan vendor:publish --provider="MichaelNabil230\LaravelSetting\SettingServiceProvider" --tag="migrations"`
and `php artisan migrate`

### Store cache

When reading from the store, you can enable the cache.

You can also configure flushing of the cache when writing and configure time to live.

Reading will come from the store, and then from the cache, this can reduce load on the store.

```php
'cache' => [
  'enableCache' => false,
  'forgetCacheByWrite' => true, // Whether to reset the cache when changing a setting.
  'cacheTtl' => 15, // TTL in seconds.
]
```

# Configuration

### Default:

```php
<?php

// config/setting.php

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

    // ...
];
```

You can specify here your default store driver that you would to use.

### Drivers:

```php
<?php

// config/setting.php

return [
    //...
    
    /*
    |--------------------------------------------------------------------------
    | Drivers Stores
    |--------------------------------------------------------------------------
    |
    | The settings are stored.
    |
    */
    
    'drivers' => [
        'database' => [
            'driver' => MichaelNabil230\LaravelSetting\Stores\DatabaseSettingStore::class,
            'options' => [
                'model' => Setting::class,
                'table' => 'settings', // name of table in dataBase
                'keyColumn' => 'key', // the key of key
                'valueColumn' => 'value', // the key of value
                'cache' => [
                    'enableCache' => false,
                    'forgetCacheByWrite' => true, // Whether to reset the cache when changing a setting.
                    'cacheTtl' => 15, // TTL in seconds.
                ]
            ],
        ],

        'json' => [
            'driver' => MichaelNabil230\LaravelSetting\Stores\JsonSettingStore::class,
            'options' => [
                'path' => storage_path('settings.json'),
            ]
        ],
    ],
];
```

This is the list of the supported store drivers. You can expand this list by adding a custom store driver.

The store config is structured like this:

```php
<?php 

// ...
'custom' => [
    'driver'  => App\Stores\CustomStore::class,
    
    'options' => [
        // ...
    ],
],
```

##### 1. Create the Custom Store class

```php
<?php 

namespace App\Settings;

use MichaelNabil230\LaravelSetting\Stores\AbstractStore as Store;

class CustomStore implements Store
{
    // Implement the contract's methods here
} 
```

##### 2. Register the Custom Store

Go to the `config/setting.php` config file and edit the `drivers` list:

```php
return [
    'drivers' => [
        'custom' => [
            'driver'  => App\Settings\CustomStore::class,
        ],
    ],
];
```

If you used the abstract `MichaelNabil230\LaravelSetting\Stores\AbstractStore` class, you can pass a `options` array
like credential keys, path ...

```php
return [
    'drivers' => [
        'custom' => [
            'driver'  => App\Settings\CustomStore::class,
            'options' => [
                // more customize
            ],
        ],
    ],
];
``` 

Last and not least, you can set it as the `default` store.

## Contact

Open an issue on GitHub if you have any problems or suggestions.

## License

The contents of this repository is released under the [MIT license](http://opensource.org/licenses/MIT).

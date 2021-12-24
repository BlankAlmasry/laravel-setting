# Laravel Setting

[![Issues](https://img.shields.io/github/issues/michaelnabil230/laravel-setting?style=flat&logo=appveyor)](https://github.com/michaelnabil230/laravel-setting/issues)
[![Stars](https://img.shields.io/github/stars/michaelnabil230/laravel-setting?style=flat&logo=appveyor)](https://github.com/michaelnabil230/laravel-setting/stargazers)
[![License](https://img.shields.io/github/license/michaelnabil230/laravel-setting?style=flat&logo=appveyor)](https://github.com/michaelnabil230/laravel-setting/blob/master/LICENSE)

Persistent, application-wide settings for Laravel.

Despite the package name, this package should work with Laravel 8 (though some versions are not automatically tested).

## Installation

1. `composer require michaelnabil230/laravel-setting`
2. Publish the config file by
   running `php artisan vendor:publish --provider="MichaelNabil230\LaravelSetting\ServiceProvider" --tag="config"`. The
   config file will give you control over which storage engine to use as well as some storage-specific settings.

## Usage

You can either access the setting store via its facade or inject it by type-hinting towards the abstract
class `MichaelNabil230\LaravelSetting\SettingStore`.

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

// Set values
setting(['foo' => 'bar']);
setting(['foo.bar' => 'baz']);
setting()->set('foo', 'bar');

// Method chaining
setting(['foo' => 'bar'])->save();
```

### Store cache

When reading from the store, you can enable the cache.

You can also configure flushing of the cache when writing and configure time to live.

Reading will come from the store, and then from the cache, this can reduce load on the store.

```php
// Cache usage configurations.
'enableCache' => false,
'forgetCacheByWrite' => true,
'cacheTtl' => 15,
```

### Database storage

#### Using Migration File

If you use the database store you need to
run `php artisan vendor:publish --provider="MichaelNabil230\LaravelSetting\ServiceProvider" --tag="migrations"`
and `php artisan migrate`

## Contact

Open an issue on GitHub if you have any problems or suggestions.

## License

The contents of this repository is released under the [MIT license](http://opensource.org/licenses/MIT).

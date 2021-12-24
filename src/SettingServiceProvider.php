<?php

namespace MichaelNabil230\LaravelSetting;

use Illuminate\Support\ServiceProvider;
use MichaelNabil230\LaravelSetting\SettingManager;
use MichaelNabil230\LaravelSetting\Store\SettingStore;
use MichaelNabil230\LaravelSetting\Console\Commands\SetOrUpdateKey;
use MichaelNabil230\LaravelSetting\Console\Commands\ForgetSetting;
use MichaelNabil230\LaravelSetting\Console\Commands\GetAllSetting;
use MichaelNabil230\LaravelSetting\Console\Commands\GetOnlySetting;

/**
 *
 * @author   Michael Nabil <michaelnabil926@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  settings-for-laravel
 */
class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Bind the manager as a singleton on the container.
        $this->app->singleton(SettingManager::class, function ($app) {
            return new SettingManager($app);
        });

        // Provide a shortcut to the SettingStore for injecting into classes.
        $this->app->bind(SettingStore::class, function ($app) {
            return $app->make(SettingManager::class)->driver();
        });

        $this->mergeConfigFrom(
            __DIR__ . '../../config/setting.php',
            'setting'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->commands([
            GetAllSetting::class,
            ForgetSetting::class,
            GetOnlySetting::class,
            SetOrUpdateKey::class,
        ]);

        if ($this->app->runningInConsole()) {
            if ($this->app['config']['setting.default'] == 'database') {
                $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
            }
        }

        $this->publishes([
            __DIR__ . '/../config/setting.php' => config_path('setting.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migration.php' => database_path('migrations/' . date('Y_m_d_His') . '_create_settings_table.php')
        ], 'migrations');
    }
}

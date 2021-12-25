<?php

namespace MichaelNabil230\LaravelSetting;

use Illuminate\Support\ServiceProvider;
use MichaelNabil230\LaravelSetting\Console\Commands\ForgetSetting;
use MichaelNabil230\LaravelSetting\Console\Commands\GetSetting;
use MichaelNabil230\LaravelSetting\Console\Commands\SetOrUpdateSetting;
use MichaelNabil230\LaravelSetting\Stores\AbstractStore;

/**
 *
 * @author   Michael Nabil <michaelnabil926@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  laravel-setting
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
        $this->app->extend(SettingManager::class, function (SettingManager $manager, $app) {
            foreach ($app['config']->get('setting.drivers', []) as $driver => $params) {
                $manager->registerStore($driver, $params);
            }

            return $manager;
        });

        // Provide a shortcut to the SettingStore for injecting into classes.
        $this->app->bind(AbstractStore::class, function ($app) {
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
            GetSetting::class,
            ForgetSetting::class,
            SetOrUpdateSetting::class,
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

<?php

namespace MichaelNabil230\LaravelSetting;

use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(SettingsManager::class, function ($app) {
            return new SettingsManager($app);
        });

        // Provide a shortcut to the SettingStore for injecting into classes.
        $this->app->bind(SettingStore::class, function ($app) {
            return $app->make(SettingsManager::class)->driver();
        });

        $this->app->alias(SettingStore::class, 'setting');

        $this->mergeConfigFrom(__DIR__ . '/stub/config.stub', 'settings');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/stub/config.stub' => config_path('settings.php')
        ], 'config');
        $this->publishes([
            __DIR__ . '/stub/migration.stub' => database_path('migrations/' . date('Y_m_d_His') . '_create_settings_table.php')
        ], 'migrations');
    }
}

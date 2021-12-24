<?php

namespace MichaelNabil230\LaravelSetting;

use Illuminate\Support\Manager;
use MichaelNabil230\LaravelSetting\Store\DatabaseSettingStore;
use MichaelNabil230\LaravelSetting\Store\JsonSettingStore;

/**
 *
 * @author   Michael Nabil <michaelnabil926@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  settings-for-laravel
 */
class SettingsManager extends Manager
{

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get('settings.default', 'json');
    }

    public function createJsonDriver()
    {
        $path = $this->config->get('settings.drivers.path', storage_path('settings.json'));

        $store = new JsonSettingStore($path, $this->container['files'],);

        return $store;
    }

    public function createDatabaseDriver()
    {
        $database = $this->config->get('settings.drivers.database');

        $store = new DatabaseSettingStore($database, $this->container['cache']);

        return $store;
    }
}

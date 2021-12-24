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
class SettingManager extends Manager
{

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get('setting.default', 'json');
    }

    public function createJsonDriver()
    {
        $path = $this->config->get('setting.drivers.json.path', storage_path('setting.json'));

        $store = new JsonSettingStore($path, $this->container['files']);

        return $store;
    }

    public function createDatabaseDriver()
    {
        $database = $this->config->get('setting.drivers.database');

        $store = new DatabaseSettingStore($database, $this->container['cache']);

        return $store;
    }
}

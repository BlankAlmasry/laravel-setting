<?php

namespace MichaelNabil230\LaravelSetting\Store;

use Illuminate\Support\Arr;

/**
 *
 * @author   Michael Nabil <michaelnabil926@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  settings-for-laravel
 */
abstract class SettingStore
{
    /**
     * Get a specific key from the settings data.
     *
     * @param string $key
     * @param string $default
     *
     * @return mixed
     */
    public function get($key, $default = null): mixed
    {
        $this->checkLoaded();

        return Arr::get($this->data, $key, $default);
    }

    /**
     * Check loaded the data from the store.
     *
     * @return void
     */
    abstract protected function checkLoaded(): void;

    /**
     * Set a specific key to a value in the settings data.
     *
     * @param string|array $key
     * @param mixed $value
     *
     * @return $this
     */
    public function set($key, $value = null)
    {
        $this->checkLoaded();

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                Arr::set($this->data, $k, $v);
            }
        } else
            Arr::set($this->data, $key, $value);

        return $this;
    }

    /**
     * Determine if a key exists in the settings data.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        $this->checkLoaded();

        return Arr::has($this->data, $key);
    }

    /**
     * Save any changes done to the settings data.
     *
     * @return $this
     */
    public function save()
    {
        $this->write($this->data);

        return $this;
    }

    /**
     * Write the data into the store.
     *
     * @param array $data
     *
     * @return void
     */
    abstract protected function write(array $data);

    /**
     * Get all settings data.
     *
     * @return array
     */
    public function all(): array
    {
        $this->checkLoaded();

        return $this->data;
    }

    /**
     * Unset a key in the settings data.
     *
     * @param string $key
     *
     * @return $this
     */
    abstract protected function forget($key);

    /**
     * Unset all keys in the settings data.
     *
     * @return $this
     */
    abstract protected function forgetAll();
}

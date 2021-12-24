<?php

namespace MichaelNabil230\LaravelSetting\Store;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use RuntimeException;

/**
 *
 * @author   Michael Nabil <michaelnabil926@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  settings-for-laravel
 */
class JsonSettingStore extends SettingStore
{
    /** @var  string */
    protected $path;

    /**
     * The settings data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * @param string $path
     * @param \Illuminate\Filesystem\Filesystem $files
     *
     * @return void
     */
    public function __construct($path = null, Filesystem $files)
    {
        $this->setPath($path);
        $this->files = $files;
    }

    /**
     * Set the storage path for the json file.
     *
     * @param string $path
     *
     * @return self
     */
    private function setPath($path)
    {
        // If the file does not already exist, we will attempt to create it.
        if (!$this->files->exists($path)) {
            $result = $this->files->put($path, '{}');
            if ($result === false) {
                throw new \InvalidArgumentException("Could not write to $path.");
            }
        }

        if (!$this->files->isWritable($path)) {
            throw new \InvalidArgumentException("$path is not writable.");
        }

        $this->path = $path;
    }

    /**
     * Unset a key in the settings data.
     *
     * @param string $key
     *
     * @return $this
     */
    public function forget($key)
    {
        $this->checkLoaded();

        Arr::forget($this->data, $key);

        $contents = $this->data ? json_encode($this->data) : '{}';

        $this->files->put($this->path, $contents);

        return $this;
    }

    /**
     * Read the data from the store.
     *
     * @return void
     */
    protected function checkLoaded(): void
    {
        $contents = $this->files->get($this->path);
        $data = json_decode($contents, true);

        if (is_null($data)) {
            throw new RuntimeException("Invalid JSON file in [{$this->path}]");
        }

        $this->data = Arr::undot($data);
    }

    /**
     * Unset all keys in the settings data.
     *
     * @return $this
     */
    public function forgetAll()
    {
        $contents = '{}';

        $this->files->put($this->path, $contents);

        return $this;
    }

    /**
     * Write the data into the store.
     *
     * @param array $data
     */
    protected function write(array $data)
    {
        $contents = $data ? json_encode($data) : '{}';

        $this->files->put($this->path, $contents);
    }
}

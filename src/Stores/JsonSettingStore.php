<?php

namespace MichaelNabil230\LaravelSetting\Stores;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use RuntimeException;

/**
 *
 * @author   Michael Nabil <michaelnabil926@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  laravel-setting
 */
class JsonSettingStore extends AbstractStore
{
    /**
     * The path.
     *
     * @var array
     */
    protected $path = [];

    /**
     * The files.
     *
     * @var Filesystem
     */
    protected $files = null;

    /**
     * The settings data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * @param array $options
     * @param Filesystem $files
     *
     * @return void
     */
    public function __construct($options = [], Filesystem $files)
    {
        $path = $this->path = $options['path'];

        $this->files = $files;

        // If the file does not already exist, we will attempt to create it.
        if (!$files->exists($path)) {
            $result = $files->put($path, '{}');
            if ($result === false) {
                throw new \InvalidArgumentException("Could not write to $path.");
            }
        }

        if (!$files->isWritable($path)) {
            throw new \InvalidArgumentException("$path is not writable.");
        }
    }

    /**
     * Unset a key in the settings data.
     *
     * @param string $key
     *
     * @return bool
     */
    public function forget($key)
    {
        $this->checkLoaded();

        Arr::forget($this->data, $key);

        $contents = $this->data ? json_encode($this->data) : '{}';

        $this->files->put($this->path, $contents);

        return true;
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
     * @return bool
     */
    public function forgetAll()
    {
        $contents = '{}';

        $this->files->put($this->path, $contents);

        return true;
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

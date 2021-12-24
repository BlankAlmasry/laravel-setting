<?php

namespace MichaelNabil230\LaravelSetting\Console\Commands;

use Illuminate\Console\Command;

class GetAllSetting extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'setting:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all settings.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $setting = setting()->all();
        $this->table(
            [
                'key',
                'value',
            ],
            collect($setting)
                ->map(function ($item, $key) {
                    return ['key' => $key, 'value' => $item];
                })
        );
    }
}

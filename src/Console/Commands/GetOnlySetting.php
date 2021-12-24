<?php

namespace MichaelNabil230\LaravelSetting\Console\Commands;

use Illuminate\Console\Command;

class GetOnlySetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:get {key : Setting key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get one key and value of an item in the setting.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $key = $this->argument('key');
        $setting = setting($key);

        if (is_array($setting)) {
            $data = collect($setting)
                ->map(function ($item, $key) {
                    return ['key' => $key, 'value' => $item];
                });
        } else {
            $data = [
                [
                    'key' => $key,
                    'value' => $setting
                ]
            ];
        }
        $this->table(
            [
                'key',
                'value',
            ],
            $data
        );
    }
}

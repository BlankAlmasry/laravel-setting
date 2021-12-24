<?php

namespace MichaelNabil230\LaravelSetting\Console\Commands;

use Illuminate\Console\Command;

class SetOrUpdateSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:set-or-update {key : Setting key} {value : Setting value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set new or update key and value of an item in the setting.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $key = $this->argument('key');
        $value = $this->argument('value');

        setting()->set($key, $value)->save();

        if (setting()->has($key)) {
            $this->info('inserted ' . $key . ' a new setting successfully.');
        } else {
            $this->info('updated ' . $key . ' setting successfully.');
        }
    }
}

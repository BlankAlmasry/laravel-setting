<?php

namespace MichaelNabil230\LaravelSetting\Console\Commands;

use Illuminate\Console\Command;

class ForgetSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:forget {key* : Setting key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Forget one or more settings.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $key = $this->argument('key');

        if (setting()->has($key)) {
            if (setting()->forget($key)) {
                $this->info('Forget one or more settings successfully.');
            } else {
                $this->error('Error.');
            }
        } else {
            $this->error('No setting matches the given key.');
        }
    }
}

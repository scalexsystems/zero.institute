<?php

namespace Scalex\Zero\Console\Commands\V05;

use Illuminate\Console\Command;

class UpgradeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zero:upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade to version 0.5; Run all zero:upgrade-0.5* commands';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Upgraded to version 0.5');
    }
}

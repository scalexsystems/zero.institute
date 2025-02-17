<?php

namespace Scalex\Zero\Console\Commands\V04;

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
    protected $description = 'Upgrade to version 0.4; Run all zero:upgrade-0.4* commands';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('zero:upgrade-0.4-create-school-sessions');
        $this->call('zero:upgrade-0.4-move-course-constraints');
        $this->call('zero:upgrade-0.4-make-course-groups-private');
        $this->info('Upgraded to version 0.5');
    }
}

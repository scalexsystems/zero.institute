<?php

namespace Scalex\Zero\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zero:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install zero on each deployment';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('trust:roles', ['--force' => true]);
        $this->call('cache:clear'); // Update roles.
        $this->call('countries:update');
        $this->call('states:update');
        $this->call('cities:update');
    }
}

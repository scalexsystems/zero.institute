<?php

namespace Scalex\Zero\Console\Commands;

use Illuminate\Console\Command;

class MakeResourceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:resource {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate resource scaffold';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $model = $this->argument('name');
        $class = str_replace('Models/', '', $model);
        $controller = str_replace('Models/', 'Api/', $model).'Controller';
        $policy = str_replace('Models/', '', $model).'Policy';
        $this->call('make:model', ['--migration' => true, 'name' => $model]);
        $this->call('make:transformer', ['name' => $model]);
        $this->call('make:repository', ['name' => $model]);
        $this->call('make:controller', ['name' => $controller]);
        $this->call('make:policy', ['name' => $policy, '--model' => '\Scalex\Zero\Models\\'.$class]);
    }
}

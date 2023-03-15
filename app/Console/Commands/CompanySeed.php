<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Console\Input\InputOption;

class CompanySeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:seed {company}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run one or all seeds for a specific company';

    /**
     * Execute the console command.
     *
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $class = $this->laravel->make('Database\Seeders\Company');

        $class->setContainer($this->laravel)->setCommand($this)->__invoke();
    }
}

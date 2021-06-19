<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallTestServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:install {env=production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $env = $this->argument('env');

        if($env == 'local') {

        } elseif($env == 'testing') {

        } else {

        }
        return 0;
    }
}

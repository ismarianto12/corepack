<?php

namespace Ismarianto\Ismarianto\App\Commands;

use Illuminate\Console\Command;

class IsmariantoInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tazamcore:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all the dependencies';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('***** menginstall aplikasi TABUNGAN ZAM ZAM V.1 - PANIN DUBAI SYARIAH...');
        $this->call('vendor:publish', [
            '--provider' => "Ismarianto\Ismarianto\IsmariantoServiceProvider",
            '--force' => 'yes'
        ]);
    }
}

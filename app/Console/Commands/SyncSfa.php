<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Factories\LibraryFactory;

class SyncSfa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:sfa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync sfa database to the system.';

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
        $lib = LibraryFactory::getInstance('Sync');
        
        $this->info('Synchronization started at '.date('Y-m-d H:m:s'));
        if($lib->sync(true))
        {
        	$this->info('Synchronization finished at '.date('Y-m-d H:m:s'));
        }
        else
        {
        	$this->error('Synchronization failed!');
        }
    }
}

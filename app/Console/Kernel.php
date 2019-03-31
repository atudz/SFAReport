<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PatchReversal;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    	\App\Console\Commands\MakePresenter::class,
    	\App\Console\Commands\MakeWebService::class,
    	\App\Console\Commands\MakeController::class,
    	\App\Console\Commands\MakeFactory::class,
    	\App\Console\Commands\MakeLibrary::class,
        \App\Console\Commands\MakeInterface::class,
    	\App\Console\Commands\MakeType::class,
    	\App\Console\Commands\MakeModel::class,
    	\App\Console\Commands\SyncSfa::class,
    	\App\Console\Commands\ChangeAdminPassword::class,
    	\App\Console\Commands\CleanSalesmanRecords::class,
    	\App\Console\Commands\FixTableLogs::class,
    	PatchReversal::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /* $schedule->command('inspire')
                 ->hourly();
 */        
        $schedule->command('sync:sfa')
        			->dailyAt('3:00')
        			//->withoutOverlapping()
        			->appendOutputTo(storage_path('logs/cron').'/sync1.log');
        
// 		$schedule->command('sync:sfa')
//         			->dailyAt('12:00')
//         			//->withoutOverlapping()
//         			->appendOutputTo(storage_path('logs/cron').'/sync2.log');
        
        $schedule->command('reset:admin_password')
			        ->weekly()
			        ->mondays()
			        ->at('2:30')
			        ->withoutOverlapping()
			        ->appendOutputTo(storage_path('logs/cron').'/password.log');
    }
}

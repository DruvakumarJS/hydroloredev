<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\web\FirebaseNotificationController;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily FCM notification to users';

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
        //\Log::info("Cron is working fine!");
        $fcm = new FirebaseNotificationController;

        $fcm->dynamic_notification();
    }
}

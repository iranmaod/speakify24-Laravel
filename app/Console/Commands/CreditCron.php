<?php

namespace App\Console\Commands;
use App\Models\StudentsCredits;
use Illuminate\Console\Command;
use App\Models\User;
use Auth;
use DB;
class CreditCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // \Log::info("Cron is working fine!");
        
        // $credits = StudentsCredits::all();
        // StudentsCredits::query()->update(['weekly_hours' => 3]);

        // \Log::info("Cron is working fine!");
        // return $this->info('Weekly Hours Updated successfully');
        
        // \Log::info("Cron is working fine!");

    }
}

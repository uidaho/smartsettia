<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanSensordata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sensordata:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old records from the sensordata table.';

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
        $this->comment('Cleaning sensordata table...');
        
        $maxAgeInDays = config('sensordata.delete_records_older_than_days', 365);
        $cutOffDate = Carbon::now()->subDays($maxAgeInDays)->format('Y-m-d H:i:s');
        $amountDeleted = Sensordata::where('created_at', '<', $cutOffDate)->delete();
        
        $this->info("Deleted {$amountDeleted} record(s) from the activity log.");
        
        $this->comment('All done!');
    }
}

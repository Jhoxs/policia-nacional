<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Maintenance\RemindMaintenanceMailAlert;

class SendAlertNextMaintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-alert
                            {--minValues= : Min values to send alert}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $minValues  = $this->option('minValues') ?? 100;
        $intMinValues = intval($minValues);

      
        $sqlQuery = "SELECT T1.id
        FROM (
            SELECT v.id, v.mileage, v.next_mileage, (v.next_mileage - v.mileage) AS proximos
            FROM vehicles v 
            WHERE v.next_mileage IS NOT NULL 
            AND v.next_mileage IS NOT NULL 
            AND v.next_mileage >= v.mileage 
        ) AS T1
        WHERE T1.proximos BETWEEN ? AND ?";

        $results = DB::select( $sqlQuery,[0,$intMinValues]) ?? [];
        
        foreach($results as $res){
            $vehicle = Vehicle::find($res->id);
            $users = $vehicle->users->toArray() ?? [];
            foreach($users as $u){
                $user = User::find($u['id']);

                Notification::sendNow($user, new RemindMaintenanceMailAlert($user,$vehicle));

            }
        }

    }
}

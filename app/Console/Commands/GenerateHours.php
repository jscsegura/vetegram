<?php

namespace App\Console\Commands;

use App\Models\AppointmentHour;
use App\Models\AppointmentTemplate;
use App\Models\CronStatus;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateHours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:hours';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate automatic appointment times';

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
    public function handle($id = 0)
    {
        $continue = CronStatus::starttask('generate:hours');
        if($continue == false) {
            die('Task is lock');
        }
        
        try {
            
            $now = date('Y-m-d');
            $datetime = date('Y-m-d H:i:s');

            if($id != 0) {
                $rows = User::select('id', 'mode', 'process')->where('mode', '=', 1)->where('id', '=', $id)->get();
            }else{
                $rows = User::select('id', 'mode', 'process')->where('mode', '=', 1)->where('process', '<', $now)->limit('100')->get();
            }

            foreach ($rows as $row) {
                $last = AppointmentHour::select('date')->where('id_user', '=', $row->id)->where('date', '>=', $now)->orderBy('date', 'desc')->first();

                $start = date('Y-m-d');
                $end = date("Y-m-d",strtotime($start."+ 60 days"));
                if(isset($last->date)) {
                    $start = date("Y-m-d",strtotime($last->date."+ 1 days"));
                }

                if(strtotime($start) <= strtotime($end)) {
                    $templates = [0 => [], 1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => []];
                    
                    $days = [];
                    while(strtotime($start) <= strtotime($end)) {
                        $index = date('w',strtotime($start));

                        if(count($templates[$index]) == 0) {
                            $templates[$index] = AppointmentTemplate::where('id_user', '=', $row->id)->where('day', '=', $index)->orderBy('hour', 'ASC')->get(['hour']);
                        }

                        foreach ($templates[$index] as $value) {
                            $aux = ['id_user' => $row->id, 'date' => $start, 'hour' => $value->hour, 'status' => 0, 'created_at' => $datetime, 'updated_at' => $datetime];
                            array_push($days, $aux);
                        }                    

                        $start = date("Y-m-d",strtotime($start."+ 1 days"));
                    }

                    if(count($days) > 0) {
                        DB::table('appointment_hours')->insert($days);
                    }
                }

                $row->process = $now;
                $row->update();
            }
        } catch (\Throwable $th) {
            CronStatus::stoptask('generate:hours');
        }

        CronStatus::stoptask('generate:hours');

        if($id == 0) {
            echo "Proceso completado";
        }
    }

    public function runHours($id) {
        $this->handle($id);
    }

}

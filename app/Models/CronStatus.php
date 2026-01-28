<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronStatus extends Model {

    protected $table = 'cron_status';

    protected $primaryKey = 'id';

    protected $fillable = array('id', 'code', 'status', 'created_at', 'updated_at');

    public static function starttask($code = "") {
        $task = CronStatus::where('code', '=', $code)->first();

        if(isset($task->id)) {
            if($task->status == 0) {
                $task->status = 1;
                $task->update();

                $continue = true;
            }else{
                $now = date('Y-m-d H:i:s');

                $start = strtotime($task->updated_at);
                $end   = strtotime($now);

                $diff = abs($end - $start);
                $diff = $diff / 3600;

                if ($diff > 2) {
                    $continue = true;
                } else {
                    $continue = false;
                }                
            }
        }else{
            CronStatus::create([
                'code' => $code,
                'status' => 1
            ]); 
            
            $continue = true;
        }

        return $continue;
    }

    public static function stoptask($code = "") {
        $task = CronStatus::where('code', '=', $code)->first();

        if(isset($task->id)) {
            $task->status = 0;
            $task->update();
        }
    }

}

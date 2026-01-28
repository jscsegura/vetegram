<?php

namespace App\Console\Commands;

use App\Models\CronStatus;
use App\Models\Notifications;
use App\Models\SuscriptionCancel;
use App\Models\User;
use App\Models\Vets;
use Illuminate\Console\Command;

class SendLateNotified extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:payments';

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
     * @return int
     */
    public function handle()
    {
        $continue = CronStatus::starttask('notification:payments');
        if($continue == false) {
            die('Task is lock');
        }

        try {
            $now = date('Y-m-d');
            $quantity = 4;

            $days = [];$lastDate = $now;
            for ($i=0; $i < $quantity; $i++) { 
                $lastDate = date('Y-m-d', strtotime($lastDate . ' -3 days'));
                array_push($days, $lastDate);
            }

            $rows = Vets::where('pro', '=', 1)->where('expire', '<', $now)->whereIn('last_process', $days)->limit('50')->get();
            
            if(count($rows) > 0) {
                foreach ($rows as $row) {
                    $row->last_process = $now;
                    $row->update();

                    $user = User::select('id', 'name', 'email', 'rol_id')
                        ->where('enabled', '=', 1)
                        ->where('complete', '=', 1)
                        ->where('rol_id', '=', 3)
                        ->where('id_vet', '=', $row->id)
                        ->first();

                    $data = [];
                    $template = view('emails.general.subscription-error', $data)->render();
            
                    Notifications::create([
                        'id_user' => $user->id,
                        'to' => $user->email,
                        'subject' => "Problema con la información de pago",
                        'description' => $template,
                        'attach' => '',
                        'email' => 1,
                        'sms' => 0,
                        'whatsapp' => 0,
                        'status' => 0,
                        'attemps' => 0
                    ]);               
                }
            }
        } catch (\Throwable $th) {
            CronStatus::stoptask('notification:payments');
        }

        try {
            $now = date('Y-m-d');

            $lastDate = date('Y-m-d', strtotime($now . ' -15 days'));
            
            $rows = Vets::where('pro', '=', 1)->where('expire', '=', $lastDate)->where('last_process', '!=', $now)->limit('50')->get();
            
            if(count($rows) > 0) {
                foreach ($rows as $row) {
                    $row->last_process = $now;
                    $row->update();

                    $user = User::select('id', 'name', 'email', 'rol_id')
                        ->where('enabled', '=', 1)
                        ->where('complete', '=', 1)
                        ->where('rol_id', '=', 3)
                        ->where('id_vet', '=', $row->id)
                        ->first();

                    $data = [];
                    $template = view('emails.general.subscription-cancel', $data)->render();
            
                    Notifications::create([
                        'id_user' => $user->id,
                        'to' => $user->email,
                        'subject' => "Suspención de Vetegram Pro",
                        'description' => $template,
                        'attach' => '',
                        'email' => 1,
                        'sms' => 0,
                        'whatsapp' => 0,
                        'status' => 0,
                        'attemps' => 0
                    ]);               
                }
            }
        } catch (\Throwable $th) {
            CronStatus::stoptask('notification:payments');
        }

        try {
            $now = date('Y-m-d');

            $lastDate = date('Y-m-d', strtotime($now . ' -19 days'));
            
            $rows = Vets::where('pro', '=', 1)->where('expire', '<=', $lastDate)->limit('50')->get();
            
            if(count($rows) > 0) {
                foreach ($rows as $row) {
                    $row->pro = 0;
                    $row->token = '';
                    $row->email_token = '';
                    $row->expire = null;
                    $row->last_process = $now;
                    $row->update();    
                    
                    $cancel = SuscriptionCancel::create([
                        'id_user' => 0,
                        'id_vet' => $row->id,
                        'reason' => 'Cancelado por falta de pago',
                        'survey' => ''
                    ]);
                }
            }
        } catch (\Throwable $th) {
            CronStatus::stoptask('notification:payments');
        }

        CronStatus::stoptask('notification:payments');

        echo "Proceso completado";
    }
}

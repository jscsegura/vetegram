<?php

namespace App\Console\Commands;

use App\Models\CronStatus;
use App\Models\Notifications;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use App\Models\Vets;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ExecutePaymentPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect monthly payments to Vetegram PRO plans';

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
        $continue = CronStatus::starttask('payments:execute');
        if($continue == false) {
            die('Task is lock');
        }

        try {
            $now = date('Y-m-d');

            $rows = Vets::where('pro', '=', 1)->where('last_process', '!=', $now)->where('expire', '=', $now)->limit('20')->get();
            
            if(count($rows) > 0) {
                $tilopay = Setting::getTilopaySetting();

                $token = '';

                $payload = [
                    'apiuser' => $tilopay->tilopay_user,
                    'password' => $tilopay->tilopay_pass
                ];

                $result = Http::withOptions(['verify' => false])
                    ->withHeaders([
                        'Access-Control-Allow-Origin' => '*',
                        'accept' => 'application/json'
                        ])->acceptJson()->post(env('Tilopay') . '/login', $payload);

                if(isset($result['access_token'])) {
                    $token = $result['access_token'];
                }
                
                foreach ($rows as $row) {
                    $row->last_process = $now;
                    $row->update();

                    $user = User::select('id', 'name', 'email', 'rol_id')
                        ->where('enabled', '=', 1)
                        ->where('complete', '=', 1)
                        ->where('rol_id', '=', 3)
                        ->where('id_vet', '=', $row->id)
                        ->first();

                    $orderNumber = 'rc' . rand(111,999) . date('YmdHis');

                    $payment = Payment::create([
                        'id_user' => (isset($user->id)) ? $user->id : 0,
                        'id_vet' => $row->id,
                        'currency' => 'USD',
                        'amount' => $tilopay->price_pro,
                        'code' => '',
                        'responseText' => '',
                        'auth' => '',
                        'orderNumber' => $orderNumber,
                        'orderid' => 0,
                        'hash' => ''
                    ]);

                    if(($row->email_token != '') && ($row->token != '')) {
                        $payload = [
                            "redirect" => "https://www.vetegramcr.com",
                            "key" => $tilopay->tilopay_key,
                            "amount" => $tilopay->price_pro,
                            "currency" => "USD",
                            "orderNumber" => $orderNumber,
                            "capture" => "1",
                            "email" => $row->email_token,
                            "card" => $row->token
                        ];

                        $transaction = Http::withOptions(['verify' => false])
                            ->withHeaders([
                                'Access-Control-Allow-Origin' => '*',
                                'accept' => 'application/json',
                                'Authorization' => 'bearer ' . $token
                                ])->acceptJson()->post(env('Tilopay') . '/processRecurrentPayment', $payload);
                        
                        $response = (isset($transaction['response'])) ? $transaction['response'] : '3';
                        $description = (isset($transaction['description'])) ? $transaction['description'] : '';
                        $auth = (isset($transaction['auth'])) ? $transaction['auth'] : '';
                        $tpt = (isset($transaction['tpt'])) ? $transaction['tpt'] : 0;

                        if($description == '') {
                            $description = (isset($transaction['result'])) ? $transaction['result'] : "Rechazado";
                        }
                    }else{
                        $transaction = [];
                        $response = '3';
                        $description = 'Problemas con la información de pago';
                        $auth = '';
                        $tpt = 0;
                    }

                    $payment->code = $response;
                    $payment->responseText = $description;
                    $payment->auth = $auth;
                    $payment->orderid = $tpt;
                    $payment->hash = json_encode(['hash' => 'Recurrente', 'tilohash' => '', 'url' => '']);
                    $payment->update();

                    if($response == '1') {
                        $initial = $row->expire;
                        
                        $expire = Carbon::createFromFormat('Y-m-d', $initial);
                        $expire->addMonth();
                        $expire = $expire->format('Y-m-d');
    
                        $row->expire = $expire;
                        $row->update();
        
                        $data = [
                            'name' => $user->name,
                            'payment' => $payment,
                            'expire' => $expire
                        ];
                        $template = view('emails.general.payment-confirm', $data)->render();
                
                        Notifications::create([
                            'id_user' => $user->id,
                            'to' => $user->email,
                            'subject' => "Pago realizado",
                            'description' => $template,
                            'attach' => '',
                            'email' => 1,
                            'sms' => 0,
                            'whatsapp' => 0,
                            'status' => 0,
                            'attemps' => 0
                        ]);        
                    }else{
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
            }

        } catch (\Throwable $th) {
            CronStatus::stoptask('payments:execute');
        }

        CronStatus::stoptask('payments:execute');

        echo "Proceso completado";
        
    }
}

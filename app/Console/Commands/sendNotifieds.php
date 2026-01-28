<?php

namespace App\Console\Commands;

use App\Models\AppointmentClient;
use App\Models\CronStatus;
use App\Models\Notifications;
use App\Models\Reminder;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\ExternalClass\Instasent\SmsClient;
use App\ExternalClass\Instasent\Abstracts\InstasentClient;
use App\Models\Vets;
use Carbon\Carbon;

class sendNotifieds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails - sms - whatsapp';

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
        $continue = CronStatus::starttask('send:notify');
        if($continue == false) {
            die('Task is lock');
        }
        
        try {
            /**** Send notifications ****/
            $rows = Notifications::where('status', '=', 0)->where('attemps', '<', 3)->get();

            foreach ($rows as $row) {
                $sendEmail = 1;
                $sendSMS = 1;
                $sendWhatsapp = 1;

                if($row->id_user != 0) {
                    $owner = User::select('id', 'mailer', 'sms', 'whatsapp')->where('id', '=', $row->id_user)->first();
                    if(isset($owner->id)) {
                        $sendEmail = $owner->mailer;
                        $sendSMS = $owner->sms;
                        $sendWhatsapp = $owner->whatsapp;
                    }
                }

                if($row->email == 1) {
                    if($sendEmail == 1) {
                        $this->sendEmail($row);
                    }else{
                        $row->status = 3;
                        $row->update();
                    }
                }

                if($row->sms == 1) {
                    if($sendSMS == 1) {
                        $this->sendSms($row);
                    }else{
                        $row->status = 3;
                        $row->update();
                    }
                }

                if($row->whatsapp == 1) {
                    if($sendWhatsapp == 1) {
                        $this->sendWhatsaap($row);
                    }else{
                        $row->status = 3;
                        $row->update();
                    }
                }
            }

            /**** Create notification from send reminders ****/
            $now = Carbon::now();
            $now = $now->addMinutes(5);
            $now = $now->format('Y-m-d H:i:s');

            $reminders = Reminder::where('date', '<=', $now)->where('status', '=', 0)->where('attemps', '<', 3)->get();

            foreach ($reminders as $reminder) {
                if($reminder->email == 1) {
                    $data = [
                        'subject' => ($reminder->section == 1) ? 'reminder' : '',
                        'description' => $reminder->description,
                        'id_appointment' => $reminder->id_appointment
                    ];
                    $template = view('emails.general.reminder', $data)->render();

                    Notifications::create([
                        'id_user' => $reminder->id_user,
                        'to' => $reminder->to,
                        'subject' => 'Recordatorio - Reminder',
                        'description' => $template,
                        'attach' => '',
                        'email' => 1,
                        'sms' => 0,
                        'whatsapp' => 0,
                        'status' => 0,
                        'attemps' => 0
                    ]);
                }

                if($reminder->sms == 1) {
                    Notifications::create([
                        'id_user' => $reminder->id_user,
                        'to' => $reminder->to_phone,
                        'subject' => 'Recordatorio - Reminder',
                        'description' => $reminder->resume,
                        'attach' => '',
                        'email' => 0,
                        'sms' => 1,
                        'whatsapp' => 0,
                        'status' => 0,
                        'attemps' => 0
                    ]);
                }

                if($reminder->whatsapp == 1) {
                    Notifications::create([
                        'id_user' => $reminder->id_user,
                        'to' => $reminder->to_phone,
                        'subject' => 'Recordatorio - Reminder',
                        'description' => $reminder->resume,
                        'attach' => '',
                        'email' => 0,
                        'sms' => 0,
                        'whatsapp' => 1,
                        'status' => 0,
                        'attemps' => 0
                    ]);
                }

                $reminder->status = 1;
                $reminder->attemps = $reminder->attemps + 1;
                $reminder->update();

                if($reminder->repeat == 1) {
                    if($reminder->quantity > 0) {
                        $quantity = $reminder->quantity - 1;

                        $date = Carbon::createFromFormat('Y-m-d H:i:s', $reminder->date);
                        switch ($reminder->period) {
                            case '1':
                                $date = $date->addDay();
                                break;
                            case '2':
                                $date = $date->addWeek();
                                break;
                            case '3':
                                $date = $date->addMonth();
                                break;
                            case '4':
                                $date = $date->addYear();
                                break;
                            default:
                                break;
                        }
                        $date = $date->format('Y-m-d H:i:s');

                        Reminder::create([
                            'id_user' => $reminder->id_user,
                            'section' => $reminder->section,
                            'to' => $reminder->to,
                            'to_phone' => $reminder->to_phone,
                            'description' => $reminder->description,
                            'resume' => $reminder->resume,
                            'date' => $date,
                            'email' => $reminder->email,
                            'sms' => $reminder->sms,
                            'whatsapp' => $reminder->whatsapp,
                            'status' => 0,
                            'attemps' => 0,
                            'id_appointment' => $reminder->id_appointment,
                            'id_pet' => $reminder->id_pet,
                            'read' => 0,
                            'repeat' => $reminder->repeat,
                            'period' => $reminder->period,
                            'quantity' => $quantity,
                            'created_by' => $reminder->created_by
                        ]);
                    }
                }
            }

            /**** create appointment reminders 24 hours before ****/
            $now = date('Y-m-d H:i:s');
            $timestamp = strtotime($now);
            $timestampPlus = $timestamp + 24*3600;
            $dateConsult = date('Y-m-d H:i:s', $timestampPlus);

            $appointments = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status', 'reminder')
                ->where(DB::raw("CONCAT(date, ' ', hour)"), '<=', $dateConsult)
                ->where('reminder', '=', 0)
                ->whereIn('status', [0,1])
                ->with('getDoctor')
                ->with('getClient')
                ->get();

            foreach ($appointments as $appointment) {
                $name = (isset($appointment['getClient']['name'])) ? $appointment['getClient']['name'] : '';
                $date = date('d', strtotime($appointment->date)) . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($appointment->date)))) . ' ' . trans('dash.label.of') . ' ' . date('Y', strtotime($appointment->date)) . ' ' . trans('dash.label.confirm.appointment.at') . ' ' . date('h:i a', strtotime($appointment->hour));
                $doctor = (isset($appointment['getDoctor']['name'])) ? $appointment['getDoctor']['name'] : '';
                $id_vet = (isset($appointment['getDoctor']['id_vet'])) ? $appointment['getDoctor']['id_vet'] : '';
                $vet = Vets::select('id', 'pro')->where('id', '=', $id_vet)->first();
                
                $data = [
                    'subject' => '',
                    'description' => trans('dash.reminder.24hours.before', ['name' => $name, 'date' => $date, 'doctor' => $doctor]),
                    'id_appointment' => $appointment->id
                ];
                $template = view('emails.general.reminder', $data)->render();
                Notifications::create([
                    'id_user' => (isset($appointment->id_owner)) ? $appointment->id_owner : 0,
                    'to' => (isset($appointment['getClient']['email'])) ? $appointment['getClient']['email'] : '',
                    'subject' => 'Recordatorio - Reminder',
                    'description' => $template,
                    'attach' => '',
                    'email' => 1,
                    'sms' => 0,
                    'whatsapp' => 0,
                    'status' => 0,
                    'attemps' => 0
                ]);

                if((isset($vet->pro)) && ($vet->pro == 1) && ((isset($appointment['getClient']['phone']))&&($appointment['getClient']['phone'] != ''))) {
                    Notifications::create([
                        'id_user' => (isset($appointment->id_owner)) ? $appointment->id_owner : 0,
                        'to' => (isset($appointment['getClient']['phone'])) ? $appointment['getClient']['phone'] : '',
                        'subject' => 'Recordatorio - Reminder',
                        'description' => trans('dash.reminder.24hours.before', ['name' => $name, 'date' => $date, 'doctor' => $doctor]),
                        'attach' => '',
                        'email' => 0,
                        'sms' => 1,
                        'whatsapp' => 0,
                        'status' => 0,
                        'attemps' => 0
                    ]);
                    
                    Notifications::create([
                        'id_user' => (isset($appointment->id_owner)) ? $appointment->id_owner : 0,
                        'to' => (isset($appointment['getClient']['phone'])) ? $appointment['getClient']['phone'] : '',
                        'subject' => 'Recordatorio - Reminder',
                        'description' => trans('dash.reminder.24hours.before', ['name' => $name, 'date' => $date, 'doctor' => $doctor]),
                        'attach' => '',
                        'email' => 0,
                        'sms' => 0,
                        'whatsapp' => 1,
                        'status' => 0,
                        'attemps' => 0
                    ]);
                }

                $appointment->reminder = 1;
                $appointment->update();
            }

        } catch (\Throwable $th) {
            dd($th);
            CronStatus::stoptask('send:notify');
        }

        CronStatus::stoptask('send:notify');

        echo "Envio terminado";
    }

    public function sendEmail($row) {
        $setting = Setting::getEmailSetting();
        $mailConfig = [
            'transport' => 'smtp',
            'host' => $setting->email_host,
            'port' => $setting->email_port,
            'encryption' => $setting->email_tls,
            'username' => $setting->email_user,
            'password' => $setting->email_pass,
            'timeout' => null
        ];
        config(['mail.mailers.smtp' => $mailConfig]);

        try {
            if(($setting->email_user != '') && ($setting->email_pass != '')) {
                $file = '';
                if((isset($row->attach))&&($row->attach != '')) {
                    $file = public_path($row->attach);
                }

                $subject = $row->subject;

                $template = $row->description;
    
                Mail::send('emails.layout.emails', ['content' => $template], function($message) use ($row, $setting, $file, $subject) {
                    $message->to($row->to, 'Vetegram')->subject($subject);
                    $message->from($setting->email_user, $setting->email_from);
                    if($file != '') {
                        $message->attach($file);
                    }
                });
    
                if (Mail::failures()) {
                    $row->attemps = $row->attemps + 1;
                    $row->update();
                }else{
                    $row->status = 2;
                    $row->attemps = $row->attemps + 1;
                    $row->update();
                }
            }else{
                $row->attemps = $row->attemps + 1;
                $row->update();
            }
            
        } catch (\Throwable $th) {}
    }

    public function sendSms($row) {
        try {
            $instasentClient = new SmsClient(env('SMSTOKEN'));
            $response = $instasentClient->sendSms(env('SMSTO'), $row->to, $row->description);

            if((isset($response['response_code'])) && ($response['response_code'] == 201)) {
                $row->status = 2;
                $row->attemps = $row->attemps + 1;
                $row->update();
            }else{
                $row->attemps = $row->attemps + 1;
                $row->update();
            }
        } catch (\Throwable $th) {}
    }

    public function sendWhatsaap($row) {
        
        $payload = [
            'chatId' => str_replace("+", "", $row->to) . '@c.us',
            'message' => $row->description
        ];

        try {
            $apiToken = env('WaAPISdkKey');

            $result = Http::withOptions(['verify' => false])->withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
                'content-type' => 'application/json',
                'accept' => 'application/json'
            ])->acceptJson()->post(env('WaAPISdkURL'), $payload);

            $result = $result->body();
            $result = json_decode($result, true);

            if((isset($result['data']['status'])) && ($result['data']['status'] == 'success')) {
                $row->status = 2;
                $row->attemps = $row->attemps + 1;
                $row->update();
            }else{
                $row->attemps = $row->attemps + 1;
                $row->update();
            }

        } catch (\Throwable $th) {}
    }
}

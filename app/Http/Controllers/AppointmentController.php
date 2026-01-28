<?php

namespace App\Http\Controllers;

use App\Console\Commands\sendNotifieds;
use App\Models\AnimalBreed;
use App\Models\AnimalTypes;
use App\Models\AppointmentAttachment;
use App\Models\AppointmentClient;
use App\Models\AppointmentHour;
use App\Models\AppointmentNote;
use App\Models\AppointmentRecipe;
use App\Models\AppointmentRecipeDetails;
use App\Models\Countries;
use App\Models\Diagnostic;
use App\Models\Inventory;
use App\Models\Notifications;
use App\Models\Pet;
use App\Models\PhysicalCategory;
use App\Models\PhysicalCategoryUser;
use App\Models\RecipeTakes;
use App\Models\Reminder;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserVetDoctor;
use App\Models\Vaccine;
use App\Models\VaccineItem;
use App\Models\VeterinaryCredential;
use App\Models\Vets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PDF;
use Image;

class AppointmentController extends Controller {
    
    public function __construct() {}
    
    public function index(Request $request) {
        $user = Auth::guard('web')->user();

        if($user->rol_id == 8) {
            $appointments = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
                ->where('id_owner', '=', $user->id)
                ->where('date', '>=', date('Y-m-d'))
                ->whereIn('status', [0,1])
                ->with('getPet')
                ->with('getDoctor')
                ->orderBy('date', 'ASC')
                ->orderBy('hour', 'ASC')
                ->get();

            if(isset($request->api)) {
                $previous = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
                    ->where('id_owner', '=', $user->id)
                    ->where('date', '<', date('Y-m-d'))
                    ->whereIn('status', [0,1,2,3])
                    ->with('getPet')
                    ->with('getDoctor')
                    ->orderBy('date', 'DESC')
                    ->orderBy('hour', 'DESC')
                    ->limit(50)
                    ->get();
            }else{
                $previous = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
                    ->where('id_owner', '=', $user->id)
                    ->where('date', '<', date('Y-m-d'))
                    ->whereIn('status', [0,1,2,3])
                    ->with('getPet')
                    ->with('getDoctor')
                    ->orderBy('date', 'DESC')
                    ->orderBy('hour', 'DESC')
                    ->paginate(15);
            }

            if(isset($request->api)) {
                return ['type' => 'success', 'appointments' => $appointments, 'previous' => $previous];
            }else{
                $thismenu = 'appointowner';
                return view('appointments.owner', compact('thismenu', 'appointments', 'previous'));
            }
        }else{
            $month  = (isset($request->month)) ? base64_decode($request->month) : date('m');
            $year   = (isset($request->year)) ? base64_decode($request->year) : date('Y');
            $userid = (isset($request->userid)) ? base64_decode($request->userid) : $user->id;

            $vets = Vets::getUserMyVet($user->id_vet);

            if($userid != $user->id) {
                $exist = false;
                foreach ($vets as $value) {
                    if($value->id == $userid) {
                        $exist = true;
                    }
                }
                if($exist == false) {
                    return redirect(route('appointment.index'));
                }
            }

            $from = $year . '-' . $month . '-01';
            $to = Carbon::createFromFormat('Y-m-d', $from)->endOfMonth()->format('Y-m-d');
            
            $appointments = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
                ->where('id_user', '=', $userid)
                ->where('date', '>=', $from)
                ->where('date', '<=', $to)
                ->with('getPet')
                ->with('getClient')
                ->orderBy('date', 'ASC')
                ->orderBy('hour', 'ASC')
                ->get();

            $thismenu = 'appointment';
            return view('appointments.index', compact('thismenu', 'vets', 'user', 'month', 'year', 'userid', 'appointments'));
        }
    }

    public function history(Request $request) {
        $user = Auth::guard('web')->user();

        $month  = (isset($request->month)) ? base64_decode($request->month) : date('m');
        $year   = (isset($request->year)) ? base64_decode($request->year) : date('Y');
        $userid = (isset($request->userid)) ? base64_decode($request->userid) : $user->id;

        $vets = Vets::getUserMyVet($user->id_vet);

        if($userid != $user->id) {
            $exist = false;
            foreach ($vets as $value) {
                if($value->id == $userid) {
                    $exist = true;
                }
            }
            if($exist == false) {
                return redirect(route('appointment.history'));
            }
        }

        $from = $year . '-' . $month . '-01';
        $to = Carbon::createFromFormat('Y-m-d', $from)->endOfMonth()->format('Y-m-d');
        
        $appointments = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
            ->where('id_user', '=', $userid)
            ->where('date', '>=', $from)
            ->where('date', '<=', $to)
            ->whereIn('status', [2,3])
            ->with('getPet')
            ->with('getClient')
            ->orderBy('date', 'ASC')
            ->orderBy('hour', 'ASC')
            ->get();

        $thismenu = 'appointment';
        return view('appointments.history', compact('thismenu', 'vets', 'user', 'month', 'year', 'userid', 'appointments'));
    }

    public function schedule(Request $request) {
        $user = Auth::guard('web')->user();

        $type   = (isset($request->type)) ? $request->type : 1;
        $userid = (isset($request->userid)) ? base64_decode($request->userid) : $user->id;
        $from   = (isset($request->from)) ? base64_decode($request->from) : Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->startOfMonth()->format('Y-m-d');
        $to     = (isset($request->to)) ? base64_decode($request->to) : Carbon::createFromFormat('Y-m-d', $from)->endOfMonth()->format('Y-m-d');
        
        $vets = Vets::getUserMyVet($user->id_vet);

        if($userid != $user->id) {
            $exist = false;
            foreach ($vets as $value) {
                if($value->id == $userid) {
                    $exist = true;
                }
            }
            if($exist == false) {
                return redirect(route('appointment.history'));
            }
        }

        $userid1 = $userid;
        $from1   = $from;
        $to1     = $to;
        if($type != 1) {
            $from1 = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->startOfMonth()->format('Y-m-d');
            $to1   = Carbon::createFromFormat('Y-m-d', $from1)->endOfMonth()->format('Y-m-d');
        }

        $appointments1 = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
            ->where('id_user', '=', $userid1)
            ->whereBetween('date', [$from1, $to1])
            ->with('getPet')
            ->with('getClient')
            ->orderBy('date', 'ASC')
            ->orderBy('hour', 'ASC')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->date)->format('Y-m-d');
            });

        $userid2 = $userid;
        $from2   = $from;
        $to2     = $to;
        if($type != 2) {
            $from2 = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->startOfWeek()->format('Y-m-d');
            $to2   = Carbon::createFromFormat('Y-m-d', $from2)->endOfWeek()->format('Y-m-d');
        }

        $appointments2 = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
            ->where('id_user', '=', $userid2)
            ->whereBetween('date', [$from2, $to2])
            ->with('getPet')
            ->orderBy('hour', 'ASC')
            ->orderBy('date', 'ASC')
            ->get()
            ->groupBy(function ($val) {
                return (int)Carbon::parse($val->hour)->format('H');
            })
            ->toArray();

        $userid3 = $userid;
        $from3   = $from;
        $to3     = $to;
        if($type != 3) {
            $from3 = date('Y-m-d');
            $to3   = date('Y-m-d');
        }

        $appointments3 = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
            ->where('id_user', '=', $userid3)
            ->where('date', '=', $from3)
            ->with('getPet')
            ->with('getClient')
            ->with('getLastNote')
            ->orderBy('hour', 'ASC')
            ->get()
            ->groupBy(function ($val) {
                return (int)Carbon::parse($val->hour)->format('H');
            })
            ->toArray();

        $params = [
            'userid1' => $userid1, 
            'userid2' => $userid2, 
            'userid3' => $userid3, 
            'from1' => $from1, 
            'to1' => $to1, 
            'from2' => $from2, 
            'to2' => $to2, 
            'from3' => $from3, 
            'to3' => $to3,
            'appointments1' => $appointments1,
            'appointments2' => $appointments2,
            'appointments3' => $appointments3
        ];

        $thismenu = 'appointment';
        return view('appointments.schedule', compact('thismenu', 'type', 'vets', 'user', 'params'));
    }

    public function add() {
        $user = Auth::guard('web')->user();

        $vets = Vets::getUserMyVet($user->id_vet);

        $userToVet = UserVetDoctor::where('id_vet', '=', $user->id_vet)->pluck('id_client');

        $pets = Pet::select('id', 'id_user', 'name')
            ->whereIn('id_user', $userToVet)
            ->where('dead_flag', '=', 0)
            ->with('getUser')
            ->orderBy('name', 'ASC')
            ->orderBy('id_user', 'ASC')
            ->get();

        $lang = Config::get('app.locale');
        $types = RecipeTakes::select('id', 'title_' . $lang . ' as title')->where('enabled', '=', 1)->orderBy('title_'. $lang, 'ASC')->get();

        $medicines = Inventory::select('id', 'title', 'instructions')->where('id_vet', '=', $user->id_vet)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
    
        $animalTypes = AnimalTypes::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->get();

        $countries = Countries::select('id', 'title', 'phonecode')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
        $countryDefault = Vets::getVetCountry($user->id_vet);

        $thismenu = 'appointment';
        return view('appointments.add', compact('thismenu', 'vets', 'user', 'pets', 'types', 'medicines', 'animalTypes', 'countries', 'countryDefault'));
    }

    public function store(Request $request) {
        $user = Auth::guard('web')->user();

        $pet = explode(':', $request->pet);

        $hour = AppointmentHour::where('id', '=', $request->hour)->first();

        /*** Verifica si puede crear citas en plan free ***/
        $vet = Vets::where('id', '=', $user->id_vet)->first();

        $setting = Setting::getLimitsSetting();

        $maxAppoint = 0;
        $maxStorage = 0;
        if($vet->pro == 1) {
            $maxAppoint = $setting->max_appointment_pro;
            $maxStorage = $setting->max_storage_pro;
        }else{
            $maxAppoint = $setting->max_appointment_free;
            $maxStorage = $setting->max_storage_free;
        }

        $vetUsers = Vets::getUserMyVet($user->id_vet);
        $ids = [];
        foreach ($vetUsers as $value) {
            array_push($ids, $value->id);
        }

        $start = Carbon::now()->startOfMonth()->format('Y-m-d') . ' 00:00:00';
        $end = Carbon::now()->endOfMonth()->format('Y-m-d') . ' 23:59:59';
        $appointmentCounter = AppointmentClient::whereIn('id_user', $ids)->whereBetween('created_at', [$start, $end])->count();

        if(($maxAppoint > 0) && ($appointmentCounter >= $maxAppoint)) {
            session()->flash('error', trans('auth.failed.add.appointment.pro', ['linkPlan' => '<a href="'.route('plan').'">aqui</a>', 'linkPlanHere' => '<a href="'.route('plan').'">here</a>']));
            return redirect()->back();
        }

        if($request->hasfile('fileModalMultiple')) {
            $attachSize = AppointmentAttachment::where('id_vet_created', '=', $user->id_vet)->sum('size');
            if(($maxStorage > 0) && ($attachSize >= $maxStorage)) {
                session()->flash('error', trans('auth.failed.add.storage.pro', ['linkPlan' => '<a href="'.route('plan').'">aqui</a>', 'linkPlanHere' => '<a href="'.route('plan').'">here</a>']));
                return redirect()->back();
            }
        }
        /**********/

        if((isset($hour->id))&&($hour->status == 0)) {

            $appointment = AppointmentClient::create([
                'id_user' => $request->user,
                'id_pet' => (isset($pet[0])) ? $pet[0] : 0,
                'id_owner' => (isset($pet[1])) ? $pet[1] : 0,
                'id_hours' => $hour->id,
                'date' => $hour->date,
                'hour' => $hour->hour,
                'reason' => $request->reason,
                'breed_grooming' => 0,
                'image_grooming' => 0,
                'desc_grooming' => '',
                'status' => 0,
                'reminder' => 0
            ]);

            $doctorRow = User::select('id', 'id_vet', 'rol_id')->where('id', '=', $request->user)->first();

            if($doctorRow->rol_id == 6) {
                $appointment->breed_grooming = $request->breed;
                $appointment->image_grooming = $request->imageSelected;
                $appointment->desc_grooming = ($request->imageSelected == 0) ? $request->grooming_personalize : '';
                $appointment->update();
            }

            $hour->status = 1;
            $hour->update();

            if((isset($request->notetitle)) && ($request->notetitle != '')) {
                AppointmentNote::create([
                    'id_appointment' => $appointment->id,
                    'id_pet' => $appointment->id_pet,
                    'note' => $request->notetitle,
                    'created_by' => $user->id,
                    'id_vet_created' => $user->id_vet
                ]);
            }

            if(isset($request->addReminder)) {
                if($request->reminder_type == 1) {
                    $userRow = User::select('id', 'email', 'phone')->where('id', '=', $request->user)->first();
                }else{
                    if(isset($pet[1])) {
                        $userRow = User::select('id', 'email', 'phone')->where('id', '=', $pet[1])->first();
                    }
                }

                Reminder::create([
                    'id_user' => (isset($userRow->id)) ? $userRow->id : 0,
                    'to' => (isset($userRow->email)) ? $userRow->email : '',
                    'description' => $request->reminder_detail,
                    'date' => date("Y-m-d", strtotime(str_replace("/","-", $request->reminder_date))) . ' ' . $request->reminder_time . ':00',
                    'email' => 1,
                    'sms' => 0,
                    'whatsapp' => 0,
                    'status' => 0,
                    'attemps' => 0,
                    'id_appointment' => $appointment->id,
                    'id_pet' => $appointment->id_pet,
                    'read' => 0,
                    'created_by' => $user->id
                ]);
            }

            if($request->hasfile('fileModalMultiple')) {
                
                foreach($request->file('fileModalMultiple') as $file) {
                    $realname = preg_replace('/\..+$/', '', $file->getClientOriginalName());
                    $size = $file->getSize();
                    $imageName = uniqid().time().'attach.'.$file->extension();
    
                    if(!File::isDirectory(public_path('files/attach/'.$appointment->id_pet))) {
                        File::makeDirectory(public_path('files/attach/'.$appointment->id_pet), '0777', true, true);
                        chmod(public_path('files/attach/'.$appointment->id_pet), 0777);
                    }
    
                    if($file->move(public_path('files/attach/'.$appointment->id_pet), $imageName)) {
                        AppointmentAttachment::create([
                            'id_appointment' => $appointment->id,
                            'id_pet' => $appointment->id_pet,
                            'title' => $realname,
                            'folder' => 'attach/' . $appointment->id_pet,
                            'attach' => $imageName,
                            'size' => ($size > 0) ? (($size / 1024) / 1024) : 0,
                            'created_by' => $user->id,
                            'id_vet_created' => $user->id_vet
                        ]);
                    }
                }
            }
            
            if(isset($_POST['medicineModalAp'])){
                $lang = Config::get('app.locale');

                $recipe = AppointmentRecipe::create([
                    'id_appointment' => $appointment->id,
                    'created_by' => $user->id,
                    'id_vet_created' => $user->id_vet
                ]);

                if(isset($recipe->id)) {
                    for($i = 0;$i < count($_POST['medicineModalAp']);$i++){
                        if($_POST['medicineModalAp'][$i] != ""){
                            $medicineTitle = Inventory::select('id', 'title')->where('id', '=', $_POST['medicineModalAp'][$i])->first();
                            $takeTitle = RecipeTakes::select('id', 'title_' . $lang . ' as title')->where('id', '=', $_POST['takeModalAp'][$i])->first();
    
                            AppointmentRecipeDetails::create([
                                'id_recipe' => $recipe->id,
                                'id_medicine' => $_POST['medicineModalAp'][$i],
                                'title' => (isset($medicineTitle->title)) ? $medicineTitle->title : '',
                                'duration' => $_POST['durationModalAp'][$i],
                                'id_take' => $_POST['takeModalAp'][$i],
                                'take' => (isset($takeTitle->title)) ? $takeTitle->title : '',
                                'quantity' => $_POST['quantityModalAp'][$i],
                                'instruction' => $_POST['indicationsModalAp'][$i],
                            ]);
                        }
                    }
                }
            }

            (new AppointmentController)->notifiedCreateAppointment($appointment->id);

            return redirect()->route('appointment.index');
        }else{
            session()->flash('error', trans('dash.hour.not.available'));
            return redirect()->back();
        }
    }

    public function view(Request $request) {
        $user = Auth::guard('web')->user();

        if(isset($request->api)) {
            $id = $request->id;
        }else{
            $id = User::encryptor('decrypt', $request->id);
        }

        $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'reason', 'diagnosis', 'hour', 'status', 'breed_grooming', 'image_grooming', 'desc_grooming', 'symptoms', 'history', 'physical', 'differential', 'differential_other', 'definitive', 'definitive_other', 'treatment')
            ->where('id', '=', $id)
            ->with('getPet')
            ->with('getClient')
            ->with('getDoctor')
            ->first();

        $credentials = VeterinaryCredential::userHasCredentials($appointment->id_owner);

        $vetName = [];
        if(isset($appointment['getDoctor']['id_vet'])){
            $vetName = Vets::select('id', 'company')->where('id', '=', $appointment['getDoctor']['id_vet'])->first();
        }

        $attachs = AppointmentAttachment::select('id', 'title', 'folder', 'attach', 'created_by', 'created_at')->where('id_appointment', '=', $id);
        if($credentials['access'] == false) {
            $attachs = $attachs->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $attachs = $attachs->get();

        $notes = AppointmentNote::select('id', 'note', 'to', 'created_at')->where('id_appointment', '=', $id);
        if($credentials['access'] == false) {
            $notes = $notes->where('id_vet_created', '=', $credentials['id_vet']);
        }
        if((isset($user->rol_id)) && ($user->rol_id == 8)) {
            $notes = $notes->where('to', '=', 1);
        }
        $notes = $notes->get();

        $recipes = AppointmentRecipe::select('id', 'created_at')->where('id_appointment', '=', $id)->with('detail');
        if($credentials['access'] == false) {
            $recipes = $recipes->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $recipes = $recipes->get();

        $diagnostics = Diagnostic::where('enabled', '=', 1)->orderBy('title_' . Config::get('app.locale'), 'ASC')->get();

        $physicalComplete = false;
        if(isset($request->api)) {
            return ['type' => 'success', 'appointment' => $appointment, 'attachs' => $attachs, 'notes' => $notes, 'recipes' => $recipes, 'vetName' => $vetName, 'diagnostics' => $diagnostics];
        }else{
            $thismenu = 'appointment';
            return view('appointments.view', compact('thismenu', 'appointment', 'attachs', 'notes', 'recipes', 'vetName', 'diagnostics', 'physicalComplete'));
        }
    }

    public function edit(Request $request) {
        $id = User::encryptor('decrypt', $request->id);

        $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'reason', 'diagnosis', 'hour', 'status', 'breed_grooming', 'image_grooming', 'desc_grooming', 'symptoms', 'history', 'physical', 'differential', 'differential_other', 'definitive', 'definitive_other', 'treatment')
            ->where('id', '=', $id)
            ->with('getPet')
            ->with('getClient')
            ->first();

        $credentials = VeterinaryCredential::userHasCredentials($appointment->id_owner);

        $attachs = AppointmentAttachment::select('id', 'title', 'folder', 'attach', 'created_by', 'created_at')->where('id_appointment', '=', $id);
        if($credentials['access'] == false) {
            $attachs = $attachs->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $attachs = $attachs->get();

        $notes = AppointmentNote::select('id', 'note', 'to', 'created_at')->where('id_appointment', '=', $id);
        if($credentials['access'] == false) {
            $notes = $notes->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $notes = $notes->get();
        
        $recipes = AppointmentRecipe::select('id', 'created_at')->where('id_appointment', '=', $id)->with('detail');
        if($credentials['access'] == false) {
            $recipes = $recipes->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $recipes = $recipes->get();

        $categories = PhysicalCategory::where('enabled', '=', 1)->orderBy('title_' . Config::get('app.locale'), 'ASC')->with('options')->get();

        $vetCategories = PhysicalCategoryUser::where('id_vet', '=', $credentials['id_vet'])->get();

        $rowOptions = [];$rowCategories = [];
        foreach ($vetCategories as $row) {
            if($row->options != '') {
                $options = json_decode($row->options, true);
                foreach ($options as $option) {
                    array_push($rowOptions, $option);
                }
                array_push($rowCategories, $row->id_category);
            }
        }

        $diagnostics = Diagnostic::where('enabled', '=', 1)->orderBy('title_' . Config::get('app.locale'), 'ASC')->get();

        $physicalComplete = true;
        $thismenu = 'appointment';
        return view('appointments.edit', compact('thismenu', 'appointment', 'attachs', 'notes', 'categories', 'rowCategories', 'rowOptions', 'recipes', 'diagnostics', 'physicalComplete'));
    }

    public function start(Request $request) {
        $id = User::encryptor('decrypt', $request->id);

        $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'reason', 'diagnosis', 'hour', 'status', 'breed_grooming', 'image_grooming', 'desc_grooming', 'symptoms', 'history', 'physical', 'differential', 'differential_other', 'definitive', 'definitive_other', 'treatment')
            ->where('id', '=', $id)
            ->with('getPet')
            ->with('getClient')
            ->first();

        if($appointment->status != 1) {
            $appointment->status = 1;
            $appointment->update();
        }
        
        $credentials = VeterinaryCredential::userHasCredentials($appointment->id_owner);

        $attachs = AppointmentAttachment::select('id', 'title', 'folder', 'attach', 'created_by', 'created_at')->where('id_appointment', '=', $id);
        if($credentials['access'] == false) {
            $attachs = $attachs->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $attachs = $attachs->get();

        $notes = AppointmentNote::select('id', 'note', 'to', 'created_at')->where('id_appointment', '=', $id);
        if($credentials['access'] == false) {
            $notes = $notes->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $notes = $notes->get();

        $recipes = AppointmentRecipe::select('id', 'created_at')->where('id_appointment', '=', $id)->with('detail');
        if($credentials['access'] == false) {
            $recipes = $recipes->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $recipes = $recipes->get();

        $vaccines = Vaccine::where('id_pet', '=', $appointment->id_pet)->where('section', '=', 0)->orderBy('created_at', 'desc');
        if($credentials['access'] == false) {
            $vaccines = $vaccines->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $vaccines = $vaccines->get();

        $desparats = Vaccine::where('id_pet', '=', $appointment->id_pet)->where('section', '=', 1)->orderBy('created_at', 'desc');
        if($credentials['access'] == false) {
            $desparats = $desparats->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $desparats = $desparats->get();

        $prevRecipes = AppointmentRecipe::select('id', 'created_at')->where('id_pet', '=', $appointment->id_pet)->where('id_appointment', '!=', $id)->orderBy('created_at', 'desc');
        if($credentials['access'] == false) {
            $prevRecipes = $prevRecipes->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $prevRecipes = $prevRecipes->get();
        
        $prevAppointments = AppointmentClient::select('id', 'id_pet', 'date')->where('id_pet', '=', $appointment->id_pet)->where('id', '!=', $appointment->id)->get();

        $categories = PhysicalCategory::where('enabled', '=', 1)->orderBy('title_' . Config::get('app.locale'), 'ASC')->with('options')->get();

        $vetCategories = PhysicalCategoryUser::where('id_vet', '=', $credentials['id_vet'])->get();

        $rowOptions = [];$rowCategories = [];
        foreach ($vetCategories as $row) {
            if($row->options != '') {
                $options = json_decode($row->options, true);
                foreach ($options as $option) {
                    array_push($rowOptions, $option);
                }
                array_push($rowCategories, $row->id_category);
            }
        }

        $pet = Pet::where('id', '=', $appointment->id_pet)->with('getBreed')->first();

        $allTypes = AnimalTypes::where('enabled', '=', 1)->get();
        $allBreed = AnimalBreed::where('enabled', '=', 1)->where('type', '=', $pet->type)->get();

        $vaccineItems = VaccineItem::where('type', '=', 1)->where('enabled', '=', 1)->orderBy('title_' . Config::get('app.locale'), 'ASC')->get();
        $desparacitanteItems = VaccineItem::where('type', '=', 2)->where('enabled', '=', 1)->orderBy('title_' . Config::get('app.locale'), 'ASC')->get();

        $diagnostics = Diagnostic::where('enabled', '=', 1)->orderBy('title_' . Config::get('app.locale'), 'ASC')->get();

        $physicalComplete = true;
        $thismenu = 'appointment';
        return view('appointments.start', compact('thismenu', 'appointment', 'attachs', 'notes', 'recipes', 'vaccines', 'desparats', 'prevRecipes', 'prevAppointments', 'categories', 'rowCategories', 'rowOptions', 'pet', 'allTypes', 'allBreed', 'diagnostics', 'vaccineItems', 'desparacitanteItems', 'physicalComplete'));
    }

    public function finish(Request $request) {
        $id = $request->id;

        $appointment = AppointmentClient::select('id', 'status', 'id_owner', 'id_user')->where('id', '=', $id)->first();

        if(isset($appointment->id)) {
            $appointment->status = 2;
            $appointment->update();

            $emailUser = User::select('id', 'email', 'phone')->where('id', '=', $appointment->id_owner)->first();

            $recipes = AppointmentRecipe::select('id')->where('id_appointment', '=', $appointment->id)->get();

            $doctor = User::select('id', 'id_vet')->where('id', '=', $appointment->id_user)->first();
            $vet = Vets::select('id', 'pro')->where('id', '=', $doctor->id_vet)->first();

            foreach($recipes as $recipe) {
                if(isset($emailUser->email)) {
                    $requestData = new \Illuminate\Http\Request();
                    $requestData->setMethod('POST');
                    $requestData->request->add([
                        "id" => $recipe->id,
                        "email" => $emailUser->email
                    ]);
                    $sending = $this->sendRecipe($requestData);
                }

                if(($vet->pro == 1)&&($emailUser->phone != '')) {
                    $url = url('appointment-print-recipe/' . User::encryptor('encrypt', $recipe->id)) . '/show';
                    $template = trans('sms.sms.send.recipe') . ' ' . $url . ' ' . trans('sms.sms.whatsapp.signature');
                    Notifications::create([
                        'id_user' => $emailUser->id,
                        'to' => (isset($emailUser->phone)) ? $emailUser->phone : '',
                        'subject' => 'sms',
                        'description' => $template,
                        'attach' => '',
                        'email' => 0,
                        'sms' => 1,
                        'whatsapp' => 0,
                        'status' => 0,
                        'attemps' => 0
                    ]);
                    Notifications::create([
                        'id_user' => $emailUser->id,
                        'to' => (isset($emailUser->phone)) ? $emailUser->phone : '',
                        'subject' => 'whatsapp',
                        'description' => $template,
                        'attach' => '',
                        'email' => 0,
                        'sms' => 0,
                        'whatsapp' => 1,
                        'status' => 0,
                        'attemps' => 0
                    ]);
                }
            }

            return response()->json(array('type' => '200', 'process' => '1', 'id' => User::encryptor('encrypt', $id)));
        }

        return response()->json(array('type' => '200', 'process' => '0'));
    }

    public function endinvoice(Request $request) {
        $id = User::encryptor('decrypt', $request->id);

        $thismenu = 'appointment';
        return view('appointments.endinvoice', compact('thismenu'));
    }

    public function update(Request $request) {
        $id = $request->id;

        $appointment = AppointmentClient::select('id', 'reason', 'diagnosis')->where('id', '=', $id)->first();

        if(isset($appointment->id)) {
            if(isset($request->reason)) {
                $appointment->reason = $request->reason;
            }
            if(isset($request->diagnosis)) {
                $appointment->diagnosis = $request->diagnosis;
            }
            if(isset($request->symptoms)) {
                $appointment->symptoms = $request->symptoms;
            }
            if(isset($request->physical)) {
                $appointment->physical = $request->physical;
            }
            if(isset($request->history)) {
                $appointment->history = $request->history;
            }
            if(isset($request->treatment)) {
                $appointment->treatment = $request->treatment;
            }
            if(isset($request->differential)) {
                $appointment->differential = $request->differential;
            }
            if(isset($request->differentialOther)) {
                $appointment->differential_other = $request->differentialOther;
            }
            if(isset($request->definitive)) {
                $appointment->definitive = $request->definitive;
            }
            if(isset($request->definitiveOther)) {
                $appointment->definitive_other = $request->definitiveOther;
            }
            
            $appointment->update();

            return response()->json(array('type' => '200', 'save' => '1'));
        }

        return response()->json(array('type' => '200', 'save' => '0'));
    }

    public function getHours(Request $request) {
        $user = Auth::guard('web')->user();

        $userid = $request->userid;
        $date   = date("Y-m-d", strtotime(str_replace("/","-", $request->date)));
        
        $rows = [];

        if(($userid != $user->id)&&($user->rol_id != 8)) {
            $vet = User::select('id', 'id_vet')->where('id', '=', $userid)->first();

            if((!isset($vet->id)) || ((isset($vet->id)) && ($vet->id_vet != $user->id_vet))) {
                return response()->json(array('type' => '200', 'rows' => $rows));
            }
        }

        AppointmentHour::where('user_reserve', '=', $user->id)->update(array('user_reserve' => 0, 'expire' => null));

        $now = Carbon::now()->format('Y-m-d H:i:s');
        $rows = AppointmentHour::select('id', 'date', 'hour')
            ->where('status', '=', 0)
            ->where('id_user', '=', $userid)
            ->where('date', '>=', date('Y-m-d'))
            ->where('date', '=', $date)
            ->where(function ($query) use ($now, $user) {
                $query->whereIn('user_reserve', [0, $user->id])
                    ->orWhere('expire', '<', $now)
                    ->orWhereNull('expire');
            })
            ->orderBy('hour', 'asc');

        if(date('Y-m-d') == $date) {
            $rows = $rows->where('hour', '>', date('H:i:s'));            
        }
        $rows = $rows->get();

        return response()->json(array('type' => '200', 'rows' => $rows));
    }

    public function reserveHour(Request $request) {
        $user = Auth::guard('web')->user();

        $id = $request->id;

        $row = AppointmentHour::select('id', 'user_reserve', 'expire', 'status')
            ->where('id', '=', $id)
            ->whereIn('user_reserve', [0, $user->id])
            ->first();

        $response = '0';
        if((isset($row->id)) && ($row->status == 0)) {
            AppointmentHour::where('user_reserve', '=', $user->id)->update(array('user_reserve' => 0, 'expire' => null));
            
            $now = Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s');

            $row->user_reserve = $user->id;
            $row->expire = $now;
            $row->update();

            $response = '1';
        }

        if(isset($request->api)) {
            return ['type' => 'success', 'reserve' => $response];
        }else{
            return response()->json(array('type' => '200', 'reserve' => $response));
        }
    }

    public function getClient(Request $request) {
        $email = $request->email;
        $codePhone = $request->codePhone;
        $phone = $request->phone;
        
        $email = '%' . $email . '%';

        $users = [];
        if(($request->email != '') && ($request->phone != '')) {
            $users = User::where('rol_id', '=', 8)
                ->where(function ($query) use ($email, $codePhone, $phone) {
                    $query->where('email', 'like', $email)
                        ->orWhereIn('phone', ['+'.$codePhone.$phone, $phone]);
                })
                ->pluck('id');
        }else if($request->email != '') {
            $users = User::where('rol_id', '=', 8)
                ->where('email', 'like', $email)
                ->pluck('id');
        }else if($request->phone != '') {
            $users = User::where('rol_id', '=', 8)
                ->whereIn('phone', ['+'.$codePhone.$phone, $phone])
                ->pluck('id');
        }        

        $pets = Pet::select('id', 'id_user', 'name')
            ->whereIn('id_user', $users)
            ->with('getUser')
            ->orderBy('name', 'ASC')
            ->orderBy('id_user', 'ASC')
            ->get();

        $results = [];
        foreach ($pets as $pet) {
            array_push($results, ['id' => $pet->id, 'id_user' => $pet->id_user, 'name' => $pet->name]);
        }

        return response()->json(array('type' => '200', 'rows' => $pets));
    }

    public function setClient(Request $request) {
        $myuser = Auth::guard('web')->user();

        $data = $request->data;
        $user = $request->user;

        $data = explode(":", $data);

        UserVetDoctor::firstOrCreate(
            ['id_client' => $data[1], 'id_vet' => $myuser->id_vet, 'id_doctor' => $user],
            []
        );

        $userToVet = UserVetDoctor::where('id_vet', '=', $myuser->id_vet)->pluck('id_client');

        $pets = Pet::select('id', 'id_user', 'name')
            ->whereIn('id_user', $userToVet)
            ->with('getUser')
            ->orderBy('name', 'ASC')
            ->orderBy('id_user', 'ASC')
            ->get();

        return response()->json(array('type' => '200', 'rows' => $pets));
    }

    public function saveNote(Request $request) {
        $user = Auth::guard('web')->user();

        $id = $request->id;
        $note = $request->note;
        $to = (isset($request->to)) ? $request->to : 0;

        $appointment = AppointmentClient::select('id', 'id_user', 'id_pet')
            ->where('id', '=', $id)
            ->first();

        if($appointment->id_user != $user->id) {
            $thisuser = User::select('id', 'id_vet')->where('id', '=', $appointment->id_user)->first();

            if(((isset($thisuser->id_vet)) && ($thisuser->id_vet != $user->id_vet)) || (!isset($thisuser->id_vet))) {
                return response()->json(array('type' => '200', 'save' => 0));
            }
        }

        AppointmentNote::create([
            'id_appointment' => $appointment->id,
            'id_pet' => $appointment->id_pet,
            'note' => $note,
            'created_by' => $user->id,
            'id_vet_created' => $user->id_vet,
            'to' => $to
        ]);

        return response()->json(array('type' => '200', 'save' => 1));
    }

    public function saveReminder(Request $request) {
        $user = Auth::guard('web')->user();

        $id     = $request->id;
        $to     = $request->to;
        $detail = $request->detail;
        $date   = $request->date;
        $time   = $request->time;
        $section = (isset($request->section)) ? $request->section : 0;
        $isPetId = (isset($request->isPetId)) ? $request->isPetId : 0;

        $repeat   = (isset($request->repeat)) ? $request->repeat : 0;
        $period   = (isset($request->period)) ? $request->period : 0;
        $quantity = (isset($request->quantity)) ? $request->quantity : 0;

        if($id == 0) {
            $newDateWithHour = strtotime(str_replace("/","-", $date . ' ' . $time . ':00'));
            $today = strtotime(date('Y-m-d H:i:s'));

            if($today < $newDateWithHour) {
                Reminder::create([
                    'id_user' => (isset($user->id)) ? $user->id : 0,
                    'section' => $section,
                    'to' => (isset($user->email)) ? $user->email : '',
                    'description' => $detail,
                    'date' => date("Y-m-d", strtotime(str_replace("/","-", $date))) . ' ' . $time . ':00',
                    'email' => 1,
                    'sms' => 0,
                    'whatsapp' => 0,
                    'status' => 0,
                    'attemps' => 0,
                    'id_appointment' => 0,
                    'id_pet' => 0,
                    'read' => 0,
                    'repeat' => $repeat,
                    'period' => $period,
                    'quantity' => $quantity,
                    'created_by' => $user->id
                ]);

                return response()->json(array('type' => '200', 'save' => 1));  
            }else{
                return response()->json(array('type' => '200', 'save' => 3));
            }    
        }else{
            $searchUserId = 0;
            $idPet = 0;
            if($isPetId == 1) {
                $pet = Pet::select('id', 'id_user')->where('id', '=', $id)->first();
                $searchUserId = ($to == 1) ? $user->id : $pet->id_user;
                $idPet = $pet->id;
            }else{
                $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'date')
                    ->where('id', '=', $id)
                    ->first();

                if($appointment->id_user != $user->id) {
                    $thisuser = User::select('id', 'id_vet')->where('id', '=', $appointment->id_user)->first();

                    if(((isset($thisuser->id_vet)) && ($thisuser->id_vet != $user->id_vet)) || (!isset($thisuser->id_vet))) {
                        return response()->json(array('type' => '200', 'save' => 0));
                    }
                }
                $searchUserId = ($to == 1) ? $appointment->id_user : $appointment->id_owner;
                $idPet = $appointment->id_pet;
            }

            $userRow = User::select('id', 'email', 'phone')->where('id', '=', $searchUserId)->first();

            $oldDate = (isset($appointment->date)) ? strtotime($appointment->date) : '';
            $newDate = strtotime(str_replace("/","-", $date));
            $newDateWithHour = strtotime(str_replace("/","-", $date . ' ' . $time . ':00'));
            $today = strtotime(date('Y-m-d H:i:s'));

            if($today < $newDateWithHour) {
                if(($oldDate >= $newDate) || (!isset($appointment->date))) {
                    $sms = 0;
                    $tophone = '';
                    if($user->rol_id != 8) {
                        $vet = Vets::select('id', 'pro')->where('id', '=', $user->id_vet)->first();
    
                        if((isset($vet->id)) && ($vet->pro == 1)) {
                            $sms = 1;
                            $tophone = (isset($userRow->phone)) ? $userRow->phone : '';
                        }
                    }

                    Reminder::create([
                        'id_user' => (isset($userRow->id)) ? $userRow->id : 0,
                        'to' => (isset($userRow->email)) ? $userRow->email : '',
                        'to_phone' => $tophone,
                        'description' => $detail,
                        'resume' => $detail,
                        'date' => date("Y-m-d", strtotime(str_replace("/","-", $date))) . ' ' . $time . ':00',
                        'email' => 1,
                        'sms' => $sms,
                        'whatsapp' => $sms,
                        'status' => 0,
                        'attemps' => 0,
                        'id_appointment' => (isset($appointment->id)) ? $appointment->id : 0,
                        'id_pet' => $idPet,
                        'read' => 0,
                        'repeat' => $repeat,
                        'period' => $period,
                        'quantity' => $quantity,
                        'created_by' => $user->id
                    ]);

                    return response()->json(array('type' => '200', 'save' => 1));
                }else{
                    return response()->json(array('type' => '200', 'save' => 2));
                }    
            }else{
                return response()->json(array('type' => '200', 'save' => 3));
            }    
        }

    }

    public function updateReminder(Request $request) {
        $user = Auth::guard('web')->user();

        $id     = $request->id;
        $detail = $request->detail;
        $date   = $request->date;
        $time   = $request->time;

        $repeat = (isset($request->repeat)) ? $request->repeat : 0;
        $period = (isset($request->period)) ? $request->period : 0;
        $quantity = (isset($request->quantity)) ? $request->quantity : 0;

        $reminder = Reminder::where('id', '=', $id)->where('created_by', '=', $user->id)->first();

        if(isset($reminder->id)) {
            $reminder->description = $detail;
            $reminder->date = date("Y-m-d", strtotime(str_replace("/","-", $date))) . ' ' . $time . ':00';
            $reminder->repeat = $repeat;
            $reminder->period = $period;
            $reminder->quantity = $quantity;
            $reminder->update();

            return response()->json(array('type' => '200', 'save' => 1));
        }else{
            return response()->json(array('type' => '200', 'save' => 4));
        }   
    }

    public function saveAttach(Request $request) {
        $user = Auth::guard('web')->user();

        $id = $request->attachIdAppointment;
        $id_pet = (isset($request->attachIdPetAppointment)) ? $request->attachIdPetAppointment : 0;

        if(($id == 0) && ($id_pet != 0)) {

        }else{
            $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner')
                ->where('id', '=', $id)
                ->first();

            if(($appointment->id_user != $user->id)&&($user->rol_id != 8)) {
                $thisuser = User::select('id', 'id_vet')->where('id', '=', $appointment->id_user)->first();

                if(((isset($thisuser->id_vet)) && ($thisuser->id_vet != $user->id_vet)) || (!isset($thisuser->id_vet))) {
                    return response()->json(array('type' => '200', 'save' => 0, 'error' => ''));
                }
            }

            $id_pet = $appointment->id_pet;
        }

        if(($user->rol_id != 8) && ($user->id_vet != 0)) {
            $vet = Vets::where('id', '=', $user->id_vet)->first();

            $setting = Setting::getLimitsSetting();

            $maxStorage = 0;
            if($vet->pro == 1) {
                $maxStorage = $setting->max_storage_pro;
            }else{
                $maxStorage = $setting->max_storage_free;
            }

            $attachSize = AppointmentAttachment::where('id_vet_created', '=', $user->id_vet)->sum('size');
            if(($maxStorage > 0) && ($attachSize >= $maxStorage)) {
                return response()->json(array('type' => '200', 'save' => 0, 'error' => trans('auth.failed.add.storage.pro', ['linkPlan' => '<a href="'.route('plan').'">aqui</a>', 'linkPlanHere' => '<a href="'.route('plan').'">here</a>'])));
            }
        }

        if($request->hasfile('fileModalMultiple')) {
            
            foreach($request->file('fileModalMultiple') as $file) {
                $realname = preg_replace('/\..+$/', '', $file->getClientOriginalName());
                $size = $file->getSize();
                $imageName = uniqid().time().'attach.'.$file->extension();

                if(!File::isDirectory(public_path('files/attach/'.$id_pet))) {
                    File::makeDirectory(public_path('files/attach/'.$id_pet), '0777', true, true);
                    chmod(public_path('files/attach/'.$id_pet), 0777);
                }

                if($file->move(public_path('files/attach/'.$id_pet), $imageName)) {
                    AppointmentAttachment::create([
                        'id_appointment' => $id,
                        'id_pet' => $id_pet,
                        'title' => $realname,
                        'folder' => 'attach/' . $id_pet,
                        'attach' => $imageName,
                        'size' => ($size > 0) ? (($size / 1024) / 1024) : 0,
                        'created_by' => $user->id,
                        'id_vet_created' => $user->id_vet
                    ]);
                }
            }
         }

         return response()->json(array('type' => '200', 'save' => 1));
    }

    public function deleteAttach(Request $request) {
        $user = Auth::guard('web')->user();

        $id = $request->id;

        $attach = AppointmentAttachment::select('id', 'id_appointment', 'id_pet', 'folder', 'attach', 'created_by', 'created_by')
            ->where('id', '=', $id)
            ->first();

        if($attach->created_by != $user->id) {
            return response()->json(array('type' => '200', 'process' => '500'));
        }

        if($attach->attach != '') {
            if (file_exists(public_path('files/' . $attach->folder . '/' . $attach->attach))) {
                @unlink(public_path('files/' . $attach->folder . '/' . $attach->attach));
            }
        }
        $attach->delete();

        return response()->json(array('type' => '200', 'process' => '1'));
    }

    public function getRecipeData(Request $request) {
        $user = Auth::guard('web')->user();

        if(isset($request->onlyDetail)) {
            $recipe = AppointmentRecipe::select('id', 'id_appointment', 'created_at')->where('id', '=', $request->id)->with('detail')->first();
            return response()->json(array('type' => '200', 'recipe' => $recipe));
        }

        $lang = Config::get('app.locale');

        $types = RecipeTakes::select('id', 'title_' . $lang . ' as title')->where('enabled', '=', 1)->orderBy('title_'. $lang, 'ASC')->get();

        $medicines = Inventory::select('id', 'title', 'instructions')->where('id_vet', '=', $user->id_vet)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();

        $recipe = [];
        if((isset($request->get))&&(isset($request->id))) {
            $recipe = AppointmentRecipe::select('id', 'id_appointment', 'created_at')->where('id', '=', $request->id)->with('detail')->first();

            $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner')
                ->where('id', '=', $recipe->id_appointment)
                ->first();

            if($appointment->id_user != $user->id) {
                $thisuser = User::select('id', 'id_vet')->where('id', '=', $appointment->id_user)->first();

                if(((isset($thisuser->id_vet)) && ($thisuser->id_vet != $user->id_vet)) || (!isset($thisuser->id_vet))) {
                    $recipe = [];
                }
            }
        }

        return response()->json(array('type' => '200', 'types' => $types, 'medicines' => $medicines, 'recipe' => $recipe));
    }

    public function saveRecipe(Request $request) {
        $user = Auth::guard('web')->user();

        $id = $request->medicineIdAppointment;
        $id_pet = (isset($request->medicineIdPetAppointment)) ? $request->medicineIdPetAppointment : 0;

        if(($id == 0) && ($id_pet != 0)) {

        }else{
            $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner')
                ->where('id', '=', $id)
                ->first();

            if($appointment->id_user != $user->id) {
                $thisuser = User::select('id', 'id_vet')->where('id', '=', $appointment->id_user)->first();

                if(((isset($thisuser->id_vet)) && ($thisuser->id_vet != $user->id_vet)) || (!isset($thisuser->id_vet))) {
                    return response()->json(array('type' => '200', 'save' => 0));
                }
            }

            $id_pet = $appointment->id_pet;
        }

        $lang = Config::get('app.locale');

        $recipe = AppointmentRecipe::create([
            'id_appointment' => $id,
            'id_pet' => $id_pet,
            'created_by' => $user->id,
            'id_vet_created' => $user->id_vet
        ]);

        if(isset($recipe->id)) {
            if(isset($_POST['medicineModalAp'])){
                for($i = 0;$i < count($_POST['medicineModalAp']);$i++){
                    if($_POST['medicineModalAp'][$i] != ""){
                        $title = '';
                        if($_POST['medicineModalAp'][$i] != 0) {
                            $medicineTitle = Inventory::select('id', 'title')->where('id', '=', $_POST['medicineModalAp'][$i])->first();
                            $title = (isset($medicineTitle->title)) ? $medicineTitle->title : '';
                        }else{
                            $title = $_POST['otherModalAp'][$i];
                        }

                        $takeTitle = RecipeTakes::select('id', 'title_' . $lang . ' as title')->where('id', '=', $_POST['takeModalAp'][$i])->first();

                        AppointmentRecipeDetails::create([
                            'id_recipe' => $recipe->id,
                            'id_medicine' => $_POST['medicineModalAp'][$i],
                            'title' => $title,
                            'duration' => $_POST['durationModalAp'][$i],
                            'id_take' => $_POST['takeModalAp'][$i],
                            'take' => (isset($takeTitle->title)) ? $takeTitle->title : '',
                            'quantity' => $_POST['quantityModalAp'][$i],
                            'instruction' => $_POST['indicationsModalAp'][$i],
                        ]);
                    }
                }
            }
        }

        return response()->json(array('type' => '200', 'save' => 1));
    }

    public function updateRecipe(Request $request) {
        $user = Auth::guard('web')->user();

        $recipe = AppointmentRecipe::select('id', 'id_appointment', 'created_at')->where('id', '=', $request->medicineIdAppointmentEdit)->first();

        if(isset($recipe->id)) {
            if(isset($_POST['medicineModalApId'])){
                $lang = Config::get('app.locale');

                $rowsEdits = [];

                for($i = 0;$i < count($_POST['medicineModalApId']);$i++){
                    if($_POST['medicineModalApId'][$i] != ""){
                        $title = '';
                        if($_POST['medicineModalAp'][$i] != 0) {
                            $medicineTitle = Inventory::select('id', 'title')->where('id', '=', $_POST['medicineModalAp'][$i])->first();
                            $title = (isset($medicineTitle->title)) ? $medicineTitle->title : '';
                        }else{
                            $title = $_POST['otherModalAp'][$i];
                        }
                        
                        $takeTitle = RecipeTakes::select('id', 'title_' . $lang . ' as title')->where('id', '=', $_POST['takeModalAp'][$i])->first();

                        if($_POST['medicineModalApId'][$i] != 0) {
                            $detail = AppointmentRecipeDetails::where('id', '=', $_POST['medicineModalApId'][$i])->where('id_recipe', '=', $recipe->id)->first();

                            if(isset($detail->id)) {
                                $detail->id_recipe = $recipe->id;
                                $detail->id_medicine = $_POST['medicineModalAp'][$i];
                                $detail->title = $title;
                                $detail->duration = $_POST['durationModalAp'][$i];
                                $detail->id_take = $_POST['takeModalAp'][$i];
                                $detail->take = (isset($takeTitle->title)) ? $takeTitle->title : '';
                                $detail->quantity = $_POST['quantityModalAp'][$i];
                                $detail->instruction = $_POST['indicationsModalAp'][$i];
                                $detail->update();

                                array_push($rowsEdits, $detail->id);
                            }                            
                        }else{
                            $detailCreate = AppointmentRecipeDetails::create([
                                'id_recipe' => $recipe->id,
                                'id_medicine' => $_POST['medicineModalAp'][$i],
                                'title' => $title,
                                'duration' => $_POST['durationModalAp'][$i],
                                'id_take' => $_POST['takeModalAp'][$i],
                                'take' => (isset($takeTitle->title)) ? $takeTitle->title : '',
                                'quantity' => $_POST['quantityModalAp'][$i],
                                'instruction' => $_POST['indicationsModalAp'][$i],
                            ]);
                            array_push($rowsEdits, $detailCreate->id);
                        }
                    }
                }

                $details = AppointmentRecipeDetails::where('id_recipe', '=', $recipe->id)->whereNotIn('id', $rowsEdits)->get();

                if(count($details) > 0) {
                    foreach ($details as $row) {
                        $row->delete();
                    }
                }
            }
        }

        return response()->json(array('type' => '200', 'save' => 1));
    }

    public function deleteRecipe(Request $request) {
        $user = Auth::guard('web')->user();

        $id = $request->id;

        $recipe = AppointmentRecipe::select('id', 'id_appointment')
            ->where('id', '=', $id)
            ->first();

        $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner')
            ->where('id', '=', $recipe->id_appointment)
            ->first();

        if($appointment->id_user != $user->id) {
            $thisuser = User::select('id', 'id_vet')->where('id', '=', $appointment->id_user)->first();

            if(((isset($thisuser->id_vet)) && ($thisuser->id_vet != $user->id_vet)) || (!isset($thisuser->id_vet))) {
                return response()->json(array('type' => '200', 'process' => '500'));
            }
        }

        $rows = AppointmentRecipeDetails::where('id_recipe', '=', $id)->get();

        $recipe->delete();
        foreach ($rows as $row) {
            $row->delete();
        }

        return response()->json(array('type' => '200', 'process' => '1'));
    }

    public function cancelOrReschedule(Request $request) {
        $user = Auth::guard('web')->user();
        
        $id = $request->id;
        if(isset($request->encrypt)) {
            $id = User::encryptor('decrypt', $id);
        }

        $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
            ->where('id', '=', $id)
            ->with('getDoctor')
            ->with('getClient')
            ->first();

        if(($appointment->id_user != $user->id)&&($user->rol_id != 8)) {
            $thisuser = User::select('id', 'id_vet')->where('id', '=', $appointment->id_user)->first();

            if(((isset($thisuser->id_vet)) && ($thisuser->id_vet != $user->id_vet)) || (!isset($thisuser->id_vet))) {
                return response()->json(array('type' => '200', 'process' => '500'));
            }
        }

        $option = $request->option;

        if($option == 'cancelar') {
            $appointment->status = 3;
            $appointment->update();

            /*** Remove reminders ***/
            $reminders = Reminder::where('status', '=', 0)->where('id_appointment', '=', $appointment->id)->get();
            foreach($reminders as $reminder) {
                $reminder->delete();
            }

            $id_vet = (isset($appointment['getDoctor']['id_vet'])) ? $appointment['getDoctor']['id_vet'] : 0;
            $name = (isset($appointment['getClient']['name'])) ? $appointment['getClient']['name'] : ''; 
            $date = date('d', strtotime($appointment->date)) . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($appointment->date)))) . ' ' . trans('dash.label.of') . ' ' . date('Y', strtotime($appointment->date)) . ' ' . trans('dash.label.confirm.appointment.at') . ' ' . date('h:i a', strtotime($appointment->hour));
            $doctor = (isset($appointment['getDoctor']['name'])) ? $appointment['getDoctor']['name'] : '';
            $iddoctor = (isset($appointment['getDoctor']['id'])) ? $appointment['getDoctor']['id'] : 0;

            $data = [
                'name' => $name, 
                'date' => $date, 
                'doctor' => $doctor,
                'iddoctor' => $iddoctor
            ];
            $template = view('emails.general.cancel-appointment', $data)->render();

            $row = Notifications::create([
                'id_user' => (isset($appointment['getClient']['id'])) ? $appointment['getClient']['id'] : 0,
                'to' => (isset($appointment['getClient']['email'])) ? $appointment['getClient']['email'] : '',
                'subject' => trans('auth.label.cancel.appointment.title'),
                'description' => $template,
                'attach' => '',
                'email' => 1,
                'sms' => 0,
                'whatsapp' => 0,
                'status' => 0,
                'attemps' => 0
            ]);

            $vet = Vets::select('id', 'pro')->where('id', '=', $id_vet)->first();
    
            if((isset($vet->id)) && ($vet->pro == 1)) {
                
                $template = trans('auth.register.complete.hello') . ' ' . $name .', ' . trans('auth.label.cancel.appointment.intro', ['date' => $date, 'doctor' => $doctor]) . ' ' . trans('auth.label.cancel.link') . ' ' . trans('auth.label.cancel.at') . ' ' . url('book/hours/' . User::encryptor('encrypt', $iddoctor));

                Notifications::create([
                    'id_user' => (isset($appointment['getClient']['id'])) ? $appointment['getClient']['id'] : 0,
                    'to' => (isset($appointment['getClient']['phone'])) ? $appointment['getClient']['phone'] : '',
                    'subject' => 'sms',
                    'description' => $template,
                    'attach' => '',
                    'email' => 0,
                    'sms' => 1,
                    'whatsapp' => 0,
                    'status' => 0,
                    'attemps' => 0
                ]);
                
                Notifications::create([
                    'id_user' => (isset($appointment['getClient']['id'])) ? $appointment['getClient']['id'] : 0,
                    'to' => (isset($appointment['getClient']['phone'])) ? $appointment['getClient']['phone'] : '',
                    'subject' => 'whatsapp',
                    'description' => $template,
                    'attach' => '',
                    'email' => 0,
                    'sms' => 0,
                    'whatsapp' => 1,
                    'status' => 0,
                    'attemps' => 0
                ]);
            }

            return response()->json(array('type' => '200', 'process' => '1'));
        }

        if($option == 'reagendar') {
            /*** Use new quota ***/
            $newhour = AppointmentHour::where('id', '=', $request->time)->first();

            if((isset($newhour->id))&&($newhour->status == 0)) {
                /*** Release current quota ***/
                $oldhour = AppointmentHour::where('id', '=', $appointment->id_hours)->first();
                if(isset($oldhour->id)) {
                    $oldhour->status = 0;
                    $oldhour->expire = null;
                    $oldhour->user_reserve = 0;
                    $oldhour->update();
                }
                
                $appointment->id_hours = $newhour->id;
                $appointment->date = $newhour->date;
                $appointment->hour = $newhour->hour;
                $appointment->reminder = 0;
                $appointment->update();
    
                $newhour->status = 1;
                $newhour->update();
            }else{
                return response()->json(array('type' => '200', 'process' => '401'));
            }

            /*** Remove reminders ***/
            $reminders = Reminder::where('status', '=', 0)->where('id_appointment', '=', $appointment->id)->get();
            foreach($reminders as $reminder) {
                $reminder->delete();
            }

            return response()->json(array('type' => '200', 'process' => '1'));
        }
    }

    public function sendAttach(Request $request) {
        $id = $request->id;

        $attach = AppointmentAttachment::select('id', 'title')->where('id', '=', $id)->first();

        if(isset($attach->id)) {
            $params = [
                'subject' => trans('dash.controller.subject.email.attach'),
                'description' => trans('dash.controller.description.email.attach', ['title' => $attach->title]),
                'id' => User::encryptor('encrypt', $id)
            ];
            $template = view('emails.general.send-attach', $params)->render();
    
            $row = Notifications::create([
                'id_user' => 0,
                'to' => $request->email,
                'subject' => trans('dash.controller.subject.email.attach'),
                'description' => $template,
                'attach' => '',
                'email' => 1,
                'sms' => 0,
                'whatsapp' => 0,
                'status' => 0,
                'attemps' => 0
            ]);
            
            (new sendNotifieds)->sendEmail($row);
        }

        return response()->json(array('type' => '200', 'send' => '1', 'attach' => $attach));
    }

    public function sendRecipe(Request $request) {
        $id = $request->id;

        $recipe = AppointmentRecipe::select('id', 'id_pet', 'created_at', 'created_by')->where('id', '=', $id)->first();
        $details = AppointmentRecipeDetails::where('id_recipe', '=', $id)->get();

        $pet = Pet::select('id', 'name')->where('id', '=', $recipe->id_pet)->first();

        $doctor = [];
        $vet = [];
        if($recipe->created_by != 0) {
            $doctor = User::select('id', 'name', 'id_vet', 'code', 'signature')->where('id', '=', $recipe->created_by)->first();

            $vet = Vets::where('id', '=', $doctor->id_vet)->first();
        }

        $filename = 'recipe_' . $id . '_' . date('dmY_Hia') . '.pdf'; 
        
        $data = [
            'details' => $details,
            'recipe' => $recipe,
            'pet' => $pet,
            'doctor' => $doctor,
            'vet' => $vet
        ];

        PDF::loadView('pdf.recipe', $data)->save(public_path('files/tmp/') . $filename);

        $params = [
            'subject' => trans('dash.controller.subject.email.recipe') . ' #' . str_pad($id, 6, "0", STR_PAD_LEFT),
            'description' => trans('dash.controller.description.email.recipe')
        ];
        $template = view('emails.general.generic', $params)->render();

        $row = Notifications::create([
            'id_user' => 0,
            'to' => $request->email,
            'subject' => trans('dash.controller.subject.email.recipe') . ' #' . str_pad($id, 6, "0", STR_PAD_LEFT),
            'description' => $template,
            'attach' => 'files/tmp/' . $filename,
            'email' => 1,
            'sms' => 0,
            'whatsapp' => 0,
            'status' => 1,
            'attemps' => 0
        ]);

        (new sendNotifieds)->sendEmail($row);

        return response()->json(array('type' => '200', 'send' => '1'));
    }

    public function downloadRecipe(Request $request) {
        $id = $request->id;

        $recipe = AppointmentRecipe::select('id', 'id_pet', 'created_at', 'created_by')->where('id', '=', $id)->first();
        $details = AppointmentRecipeDetails::where('id_recipe', '=', $id)->get();

        $pet = Pet::select('id', 'name')->where('id', '=', $recipe->id_pet)->first();

        $doctor = [];
        $vet = [];
        if($recipe->created_by != 0) {
            $doctor = User::select('id', 'name', 'id_vet', 'code', 'signature')->where('id', '=', $recipe->created_by)->first();

            $vet = Vets::where('id', '=', $doctor->id_vet)->first();
        }

        $filename = 'recipe_' . $id . '_' . date('dmY_Hia') . '.pdf'; 
        
        $data = [
            'details' => $details,
            'recipe' => $recipe,
            'pet' => $pet,
            'doctor' => $doctor,
            'vet' => $vet
        ];

        $pdf = PDF::loadView('pdf.recipe', $data)->save(public_path('files/tmp/') . $filename);

        return $pdf->download($filename);
    }

    public function printRecipe(Request $request) {
        $id = User::encryptor('decrypt', $request->id);

        $recipe = AppointmentRecipe::select('id', 'id_pet', 'created_at', 'created_by')->where('id', '=', $id)->first();
        $details = AppointmentRecipeDetails::where('id_recipe', '=', $id)->get();

        $pet = Pet::select('id', 'name')->where('id', '=', $recipe->id_pet)->first();

        $doctor = [];
        $vet = [];
        if($recipe->created_by != 0) {
            $doctor = User::select('id', 'name', 'id_vet', 'code', 'signature')->where('id', '=', $recipe->created_by)->first();

            $vet = Vets::where('id', '=', $doctor->id_vet)->first();
        }

        $printerNow = (isset($request->later)) ? $request->later : '';

        return view('printer.recipe', compact('recipe', 'details', 'pet', 'doctor', 'vet', 'printerNow'));
    }

    public function createVaccine(Request $request) {
        $offline = (isset($request->vaccineOffline)) ? User::encryptor('decrypt', $request->vaccineOffline) : 0;

        $user = Auth::guard('web')->user();

        $doctorName = '';
        $doctorCode = '';
        $id_pet = 0;
        $id_owner = 0; 

        if($offline != 0) {
            $doctorName = $request->doctorName;
            $doctorCode = $request->doctorId;

            $pet = Pet::select('id', 'id_user', 'name')->where('id', '=', $offline)->first();
            if(isset($pet->id)) {
                $id_pet = $pet->id;
                $id_owner = $pet->id_user;
            }else{
                return response()->json(array('type' => '400'));
            }
        }else{
            $id_pet = $request->vaccineIdPet;
            $id_owner = $request->vaccineIdOwner;

            $pet = Pet::select('id', 'id_user', 'name')->where('id', '=', $id_pet)->first();

            $doctorName = (isset($user->name)) ? $user->name : '';
            $doctorCode = (isset($user->code)) ? $user->code : '';
        }

        $date = (isset($request->vaccineDate)) ? $request->vaccineDate : date('Y-m-d');
        $dateExp = (isset($request->vaccineDateExpire)) ? $request->vaccineDateExpire : '';

        $interval = (isset($request->interval)) ? $request->interval : 0;
        $nextDate = null;
        if($interval > 0) {
            $nextDate = Carbon::now();
            $nextDate = $nextDate->addDays($interval);
            $nextDate = $nextDate->toDateString();
        }

        $vaccineSave = Vaccine::create([
            'section' => $request->sectionVaccineAdd,
            'id_pet' => $id_pet,
            'id_owner' => $id_owner,
            'id_doctor' => (isset($user->id)) ? $user->id : 0,
            'doctor_name' => $doctorName,
            'doctor_code' => $doctorCode,
            'name' => $request->vaccineName,
            'date' => date("Y-m-d", strtotime(str_replace("/","-", $date))),
            'brand' => $request->vaccineBrand,
            'batch' => $request->vaccineBatch,
            'expire' => ($dateExp != '') ? date("Y-m-d", strtotime(str_replace("/","-", $dateExp))) : null,
            'photo' => '',
            'interval' => $interval,
            'next_date' => $nextDate,
            'id_vet_created' => (isset($user->id_vet)) ? $user->id_vet : 0
        ]);

        if($request->hasfile('vaccinePhoto')) {
            $file = $request->file('vaccinePhoto');
            $imageName = uniqid().time().'vaccine.'.$file->extension();

            if(!File::isDirectory(public_path('files/vaccine/image'))) {
                File::makeDirectory(public_path('files/vaccine/image'), '0777', true, true);
                chmod(public_path('files/vaccine/image'), 0777);
            }

            $newImage = Image::make($file->getRealPath());
            if($newImage != null){
                $new_width  = 300;
                $new_height = 300;
            
                $newImage->resize($new_width, $new_height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            
                $newImage->save(public_path('files/vaccine/image/' . $imageName));

                $vaccineSave->photo = 'files/vaccine/image/' . $imageName;
                $vaccineSave->update();
            }
        }

        if($interval > 15) {
            $nextDate = Carbon::now();
            $nextDate = $nextDate->addDays($interval - 15);
            $nextDate = $nextDate->toDateString();

            Reminder::create([
                'id_user' => (isset($user->id)) ? $user->id : 0,
                'section' => 0,
                'to' => (isset($user->email)) ? $user->email : '',
                'description' => 'Se debe realizar la aplicación de vacuna ' . $request->vaccineName . ' en 15 días a la mascota ' . $pet->name,
                'date' => $nextDate . ' 08:00:00',
                'email' => 1,
                'sms' => 0,
                'whatsapp' => 0,
                'status' => 0,
                'attemps' => 0,
                'id_appointment' => 0,
                'id_pet' => $id_pet,
                'read' => 0,
                'repeat' => 0,
                'period' => 0,
                'quantity' => 0,
                'created_by' => $user->id
            ]);
        }

        return response()->json(array('type' => '200'));
    }

    public function getVaccineData(Request $request) {
        $id = User::encryptor('decrypt', $request->id);

        $vaccine = Vaccine::where('id', '=', $id)
                ->with('getDoctor')
                ->first();

        $result = [
            'date' => ($vaccine->date != '') ? date('d/m/Y', strtotime($vaccine->date)) : date('d/m/Y', strtotime($vaccine->created_at)),
            'name' => $vaccine->name,
            'brand' => ($vaccine->brand != '') ? $vaccine->brand : 'NA',
            'batch' => ($vaccine->batch != '') ? $vaccine->batch : 'NA',
            'expire' => ($vaccine->expire != '') ? date('d/m/Y', strtotime($vaccine->expire)) : 'NA',
            'photo' => ($vaccine->photo != '') ? $vaccine->photo : '',
            'nameDoctor' => (isset($vaccine['getDoctor']['name'])) ? $vaccine['getDoctor']['name'] : '',
            'signature' => (isset($vaccine['getDoctor']['signature'])) ? $vaccine['getDoctor']['signature'] : ''
        ];

        return response()->json(array('result' => $result, 'type' => '200'));
    }

    public function notifiedCreateAppointment($id = 0) {        
        $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
                ->where('id', '=', $id)
                ->with('getDoctor')
                ->with('getClient')
                ->first();

        $data = [
            'appointmentId' => $appointment->id,
            'name' => (isset($appointment['getClient']['name'])) ? $appointment['getClient']['name'] : '', 
            'date' => date('d', strtotime($appointment->date)) . ' ' . strtolower(trans('dash.month.num' . (int)date('m', strtotime($appointment->date)))) . ' ' . trans('dash.label.of') . ' ' . date('Y', strtotime($appointment->date)) . ' ' . trans('dash.label.confirm.appointment.at') . ' ' . date('h:i a', strtotime($appointment->hour)), 
            'created' => date('Y-m-d', strtotime($appointment->date)) . ' ' . date('H:i:s', strtotime($appointment->hour)),
            'doctor' => (isset($appointment['getDoctor']['name'])) ? $appointment['getDoctor']['name'] : ''
        ];
        $template = view('emails.general.create-appointment', $data)->render();

        $row = Notifications::create([
            'id_user' => (isset($appointment['getClient']['id'])) ? $appointment['getClient']['id'] : 0,
            'to' => (isset($appointment['getClient']['email'])) ? $appointment['getClient']['email'] : '',
            'subject' => trans('auth.label.create.appointment.title'),
            'description' => $template,
            'attach' => '',
            'email' => 1,
            'sms' => 0,
            'whatsapp' => 0,
            'status' => 0,
            'attemps' => 0
        ]);

        return true;
    }

    public function getCountries() {
        $countries = Countries::select('id', 'title', 'phonecode')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
        return response()->json(array('countries' => $countries));
    }

    public function appointmentCancel(Request $request) {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->id);

        $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
                ->where('id', '=', $id)
                ->with('getPet')
                ->first();

        if(isset($appointment->id)) {
            if($user->rol_id == 8) {
                if($user->id != $appointment->id_owner) {
                    return redirect(route('dash'));
                }
            }else{
                $vets = Vets::getUserMyVet($user->id_vet);
                
                $exist = false;
                foreach ($vets as $value) {
                    if($value->id == $appointment->id_user) {
                        $exist = true;
                    }
                }
                if($exist == false) {
                    return redirect(route('dash'));
                }
            }
        }else{
            return redirect(route('dash'));
        }

        return view('appointments.cancel', compact('appointment'));
    }

    public function appointmentReschedule(Request $request) {
        $user = Auth::guard('web')->user();

        $idEncrypt = $request->id;
        $id = User::encryptor('decrypt', $request->id);

        $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
                ->where('id', '=', $id)
                ->with('getPet')
                ->first();

        if(isset($appointment->id)) {
            if($user->rol_id == 8) {
                if($user->id != $appointment->id_owner) {
                    return redirect(route('dash'));
                }
            }else{
                $vets = Vets::getUserMyVet($user->id_vet);
                
                $exist = false;
                foreach ($vets as $value) {
                    if($value->id == $appointment->id_user) {
                        $exist = true;
                    }
                }
                if($exist == false) {
                    return redirect(route('dash'));
                }
            }
        }else{
            return redirect(route('dash'));
        }

        return view('appointments.reschedule', compact('appointment', 'user', 'idEncrypt'));
    }

    public function sendEntryVaccine(Request $request) {
        $id = $request->id;

        $pet = Pet::select('id', 'name')->where('id', '=', $id)->first();

        if(isset($pet->id)) {
            $params = [
                'petId' => $id,
                'namepet' => $pet->name
            ];
            $template = view('emails.general.entry-vaccine', $params)->render();

            $row = Notifications::create([
                'id_user' => 0,
                'to' => $request->email,
                'subject' => trans('dash.controller.subject.email.entry.vaccine'),
                'description' => $template,
                'attach' => '',
                'email' => 1,
                'sms' => 0,
                'whatsapp' => 0,
                'status' => 1,
                'attemps' => 0
            ]);

            (new sendNotifieds)->sendEmail($row);
        }

        return response()->json(array('type' => '200', 'send' => '1'));
    }

}
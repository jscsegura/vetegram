<?php

namespace App\Http\Controllers;

use App\Console\Commands\PersonalInfo;
use App\Models\AnimalBreed;
use App\Models\AnimalTypes;
use App\Models\Canton;
use App\Models\Countries;
use App\Models\District;
use App\Models\Language;
use App\Models\Notifications;
use App\Models\Pet;
use App\Models\Province;
use App\Models\Setting;
use App\Models\Specialties;
use App\Models\User;
use App\Models\UserVetDoctor;
use App\Models\Vets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    
    public function __construct() {}
    
    public function index(Request $request) {
        $user = Auth::guard('web')->user();

        $search = (isset($request->search)) ? $request->search : '';

        $rows = User::select('id', 'name', 'email', 'phone', 'rol_id', 'photo', 'lock', 'enabled', 'complete')->where('id_vet', '=', $user->id_vet);

        if($search != '') {
            $search = base64_decode($search);

            $searchParam = '%' . $search . '%';
            $rows = $rows->where('name', 'like', $searchParam);
        }

        $rows = $rows->paginate(30);

        $vet = Vets::where('id', '=', $user->id_vet)->first();

        $setting = Setting::getLimitsSetting();
        
        $maxUsers = 0;
        if($vet->pro == 1) {
            $maxUsers = $setting->max_user_pro;
        }else{
            $maxUsers = $setting->max_user_free;
        }

        $userCounter = User::where('id_vet', '=', $vet->id)->whereIn('rol_id', [3,4,5,6])->count();

        $limiteExcede = false;
        if(($maxUsers > 0) && ($userCounter >= $maxUsers)) {
            $limiteExcede = true;
        }  

        return view('users.index', compact('rows', 'search', 'limiteExcede', 'maxUsers'));
    }
    
    public function add() {
        $user = Auth::guard('web')->user();

        $vet = Vets::where('id', '=', $user->id_vet)->first();

        $countries = Countries::select('id', 'title', 'phonecode', 'default')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
        $provinces = Province::select('id', 'title')->where('enabled', '=', 1)->orderBy('id', 'ASC')->get();

        $cantons   = [];
        $districts = [];
        if($vet->country == 53) {
            $cantons   = Canton::select('id', 'title')->where('id_province', '=', $vet->province)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
            $districts = District::select('id', 'title')->where('id_canton', '=', $vet->canton)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
        }

        return view('users.add', compact('countries', 'provinces', 'cantons', 'districts', 'vet'));
    }

    public function store(Request $request) {
        $userSession = Auth::guard('web')->user();

        $user = User::select('id', 'email')->where('email', '=', $request->vEmail)->first();
        if(isset($user->id)) {
            session()->flash('error', trans('auth.failed.email.exist'));
            return redirect()->back();
        }

        $vet = Vets::where('id', '=', $userSession->id_vet)->first();

        $setting = Setting::getLimitsSetting();
        
        $maxUsers = 0;
        if($vet->pro == 1) {
            $maxUsers = $setting->max_user_pro;
        }else{
            $maxUsers = $setting->max_user_free;
        }

        $userCounter = User::where('id_vet', '=', $vet->id)->whereIn('rol_id', [3,4,5,6])->count();

        if(($maxUsers > 0) && ($userCounter >= $maxUsers)) {
            session()->flash('error', trans('auth.failed.add.user.pro', ['linkPlan' => '<a href="'.route('plan').'">aqui</a>', 'linkPlanHere' => '<a href="'.route('plan').'">here</a>']));
            return redirect()->back();
        }    

        DB::beginTransaction();
        try {
            $possible = '123456789abcdfghjkmnpqrstvwxyzABCDEFHKMNPQRTVWXYZ';
            $newPass = '';
            $i = 0;
            while ($i < 12) {
                $newPass .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
                $i++;
            }

            $user = new User();
            $user->id_vet            = $userSession->id_vet;
            $user->type_dni          = $request->idtype;
            $user->dni               = $request->idnumber;
            $user->name              = $request->name;
            $user->lastname          = '';
            $user->email             = $request->vEmail;
            $user->phone             = $request->phone;
            $user->email_verified_at = null;
            $user->password          = Hash::make($newPass);
            $user->rol_id            = $request->roluser;
            $user->country           = $request->country;
            $user->province          = $request->province;
            $user->canton            = $request->canton;
            $user->district          = $request->district;
            $user->code              = ($request->roluser == 4) ? $request->code : '';
            $user->facebook          = 0;
            $user->google            = 0;
            $user->enabled           = 0;
            $user->complete          = 0;
            $user->lock              = 0;
            $user->save();

            if(isset($user->id)) {

                $subject = trans('auth.register.email.verified');

                $data = ['token' => User::encryptor('encrypt', $user->id . '||' . $request->vEmail), 'email' => $request->vEmail, 'name' => $request->name, 'newPass' => $newPass];
                $template = view('emails.general.register', $data)->render();

                Notifications::create([
                    'id_user' => 0,
                    'to' => $request->vEmail,
                    'subject' => $subject,
                    'description' => $template,
                    'attach' => '',
                    'email' => 1,
                    'sms' => 0,
                    'whatsapp' => 0,
                    'status' => 0,
                    'attemps' => 0
                ]);

                DB::commit();

                return redirect(route('adminuser.index'));
            }else{
                DB::rollback();

                session()->flash('error', trans('auth.failed.register'));
                return redirect()->back();
            }

        } catch (\Throwable $th) {
            DB::rollback();

            session()->flash('error', trans('auth.failed.register'));
            return redirect()->back();
        }

        DB::rollback();

        session()->flash('error', trans('auth.failed.register'));
        return redirect()->back();
    }

    public function edit(Request $request) {
        $profile = Auth::guard('web')->user();

        $idUser = $request->id;
        $id = User::encryptor('decrypt', $request->id);

        $user = User::select('id', 'id_vet', 'type_dni', 'dni', 'name', 'lastname', 'email', 'country', 'province', 'canton', 'district', 'phone', 'code', 'rol_id', 'photo')
            ->where('id', '=', $id)
            ->first();

        if((!isset($user->id_vet)) || ($profile->id_vet != $user->id_vet)) {
            return redirect()->back();
        }

        $patients = UserVetDoctor::where('id_doctor', '=', $user->id)->distinct('id_client')->count();

        $countries = Countries::select('id', 'title', 'phonecode', 'default')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
        $provinces = Province::select('id', 'title')->where('enabled', '=', 1)->orderBy('id', 'ASC')->get();

        $cantons1   = [];
        $districts1 = [];
        if($user->country == 53) {
            $cantons1   = Canton::select('id', 'title')->where('id_province', '=', $user->province)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
            $districts1 = District::select('id', 'title')->where('id_canton', '=', $user->canton)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
        }

        $vet = [];
        $vet = Vets::where('id', '=', $user->id_vet)->first();

        $specialties = [];
        $languages = [];
        $cantons2   = [];
        $districts2 = [];
        if($user->rol_id == 3) {

            $specialties = Specialties::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->get();
            $languages   = Language::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->get();

            if(isset($vet->id)) {
                $cantons2   = Canton::select('id', 'title')->where('id_province', '=', $vet->province)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
                $districts2 = District::select('id', 'title')->where('id_canton', '=', $vet->canton)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
            }
        }

        return view('users.edit', compact('idUser', 'user', 'vet', 'patients', 'specialties', 'languages', 'countries', 'provinces', 'cantons1', 'districts1', 'cantons2', 'districts2', 'profile'));
    }

    public function delete(Request $request) {
        $id = User::encryptor('decrypt', $request->id);

        $row = User::select('id')
            ->where('id', '=', $id)
            ->first();

        if(isset($row->id)) {
            $row->forceDelete();

            return response()->json(array('type' => '200', 'process' => '1'));
        }

        return response()->json(array('type' => '200', 'process' => '500'));
    }

    public function changeLock(Request $request) {
        $id = User::encryptor('decrypt', $request->id);

        $row = User::select('id', 'lock')
            ->where('id', '=', $id)
            ->first();

        if(isset($row->id)) {
            $row->lock = $request->status;
            $row->update();

            return response()->json(array('type' => '200', 'process' => '1'));
        }

        return response()->json(array('type' => '200', 'process' => '500'));
    }

    public function patient(Request $request) {
        $user = Auth::guard('web')->user();

        $search = (isset($request->search)) ? $request->search : '';

        $vetUsers = User::select('id')->where('id_vet', '=', $user->id_vet)->pluck('id')->toArray();

        $clientIds = UserVetDoctor::whereIn('id_doctor', $vetUsers)->distinct('id_client')->pluck('id_client')->toArray();

        $pets = Pet::select('id', 'id_user', 'name', 'type', 'breed', 'photo')->whereIn('id_user', $clientIds);

        if($search != '') {
            $search = base64_decode($search);

            $searchParam = '%' . $search . '%';
            $pets = $pets->where('name', 'like', $searchParam);
        }

        $pets = $pets->with('getUser')->with('getType')->with('getBreed')->paginate(30);

        return view('users.patient', compact('pets', 'search'));
    }
    
    public function patientadd() {
        $user = Auth::guard('web')->user();

        $vetUsers = User::where('id_vet', '=', $user->id_vet)->pluck('id')->toArray();

        $clientIds = UserVetDoctor::whereIn('id_doctor', $vetUsers)->distinct('id_client')->pluck('id_client')->toArray();

        $owners = User::select('id', 'name', 'email')->whereIn('id', $clientIds)->get();

        $animalTypes = AnimalTypes::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->get();

        return view('users.patientadd', compact('owners', 'animalTypes'));
    }

    public function patientStore(Request $request) {
        $user = Auth::guard('web')->user();

        $pet = new Pet();
        $pet->id_user = $request->owner;
        $pet->name    = $request->dname;
        $pet->type    = $request->type;
        $pet->breed   = $request->breed;
        $pet->save();

        return redirect(route('adminpatient.index'));
    }

    public function patientview(Request $request) {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->id);

        $lang = Config::get('app.locale');

        $pet = Pet::where('id', '=', $id)->first();

        $animalTypes = AnimalTypes::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->get();

        $breeds = AnimalBreed::select('id', 'title_' . $lang . ' as title')->where('type', '=', $pet->type)->where('enabled', '=', 1)->orderBy('title_' . $lang, 'ASC')->get();

        $vetUsers = User::where('id_vet', '=', $user->id_vet)->pluck('id')->toArray();
        $clientIds = UserVetDoctor::whereIn('id_doctor', $vetUsers)->distinct('id_client')->pluck('id_client')->toArray();
        $owners = User::select('id', 'name', 'email')->whereIn('id', $clientIds)->get();

        $idPet = $request->id;

        return view('users.patientview', compact('pet', 'animalTypes', 'breeds', 'owners', 'idPet'));
    }

    public function patientUpdate(Request $request) {
        $id = User::encryptor('decrypt', $request->hideId);

        $pet = Pet::where('id', '=', $id)->first();

        $pet->id_user = $request->owner;
        $pet->name    = $request->dname;
        $pet->type    = $request->type;
        $pet->breed   = $request->breed;
        $pet->update();

        return redirect(route('adminpatient.index'));
    }

}
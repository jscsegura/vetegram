<?php

namespace App\Http\Controllers\Auth;

use App\Console\Commands\PersonalInfo;
use App\Console\Commands\sendNotifieds;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\AnimalBreed;
use App\Models\AnimalTypes;
use App\Models\Canton;
use App\Models\Countries;
use App\Models\District;
use App\Models\Language;
use App\Models\MedicalCollege;
use App\Models\Notifications;
use App\Models\Pet;
use App\Models\Province;
use App\Models\Setting;
use App\Models\Specialties;
use App\Models\Species;
use App\Models\ClinicService;
use App\Models\UserVetDoctor;
use App\Models\VeterinaryCredential;
use App\Models\Vets;
use App\Models\Schedule;
use App\Models\ScheduleDetails;
use App\Http\Requests\Setup\IdentityRequest;
use App\Http\Requests\Setup\ClinicRequest;
use App\Http\Requests\Setup\SpecialtiesRequest;
use App\Http\Requests\Setup\LocationRequest;
use App\Http\Requests\Setup\ScheduleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller {
    
    public function __construct() {}
    
    public function usertype() {
        return view('register.usertype');
    }

    
    public function getHaciendaInfo(Request $request) {
        $id = $request->id;
        $type = $request->type;

        $pi = new PersonalInfo();

        $res = $pi->handle($id);
        
        return response()->json($res);
    }

    public function signup(Request $request) {
        $type = $request->type;

        $setting = Setting::select('term_es', 'term_en')->where('id', '=', 1)->first();
        
        if(in_array($type, ['vet', 'owner'])) {
            return view('register.signup', compact('type', 'setting'));
        }else{
            return redirect()->route('usertype');
        }
    }

    public function register(Request $request) {
        $rol = $request->rol;

        $user = User::select('id', 'email')->where('email', '=', $request->email)->first();
        if(isset($user->id)) {
            if(isset($request->ajax)) {
                return response()->json(['type' => 'error', 'status' => trans('auth.failed.email.exist', [], 'es')], 200);
            }else{
                session()->flash('error', trans('auth.failed.email.exist'));
                return redirect()->back();
            }
        }

        DB::beginTransaction();
        try {
            $rolid = 8;
            switch ($rol) {
                case 'vet':$rolid = 3;
                    break;
                case 'owner':$rolid = 8;
                    break;
                default:$rolid = 8;
                    break;
            }
            
            $user = new User();
            $user->id_vet            = null;
            $user->type_dni          = null;
            $user->dni               = null;
            $user->name              = $request->name;
            $user->lastname          = '';
            $user->email             = $request->email;
            $user->email_verified_at = null;
            $user->password          = Hash::make($request->password);
            $user->rol_id            = $rolid;
            $user->facebook          = 0;
            $user->google            = 0;
            $user->enabled           = 0;
            $user->complete          = 0;
            $user->lock              = 0;
            $user->save();

            if(isset($user->id)) {

                $subject = trans('auth.register.email.verified');

                $data = ['token' => User::encryptor('encrypt', $user->id . '||' . $request->email), 'email' => $request->email, 'name' => $request->name];
                $template = view('emails.general.register', $data)->render();

                $row = Notifications::create([
                    'id_user' => 0,
                    'to' => $request->email,
                    'subject' => $subject,
                    'description' => $template,
                    'attach' => '',
                    'email' => 1,
                    'sms' => 0,
                    'whatsapp' => 0,
                    'status' => 1,
                    'attemps' => 0
                ]);

                (new sendNotifieds)->sendEmail($row);

                DB::commit();

                if(isset($request->ajax)) {
                    return response()->json(['type' => 'success'], 200);
                }else{
                    return redirect(route('register.complete'));
                }
            }else{
                DB::rollback();

                if(isset($request->ajax)) {
                    return response()->json(['type' => 'error', 'status' => trans('auth.failed.register', [], 'es')], 200);
                }else{
                    session()->flash('error', trans('auth.failed.register'));
                    return redirect()->back();
                }
            }

        } catch (\Throwable $th) {
            DB::rollback();

            if(isset($request->ajax)) {
                return response()->json(['type' => 'error', 'status' => trans('auth.failed.register', [], 'es')], 200);
            }else{
                session()->flash('error', trans('auth.failed.register'));
                return redirect()->back();
            }
        }

        DB::rollback();

        if(isset($request->ajax)) {
            return response()->json(['type' => 'error', 'status' => trans('auth.failed.register', [], 'es')], 200);
        }else{
            session()->flash('error', trans('auth.failed.register'));
            return redirect()->back();
        }

    }

    public function createOwner(Request $request) {
        $user = User::select('id', 'email')->where('email', '=', $request->emailCreateuser)->first();
        if(isset($user->id)) {
            return response()->json(array('type' => '200', 'result' => 'userexist'));
        }

        DB::beginTransaction();
        try {
            $rolid = 8;

            $possible = '123456789abcdfghjkmnpqrstvwxyzABCDEFHKMNPQRTVWXYZ';
            $newPass = '';
            $i = 0;
            while ($i < 12) {
                $newPass .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
                $i++;
            }

            $user = new User();
            $user->id_vet            = null;
            $user->type_dni          = null;
            $user->dni               = null;
            $user->name              = $request->nameCreateuser;
            $user->lastname          = '';
            $user->email             = $request->emailCreateuser;
            $user->email_verified_at = null;
            $user->password          = Hash::make($newPass);
            $user->rol_id            = $rolid;
            $user->facebook          = 0;
            $user->google            = 0;
            $user->enabled           = 0;
            $user->complete          = 0;
            $user->lock              = 0;
            $user->save();

            if(isset($user->id)) {

                /*** create pet ***/
                $pet = new Pet();
                $pet->id_user = $user->id;
                $pet->name    = $request->petNameCreateuser;
                $pet->type    = $request->petTypeCreateuser;
                $pet->breed   = $request->petBreedCreateuser;
                $pet->save();

                if(isset($request->createPermission)) {
                    $userInSession = Auth::guard('web')->user();

                    VeterinaryCredential::setCredentials($user->id, $userInSession->id_vet);
                }

                if((isset($request->associateUserDoctor)) && ($request->associateUserDoctor == '1')) {
                    $userInSession = Auth::guard('web')->user();

                    UserVetDoctor::firstOrCreate(
                        ['id_client' => $user->id, 'id_vet' => $userInSession->id_vet, 'id_doctor' => $userInSession->id],
                        []
                    );
                }

                $subject = trans('auth.register.email.verified');

                $data = ['token' => User::encryptor('encrypt', $user->id . '||' . $request->emailCreateuser), 'email' => $request->emailCreateuser, 'name' => $request->nameCreateuser, 'newPass' => $newPass];
                $template = view('emails.general.register', $data)->render();

                $row = Notifications::create([
                    'id_user' => 0,
                    'to' => $request->emailCreateuser,
                    'subject' => $subject,
                    'description' => $template,
                    'attach' => '',
                    'email' => 1,
                    'sms' => 0,
                    'whatsapp' => 0,
                    'status' => 1,
                    'attemps' => 0
                ]);

                (new sendNotifieds)->sendEmail($row);

                DB::commit();

                return response()->json(array('type' => '200', 'result' => 'create', 'data' => $pet->id . ':' . $user->id));
            }else{
                DB::rollback();

                return response()->json(array('type' => '200', 'result' => 'error'));
            }

        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json(array('type' => '200', 'result' => 'error'));
        }

        DB::rollback();
    }

    public function complete() {
        return view('register.complete');
    }

    public function confirm(Request $request) {
        
        $verified = false;
        $token = (isset($request->token)) ? $request->token : '';

        if($token != '') {
            $token = User::encryptor('decrypt', $token);

            if($token != '') {
                $params = explode("||", $token);

                if((isset($params[0]))&&(isset($params[1]))) {
                    $user = User::select('id', 'email', 'email_verified_at', 'enabled')->where('id', '=', $params[0])->where('email', '=', $params[1])->first();

                    if(isset($user->id)) {
                        $user->email_verified_at = date('Y-m-d H:i:s');
                        $user->enabled = 1;
                        $user->update();

                        $verified = true;
                    }
                }
            }
        }

        return view('register.verified', compact('verified'));
    }

    public function completeProfile() {
        $user = Auth::guard('web')->user();

        if ($user->rol_id == 3) {
            $countries   = Countries::select('id', 'title', 'phonecode', 'default')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
            $provinces   = Province::select('id', 'title')->where('enabled', '=', 1)->orderBy('id', 'ASC')->get();
            $specialties = Specialties::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->get();
            $languages   = Language::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->get();
            $species     = Species::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->orderBy('id', 'ASC')->get();
            $clinicServices = ClinicService::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->orderBy('id', 'ASC')->get();
            $vet         = Vets::select('id', 'type_dni', 'dni', 'country', 'code', 'social_name', 'company', 'address', 'province', 'canton', 'district', 'phone', 'specialities', 'species', 'languages', 'services', 'email', 'website', 'schedule', 'resume', 'lat', 'lng')
                ->where('id', '=', $user->id_vet)
                ->first();

            $lang = app()->getLocale();
            $specialtyLookup = [];
            foreach ($specialties as $specialty) {
                $key = strtolower(trim($specialty->title_en));
                $specialtyLookup[$key] = $specialty;
            }

            $specialtyGroups = [
                [
                    'label' => trans('auth.register.complete.specialties.group.core'),
                    'items' => [
                        'General Practice',
                        'Preventive Care',
                        'Vaccination & Wellness',
                        'Internal Medicine',
                        'Surgery (General)',
                        'Dentistry',
                        'Emergency & Urgent Care',
                    ],
                ],
                [
                    'label' => trans('auth.register.complete.specialties.group.clinical'),
                    'items' => [
                        'Dermatology',
                        'Cardiology',
                        'Neurology',
                        'Oncology',
                        'Ophthalmology',
                        'Orthopedics',
                        'Anesthesiology',
                        'Radiology/Diagnostic Imaging',
                        'Rehabilitation & Physical Therapy',
                        'Pain Management',
                    ],
                ],
                [
                    'label' => trans('auth.register.complete.specialties.group.diagnostics'),
                    'items' => [
                        'Laboratory Diagnostics',
                        'Ultrasound',
                        'X-Ray',
                        'Endoscopy',
                        'Pathology',
                    ],
                ],
                [
                    'label' => trans('auth.register.complete.specialties.group.behavioral'),
                    'items' => [
                        'Behavioral Medicine',
                        'Nutrition',
                        'Integrative Medicine',
                        'Acupuncture',
                        'Chiropractic Care',
                    ],
                ],
            ];

            $specialtyGroupsView = [];
            foreach ($specialtyGroups as $group) {
                $items = [];
                foreach ($group['items'] as $titleEn) {
                    $key = strtolower(trim($titleEn));
                    if (isset($specialtyLookup[$key])) {
                        $spec = $specialtyLookup[$key];
                        $items[] = [
                            'id' => $spec->id,
                            'label' => $spec->{'title_' . $lang} ?? $spec->title_en,
                        ];
                    }
                }
                $specialtyGroupsView[] = [
                    'label' => $group['label'],
                    'items' => $items,
                ];
            }

            $schedule = Schedule::with('scheduleDetails')->where('id_user', $user->id)->first();

            return view('register.complete.vet', compact('countries', 'provinces', 'user', 'specialties', 'languages', 'species', 'clinicServices', 'specialtyGroupsView', 'vet', 'schedule'));
        }

        if ($user->rol_id == 8) {
            $countries   = Countries::select('id', 'title', 'phonecode', 'default')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
            $provinces   = Province::select('id', 'title')->where('enabled', '=', 1)->orderBy('id', 'ASC')->get();
            $animalTypes = AnimalTypes::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->get();
            $pets = Pet::where('id_user', '=', $user->id)->with(['getType', 'getBreed'])->get();

            return view('register.complete.owner', compact('countries', 'provinces', 'user', 'animalTypes', 'pets'));
        }

        if (in_array($user->rol_id, [4,5,6,7])) {
            $countries   = Countries::select('id', 'title', 'phonecode', 'default')->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
            $provinces   = Province::select('id', 'title')->where('enabled', '=', 1)->orderBy('id', 'ASC')->get();

            $cantons   = [];
            $districts = [];
            if(($user->country == 53) && ($user->province != '') && ($user->canton != '')) {
                $cantons   = Canton::select('id', 'title')->where('id_province', '=', $user->province)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
                $districts = District::select('id', 'title')->where('id_canton', '=', $user->canton)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
            }
            
            return view('register.complete.user', compact('countries', 'provinces', 'cantons', 'districts', 'user'));
        }

        return redirect()->route('home.index');;
    }

    public function completeProfileSave(Request $request) {
        $user = Auth::guard('web')->user();
        $isDraft = $request->boolean('draft');

        if ($user->rol_id == 3) {
            $vet = $this->getOrCreateVetForUser($user);
            $vet->type_dni     = $request->idtypevet;
            $vet->dni          = $request->idnumbervet;
            $vet->country      = $request->country;
            $vet->code         = $request->vcode;
            $vet->social_name  = $request->socialName;
            $vet->company      = $request->clinicname;
            $vet->address      = $request->vetaddress;
            $vet->province     = ($request->country == 53) ? $request->province : $request->province_alternate;
            $vet->canton       = ($request->country == 53) ? $request->canton : $request->canton_alternate;
            $vet->district     = ($request->country == 53) ? $request->district : $request->district_alternate;
            $vet->phone        = $request->phone;
            $vet->specialities = json_encode($request->specialty);
            $vet->species      = json_encode($request->species);
            $vet->languages    = json_encode($request->language);
            $vet->services     = json_encode($request->services);
            $vet->email        = $request->email_clinic;
            $vet->website      = $request->website_clinic;
            $vet->schedule     = nl2br($request->schedule_clinic);
            $vet->resume       = nl2br($request->resume_clinic);
            if (!$isDraft || ($request->lat !== null && $request->lat !== '' && $request->lng !== null && $request->lng !== '')) {
                $vet->lat      = $request->lat;
                $vet->lng      = $request->lng;
            }
            $this->handleClinicLogo($vet, $request);
            $vet->save();

            $userrow = User::select('id', 'id_vet', 'type_dni', 'dni', 'code', 'complete')->where('id', '=', $user->id)->first();
            $userrow->id_vet   = $vet->id;
            if(!$isDraft) {
                $userrow->complete = 1;
            }
            $userrow->type_dni = $request->idtype;
            $userrow->dni      = $request->idnumber;
            $userrow->country  = $request->country;
            $userrow->province = ($request->country == 53) ? $request->province : $request->province_alternate;
            $userrow->canton   = ($request->country == 53) ? $request->canton : $request->canton_alternate;
            $userrow->district = ($request->country == 53) ? $request->district : $request->district_alternate;
            $userrow->phone    = $request->phone;
            if($request->mycode == 1) {
                $userrow->code = $request->vcode;
            }
            $this->handleProfilePhoto($userrow, $request);
            $userrow->update();

            if ($request->boolean('schedule_enabled')) {
                $this->syncSchedule($user, $request->input('schedule', []));
            }

            if($isDraft) {
                return response()->json(['type' => 'success']);
            }
            return redirect()->route('dash');
        }

        if ($user->rol_id == 8) {
            $userrow = User::select('id', 'type_dni', 'dni', 'country', 'province', 'canton', 'district', 'phone', 'complete', 'photo')->where('id', '=', $user->id)->first();
            if(!$isDraft) {
                $userrow->complete = 1;
            }
            $userrow->type_dni = $request->idtype;
            $userrow->dni      = $request->idnumber;
            $userrow->country  = $request->country;
            $userrow->province = ($request->country == 53) ? $request->province : $request->province_alternate;
            $userrow->canton   = ($request->country == 53) ? $request->canton : $request->canton_alternate;
            $userrow->district = ($request->country == 53) ? $request->district : $request->district_alternate;
            $userrow->phone    = $request->phone;
            $this->handleProfilePhoto($userrow, $request);
            $userrow->update();

            if(!$isDraft && isset($_POST['petname'])){
                for($i = 0;$i < count($_POST['petname']);$i++){
                    if($_POST['petname'][$i] != ""){
                        $pet = new Pet();
                        $pet->id_user = $user->id;
                        $pet->name    = $_POST['petname'][$i];
                        $pet->type    = ($_POST['animaltype'][$i] != "") ? $_POST['animaltype'][$i] : 0;
                        $pet->breed   = ($_POST['breed'][$i] != "") ? $_POST['breed'][$i] : 0;
                        $pet->save();
                    }
                }
            }

            if($isDraft) {
                return response()->json(['type' => 'success']);
            }
            return redirect()->route('dash');
        }

        if (in_array($user->rol_id, [4,5,6,7])) {
            $userrow = User::select('id', 'type_dni', 'dni', 'country', 'province', 'canton', 'district', 'phone', 'complete', 'photo')->where('id', '=', $user->id)->first();
            if(!$isDraft) {
                $userrow->complete = 1;
            }
            $userrow->code     = (isset($request->vcode)) ? $request->vcode : '';
            $userrow->name     = $request->name;
            $userrow->type_dni = $request->idtype;
            $userrow->dni      = $request->idnumber;
            $userrow->country  = $request->country;
            $userrow->province = ($request->country == 53) ? $request->province : $request->province_alternate;
            $userrow->canton   = ($request->country == 53) ? $request->canton : $request->canton_alternate;
            $userrow->district = ($request->country == 53) ? $request->district : $request->district_alternate;
            $userrow->phone    = $request->phone;
            $this->handleProfilePhoto($userrow, $request);
            $userrow->update();

            if($isDraft) {
                return response()->json(['type' => 'success']);
            }
            return redirect()->route('dash');
        }
    }

    public function saveSetupIdentity(IdentityRequest $request) {
        $user = Auth::guard('web')->user();
        if ($user->rol_id != 3) {
            return response()->json(['type' => 'error'], 403);
        }

        $vet = $this->getOrCreateVetForUser($user);
        $vet->code = $request->vcode;
        $vet->save();

        $userrow = User::select('id', 'id_vet', 'type_dni', 'dni', 'code', 'photo')->where('id', '=', $user->id)->first();
        $userrow->id_vet = $vet->id;
        $userrow->type_dni = $request->idtype;
        $userrow->dni = $request->idnumber;
        if($request->mycode == 1) {
            $userrow->code = $request->vcode;
        }
        $this->handleProfilePhoto($userrow, $request);
        $userrow->update();

        return response()->json(['type' => 'success']);
    }

    public function saveSetupClinic(ClinicRequest $request) {
        $user = Auth::guard('web')->user();
        if ($user->rol_id != 3) {
            return response()->json(['type' => 'error'], 403);
        }

        $vet = $this->getOrCreateVetForUser($user);
        $vet->type_dni     = $request->idtypevet;
        $vet->dni          = $request->idnumbervet;
        $vet->social_name  = $request->socialName;
        $vet->company      = $request->clinicname;
        $vet->phone        = $request->phone;
        $vet->languages    = json_encode($request->language);
        $vet->email        = $request->email_clinic;
        $vet->website      = $request->website_clinic;
        $this->handleClinicLogo($vet, $request);
        $vet->save();

        $userrow = User::select('id', 'id_vet', 'phone')->where('id', '=', $user->id)->first();
        $userrow->id_vet = $vet->id;
        $userrow->phone = $request->phone;
        $userrow->update();

        return response()->json(['type' => 'success']);
    }

    public function saveSetupSpecialties(SpecialtiesRequest $request) {
        $user = Auth::guard('web')->user();
        if ($user->rol_id != 3) {
            return response()->json(['type' => 'error'], 403);
        }

        $vet = $this->getOrCreateVetForUser($user);
        $vet->specialities = json_encode($request->specialty);
        $vet->species      = json_encode($request->species);
        $vet->services     = json_encode($request->services);
        $vet->save();

        $userrow = User::select('id', 'id_vet')->where('id', '=', $user->id)->first();
        $userrow->id_vet = $vet->id;
        $userrow->update();

        return response()->json(['type' => 'success']);
    }

    public function saveSetupLocation(LocationRequest $request) {
        $user = Auth::guard('web')->user();
        if ($user->rol_id != 3) {
            return response()->json(['type' => 'error'], 403);
        }

        $vet = $this->getOrCreateVetForUser($user);
        $vet->country  = $request->country;
        $vet->address  = $request->vetaddress;
        $vet->province = ($request->country == 53) ? $request->province : $request->province_alternate;
        $vet->canton   = ($request->country == 53) ? $request->canton : $request->canton_alternate;
        $vet->district = ($request->country == 53) ? $request->district : $request->district_alternate;
        if ($request->lat !== null && $request->lat !== '' && $request->lng !== null && $request->lng !== '') {
            $vet->lat = $request->lat;
            $vet->lng = $request->lng;
        }
        $vet->save();

        $userrow = User::select('id', 'id_vet', 'country', 'province', 'canton', 'district')->where('id', '=', $user->id)->first();
        $userrow->id_vet = $vet->id;
        $userrow->country  = $request->country;
        $userrow->province = ($request->country == 53) ? $request->province : $request->province_alternate;
        $userrow->canton   = ($request->country == 53) ? $request->canton : $request->canton_alternate;
        $userrow->district = ($request->country == 53) ? $request->district : $request->district_alternate;
        $userrow->update();

        return response()->json(['type' => 'success']);
    }

    public function saveSetupSchedule(ScheduleRequest $request) {
        $user = Auth::guard('web')->user();
        if ($user->rol_id != 3) {
            return response()->json(['type' => 'error'], 403);
        }

        if ($request->boolean('schedule_enabled')) {
            $this->syncSchedule($user, $request->input('schedule', []));
        }

        return response()->json(['type' => 'success']);
    }

    private function getOrCreateVetForUser(User $user) {
        $vet = Vets::where('id', '=', $user->id_vet)->first();
        if(!isset($vet->id)) {
            $vet = new Vets();
        }
        return $vet;
    }

    private function handleProfilePhoto(User $userrow, Request $request) {
        if($request->hasfile('profilePhoto')) {
            $file = $request->file('profilePhoto');
            $imageName = uniqid().time().'.'.$file->extension();

            if(!File::isDirectory(public_path('files/user/image'))) {
                File::makeDirectory(public_path('files/user/image'), 0777, true, true);
                chmod(public_path('files/user/image'), 0777);
            }

            if(isset($userrow->photo) && $userrow->photo != '' && File::exists(public_path($userrow->photo))) {
                File::delete(public_path($userrow->photo));
            }

            if($file->move(public_path('files/user/image'), $imageName)) {
                $userrow->photo = 'files/user/image/' . $imageName;
            }
        }
        if($request->removeProfilePhoto == 1) {
            if(isset($userrow->photo) && $userrow->photo != '' && File::exists(public_path($userrow->photo))) {
                File::delete(public_path($userrow->photo));
            }
            $userrow->photo = null;
        }
    }

    private function handleClinicLogo(Vets $vet, Request $request) {
        if($request->hasfile('clinicLogo')) {
            $file = $request->file('clinicLogo');
            $imageName = uniqid().time().'.'.$file->extension();

            if(!File::isDirectory(public_path('files/vet/logo'))) {
                File::makeDirectory(public_path('files/vet/logo'), 0777, true, true);
                chmod(public_path('files/vet/logo'), 0777);
            }

            if(isset($vet->logo) && $vet->logo != '' && File::exists(public_path($vet->logo))) {
                File::delete(public_path($vet->logo));
            }

            if($file->move(public_path('files/vet/logo'), $imageName)) {
                $vet->logo = 'files/vet/logo/' . $imageName;
            }
        }
        if($request->removeClinicLogo == 1) {
            if(isset($vet->logo) && $vet->logo != '' && File::exists(public_path($vet->logo))) {
                File::delete(public_path($vet->logo));
            }
            $vet->logo = null;
        }
    }

    private function syncSchedule(User $user, array $scheduleInput) {
        $schedule = Schedule::firstOrCreate(
            ['id_user' => $user->id],
            ['description' => 'Horario de ' . ($user->name ?? 'usuario'), 'status' => '1']
        );
        $schedule->scheduleDetails()->delete();
        foreach ($scheduleInput as $day => $times) {
            foreach ($times as $time) {
                if (empty($time['from']) || empty($time['to'])) {
                    continue;
                }
                $schedule->scheduleDetails()->create([
                    'day_of_week' => $day,
                    'start_time'  => $time['from'],
                    'end_time'    => $time['to'],
                    'status'      => '1',
                ]);
            }
        }
    }

    public function createPet(Request $request) {
        $user = User::select('id')->where('id', '=', $request->useridCreatePetModal)->first();
            
        if(isset($user->id)) {
            $pet = new Pet();
            $pet->id_user = $user->id;
            $pet->name    = $request->nameModalCreatePet;
            $pet->type    = $request->typeCreatePet;
            $pet->breed   = $request->breedCreatePet;
            $pet->save();
            
            return response()->json(array('type' => '200', 'result' => 'create', 'data' => $pet->id . ':' . $user->id));
        }

        return response()->json(array('type' => '200', 'result' => 'error'));
    }

    public function getLocation(Request $request) {
        $type = $request->type;
        $value = $request->value;

        $rows = [];
        switch ($type) {
            case '1':
                $rows = Canton::select('id', 'title')->where('id_province', '=', $value)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
                break;
            case '2':
                $rows = District::select('id', 'title')->where('id_canton', '=', $value)->where('enabled', '=', 1)->orderBy('title', 'ASC')->get();
                break;
            default:
                break;
        }

        return response()->json(array('type' => '200', 'rows' => $rows));
    }

    public function getBreed(Request $request) {
        $type = $request->type;

        $lang = Config::get('app.locale');
        if($lang == "") {
            $lang = "es";
        }

        $rows = AnimalBreed::select('id', 'title_' . $lang . ' as title')->where('type', '=', $type)->where('enabled', '=', 1)->orderBy('title_' . $lang, 'ASC')->get();

        return response()->json(array('type' => '200', 'rows' => $rows));
    }

    public function checkVetCode(Request $request) {
        $row = MedicalCollege::select('id', 'code')->where('code', '=', $request->code)->where('enabled', '=', 1)->first();
        
        $id   = (isset($row->id)) ? $row->id : 0;
        $code = (isset($row->code)) ? $row->code : 0;

        return response()->json(array('type' => '200', 'id' => $id, 'code' => $code));
    }

    public function registerFacebook (Request $request) {
        $rol = $request->rol;

        $setting = Setting::getSocialSetting();
        $socialConfig = [
            'client_id' => $setting->facebook_id,
            'client_secret' => $setting->facebook_secret,
            'redirect' => route('callback.social.register', ['network' => 'facebook', 'rol' => $rol])
        ];
        config(['services.facebook' => $socialConfig]);

        return Socialite::driver('facebook')->redirect();
    }

    public function registerGoogle (Request $request) {
        $rol = $request->rol;

        $setting = Setting::getSocialSetting();
        $socialConfig = [
            'client_id' => $setting->google_id,
            'client_secret' => $setting->google_secret,
            'redirect' => route('callback.social.register', ['network' => 'google', 'rol' => $rol])
        ];
        config(['services.google' => $socialConfig]);

        return Socialite::driver('google')->redirect();
    }

    public function registerSocialNetwork(Request $request) {

        $social = $request->network;
        $rol = $request->rol; //owner or vet
        
        $socialName = '';
        $socialEmail = '';
        $image = '';
        
        if($social == 'google') {
            $setting = Setting::getSocialSetting();
            $socialConfig = [
                'client_id' => $setting->google_id,
                'client_secret' => $setting->google_secret,
                'redirect' => route('callback.social.register', ['network' => 'google', 'rol' => $rol])
            ];
            config(['services.google' => $socialConfig]);

            $user = Socialite::driver('google')->user();

            if((isset($user->id)) && (isset($user->email)) && ($user->email != '')) {
                $socialName = $user->name;
                $socialEmail = $user->email;
                $image = $user->avatar;
            }
        }
        if($social == 'facebook') {
            $setting = Setting::getSocialSetting();
            $socialConfig = [
                'client_id' => $setting->facebook_id,
                'client_secret' => $setting->facebook_secret,
                'redirect' => route('callback.social.register', ['network' => 'facebook', 'rol' => $rol])
            ];
            config(['services.facebook' => $socialConfig]);

            $user = Socialite::driver('facebook')->user();

            if((isset($user->id)) && (isset($user->email)) && ($user->email != '')) {
                $socialName = $user->name;
                $socialEmail = $user->email;
                $image = $user->avatar;
            }
        }

        if($socialEmail != '') {

            $user = User::select('id', 'email', 'facebook', 'google', 'enabled', 'email_verified_at', 'photo', 'rol_id', 'complete')->where('email', '=', $socialEmail)->first();
            if(isset($user->id)) {
                if($social == 'facebook') {
                    $user->facebook = 1;
                }
                if($social == 'google') {
                    $user->google = 1;
                }
                $user->enabled = 1;
                $user->email_verified_at = date('Y-m-d H:i:s');
                if($user->photo == '') {
                    $user->photo = $image;
                }
                $user->update();

                $url = $this->loginStart($user);
                return redirect()->route($url);
            }

            DB::beginTransaction();
            try {
                $rolid = 8;
                switch ($rol) {
                    case 'vet':$rolid = 3;
                        break;
                    case 'owner':$rolid = 8;
                        break;
                    default:$rolid = 8;
                        break;
                }

                $possible = '123456789abcdfghjkmnpqrstvwxyzABCDEFHKMNPQRTVWXYZ';
                $newPass = '';
                $i = 0;
                while ($i < 12) {
                    $newPass .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
                    $i++;
                }

                $names = explode(" ", $socialName);
                $name = (isset($names[0])) ? $names[0] : '';
                array_shift($names);
                $lastname = implode(" ", $names);

                $user = new User();
                $user->id_vet            = null;
                $user->type_dni          = null;
                $user->dni               = null;
                $user->name              = $name;
                $user->lastname          = $lastname;
                $user->email             = $socialEmail;
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->password          = Hash::make($newPass);
                $user->rol_id            = $rolid;
                $user->facebook          = ($social == 'facebook') ? 1 : 0;
                $user->google            = ($social == 'google') ? 1 : 0;
                $user->enabled           = 1;
                $user->complete          = 0;
                $user->lock              = 0;
                $user->photo             = $image;
                $user->save();

                if(isset($user->id)) {
                    DB::commit();

                    $url = $this->loginStart($user);
                    return redirect()->route($url);
                }else{
                    DB::rollback();

                    return redirect()->route('home.index');
                }

            } catch (\Throwable $th) {
                DB::rollback();
                
                return redirect()->route('home.index');
            }

            return redirect()->route('home.index');
        }
    }

    public function loginStart($user) {
        if (isset($user->id)) {
            Auth::guard('web')->loginUsingId($user->id);

            if(in_array($user->rol_id, [3,4,5,6,7,8])) {
                switch ($user->rol_id) {
                    case '3'://Veterinary administrator
                        if($user->complete == 0) {
                            return 'register.complete-profile';
                        }
                        return 'dash';
                        break;
                    case '4'://Veterinary 
                        return 'dash';
                        break;
                    case '5'://Cashier
                        return 'dash';
                        break;
                    case '6'://Groomer
                        return 'dash';
                        break;
                    case '7'://Accountant
                        return 'dash';
                        break;
                    case '8'://Customer
                        if($user->complete == 0) {
                            return 'register.complete-profile';
                        }
                        return 'dash';
                        break;
                    default:
                        break;
                }
            }
        }

        return 'home.index';
    }

}

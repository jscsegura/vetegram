<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\AboutMain;
use App\Models\AnimalBreed;
use App\Models\AnimalBreedImage;
use App\Models\AnimalBreedVets;
use App\Models\AppointmentAttachment;
use App\Models\AppointmentClient;
use App\Models\AppointmentHour;
use App\Models\Canton;
use App\Models\Contact;
use App\Models\Countries;
use App\Models\District;
use App\Models\Language;
use App\Models\Notifications;
use App\Models\Payment;
use App\Models\Pet;
use App\Models\Province;
use App\Models\Reminder;
use App\Models\Service;
use App\Models\Setting;
use App\Models\SettingPro;
use App\Models\Slider;
use App\Models\Specialties;
use App\Models\SuscriptionCancel;
use App\Models\User;
use App\Models\UserVetDoctor;
use App\Models\Vets;
use App\Models\ViewVetSearch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Image;
use Jenssegers\Agent\Agent;

class HomeController extends Controller {
    
    public function __construct() {}
    
    public function landing() {
        $sliders = Slider::where('enabled', '=', 1)->orderBy('id', 'asc')->get();
        $services = Service::where('enabled', '=', 1)->orderBy('id', 'asc')->get();
        $about = AboutMain::where('id', '=', 1)->first();
        $abouts = About::where('enabled', '=', 1)->orderBy('id', 'asc')->get();

        /*** Start search querys ***/
        $lang = Config::get('app.locale');

        /*** Start search querys ***/
        $querys = ViewVetSearch::getTagsSearch($lang);
        /*** End search querys ***/
        
        return view('home.landing', compact('sliders', 'services', 'about', 'abouts', 'querys'));
    }

    public function sendcontact(Request $request) {
        $fname = $request->fname;
        $email = $request->email;
        $message = $request->message;

        $ip = $request->ip();

        $agent = new Agent();
        $userAgent = $request->header('User-Agent');
        $agent->setUserAgent($userAgent);
        $browser = $agent->browser();

        $contact = Contact::create([
            'name' => $fname,
            'email' => $email,
            'message' => $message,
            'ip' => $ip,
            'browser' => $browser
        ]);

        $params = [
            'contact' => $contact
        ];

        $template = view('emails.general.landing-contact', $params)->render();

        $setting = Setting::getEmailSetting();

        Notifications::create([
            'id_user' => 0,
            'to' => (isset($setting->email_to)) ? $setting->email_to : '',
            'subject' => 'Formulario de contacto',
            'description' => $template,
            'attach' => '',
            'email' => 1,
            'sms' => 0,
            'whatsapp' => 0,
            'status' => 0,
            'attemps' => 0
        ]);

        return response()->json(array('type' => '200'));
    }

    public function index() {
        return view('home.index');
    }
    
    public function language(Request $request) {
        $lang = $request->lang;

        if(in_array($lang, ['es','en'])) {
            $cookie = cookie('langvtgm', $lang, 60 * 2160);
            App::setLocale($lang);

            return redirect()->back()->withCookie($cookie);
        }

        return redirect()->back();
    }
    
    public function dash(Request $request) {
        $user = Auth::guard('web')->user();
        
        if($user->rol_id == 8) {
            $name = $user->name;

            $appointments = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
                ->where('id_owner', '=', $user->id)
                ->where('date', '>=', date('Y-m-d'))
                ->whereIn('status', [0,1])
                ->with('getPet')
                ->with('getDoctor')
                ->orderBy('date', 'ASC')
                ->orderBy('hour', 'ASC')
                ->get();

            $previous = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
                ->where('id_owner', '=', $user->id)
                ->where(function ($query) {
                    $query->where('date', '<', date('Y-m-d'))->orWhere('status', '=', 2);
                })
                ->where('status', '=', 2)
                ->with('getPet')
                ->with('getDoctor')
                ->orderBy('date', 'DESC')
                ->orderBy('hour', 'DESC')
                ->limit(10)
                ->get();

            $remaining = AppointmentClient::where('id_owner', '=', $user->id)->where('date', '=', date('Y-m-d'))->where('status', '=', 0)->count();

            $now = date('Y-m-d H:i:s');
            $date = date('Y-m-d');
            $last = $date . ' 23:59:59';
            $reminders = Reminder::select('id', 'description', 'date', 'id_appointment', 'id_pet')->where('id_user', '=', $user->id)->whereBetween('date', [$now, $last])->with('pet')->get();

            $pets = Pet::select('id', 'name', 'photo')->where('id_user', '=', $user->id)->orderBy('name', 'asc')->get();

            if(isset($request->api)) {
                return ['user' => $user, 'name' => $name, 'appointments' => $appointments, 'remaining' => $remaining, 'pets' => $pets, 'previous' => $previous, 'reminders' => $reminders];
            }else{
                $thismenu = 'dashowner';
                return view('home.dashowner', compact('thismenu', 'user', 'name', 'appointments', 'remaining', 'pets', 'previous', 'reminders'));
            }
        }else{ 
            $name = explode(" ", $user->name);
            $name = (isset($name[0])) ? $name[0] : '';

            $appointments = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
                ->where('id_user', '=', $user->id)
                ->where('date', '=', date('Y-m-d'))
                ->with('getPet')
                ->with('getClient')
                ->orderBy('hour', 'ASC')
                ->get();

            $remaining = AppointmentClient::where('id_user', '=', $user->id)->where('date', '=', date('Y-m-d'))->where('status', '=', 0)->count();

            $patients = UserVetDoctor::where('id_doctor', '=', $user->id)->distinct('id_client')->count();

            $now = date('Y-m-d H:i:s');
            $date = date('Y-m-d');
            $last = $date . ' 23:59:59';
            $reminders = Reminder::select('id', 'description', 'date', 'id_appointment', 'id_pet')->where('id_user', '=', $user->id)->whereBetween('date', [$now, $last])->with('pet')->get();

            $vet = Vets::select('id', 'pro')->where('id', '=', $user->id_vet)->first();

            $pros = [];
            if($vet->pro == 1) {
                $pros = SettingPro::where('pro', '=', 1)->where('enabled', '=', 1)->orderBy('pro', 'desc')->get();
            }

            $thismenu = 'dash';
            return view('home.dash', compact('thismenu', 'user', 'name', 'appointments', 'remaining', 'patients', 'reminders', 'vet', 'pros'));
        }
    }

    public function notifications() {
        $user = Auth::guard('web')->user();

        $reminders = Reminder::select('id', 'to', 'description', 'date', 'id_appointment', 'id_pet', 'read', 'repeat', 'period', 'quantity')->where('created_by', '=', $user->id)->where('status', '=', 0)->orderBy('date', 'DESC')->get();

        Reminder::where('created_by', '=', $user->id)->where('status', '=', 0)->where('read', '=', 0)->update(['read' => 1]);
        session(['notifieds' => 0]);

        return view('home.notifications', compact('reminders'));
    }

    public function removeNotification(Request $request) {
        $user = Auth::guard('web')->user();

        Reminder::where('id', '=', $request->id)->where('id_user', '=', $user->id)->delete();

        return response()->json(array('type' => '200', 'process' => '1'));
    }

    public function profile(Request $request) {
        $user = Auth::guard('web')->user();

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

        if(isset($request->api)) {
            return ['user' => $user, 'vet' => $vet, 'patients' => $patients, 'specialties' => $specialties, 'languages' => $languages, 'countries' => $countries, 'provinces' => $provinces, 'cantons1' => $cantons1, 'districts1' => $districts1, 'cantons2' => $cantons2, 'districts2' => $districts2];
        }else{
            return view('home.profile', compact('user', 'vet', 'patients', 'specialties', 'languages', 'countries', 'provinces', 'cantons1', 'districts1', 'cantons2', 'districts2'));
        }
    }

    public function setSignature(Request $request) {
        $user = Auth::guard('web')->user();

        $userrow = User::where('id', '=', $user->id)->first();
        $userrow->signature = $request->signature;
        $userrow->update();

        return response()->json(array('type' => '200'));
    }

    public function setNotifications(Request $request) {
        $user = Auth::guard('web')->user();

        $userrow = User::where('id', '=', $user->id)->first();

        $userrow->mailer   = $request->mailer;
        $userrow->sms      = $request->sms;
        $userrow->whatsapp = $request->whatsapp;
        $userrow->update();

        return response()->json(array('type' => '200'));
    }

    public function updateProfile(Request $request) {
        if((isset($request->edituser)) && ($request->edituser == '1')) {
            $id = User::encryptor('decrypt', $request->hideId);

            $user = User::select('*')
                ->where('id', '=', $id)
                ->first();
        }else{
            $user = Auth::guard('web')->user();
        }

        if ($user->rol_id == 3) {
            $vet = Vets::where('id', '=', $user->id_vet)->first();
            $vet->type_dni     = $request->idtypevet;
            $vet->dni          = $request->idnumbervet;
            $vet->country      = $request->country2;
            $vet->code         = $request->vcode;
            $vet->social_name  = $request->socialName;
            $vet->company      = $request->clinicname;
            $vet->address      = $request->vetaddress;
            $vet->province     = ($request->country2 == 53) ? $request->province2 : $request->province_alternate2;
            $vet->canton       = ($request->country2 == 53) ? $request->canton2 : $request->canton_alternate2;
            $vet->district     = ($request->country2 == 53) ? $request->district2 : $request->district_alternate2;
            $vet->phone        = $request->phonevet;
            $vet->specialities = json_encode($request->specialty);
            $vet->languages    = json_encode($request->language);
            $vet->email        = $request->email_clinic;
            $vet->website      = $request->website_clinic;
            $vet->schedule     = nl2br($request->schedule_clinic);
            $vet->resume       = nl2br($request->resume_clinic);
            $vet->update();
        }

        $userrow = User::where('id', '=', $user->id)->first();
        $userrow->name     = $request->dname;
        $userrow->type_dni = $request->idtype;
        $userrow->dni      = $request->idnumber;
        $userrow->country  = $request->country;
        $userrow->province = ($request->country == 53) ? $request->province : $request->province_alternate;
        $userrow->canton   = ($request->country == 53) ? $request->canton : $request->canton_alternate;
        $userrow->district = ($request->country == 53) ? $request->district : $request->district_alternate;
        $userrow->phone    = $request->phone;
        $userrow->code     = $request->vcode;
        if(isset($request->changePass)) {
            $userrow->password = Hash::make($request->actualpass);
        }
        $userrow->update();

        if(isset($request->api)) {
            return ['type' => 'success', 'message' => trans('auth.success.update.profile')];
        }else{
            session()->flash('success', trans('auth.success.update.profile'));
            return redirect()->back();
        }
    }

    public function updatePhoto(Request $request) {
        $user = Auth::guard('web')->user();

        $userRow = User::where('id', '=', $user->id)->first();

        if($request->hasfile('profilePhoto')) {
            $file = $request->file('profilePhoto');
            $imageName = uniqid().time().'profile_user.'.$file->extension();

            if(!File::isDirectory(public_path('files/user/image'))) {
                File::makeDirectory(public_path('files/user/image'), '0777', true, true);
                chmod(public_path('files/user/image'), 0777);
            }

            if(File::exists(public_path($userRow->photo))) {
                File::delete(public_path($userRow->photo));
            }

            $newImage = Image::make($file->getRealPath());
            if($newImage != null){
                $new_width  = 500;
                $new_height = 500;
            
                $newImage->resize($new_width, $new_height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            
                $newImage->save(public_path('files/user/image/' . $imageName));

                $userRow->photo = 'files/user/image/' . $imageName;
                $userRow->update();
            }
        }

        if(isset($request->api)) {
            return ['type' => 'success', 'message' => trans('auth.success.update.profile')];
        }else{
            session()->flash('success', trans('auth.success.update.profile'));
            return redirect()->back();
        }
    }

    public function admin() {
        return view('home.admin');
    }

    public function search(Request $request) {
        $user = Auth::guard('web')->user();

        $lang = Config::get('app.locale');

        $resultIs = 'vets';

        /*** Start search querys ***/
        $querys = ViewVetSearch::getTagsSearch($lang);
        /*** End search querys ***/
        
        $criterio  = '';

        $doctors = [];
        $vets = [];
        $vet = [];

        $vetId = 0;
        if((isset($request->vet_id))&&($request->vet_id != '')) {
            $vetId = User::encryptor('decrypt', $request->vet_id);
            
            $vet = Vets::where('id', '=', $vetId)->first();

            $resultIs = 'doctor';

            $doctors = User::select('id', 'id_vet', 'name', 'photo', 'online_booking')
                ->where('id_vet', '=', $vetId)
                ->whereIn('rol_id', [3,4,5,6])
                ->where('code', '!=', '')
                ->where('enabled', '=', 1)
                ->where('lock', '=', 0)
                ->where('complete', '=', 1)
                ->with('getVet')
                ->get();
        }else{
            if(isset($_GET['search'])) {
                $criterio = base64_decode($_GET['search']);
                $criterioExplode = explode(',', $criterio);
            }

            if((isset($criterioExplode))&&(count($criterioExplode) > 0)) {
                $specialty = [];
                $countries = [];
                $provinces = [];
                $cantons = [];
                $districts = [];
                $ids = [];
                foreach($criterioExplode as $key) {
                    $aux = explode('-', $key);
                    if($aux[0] == 'spec') {
                        array_push($specialty, $aux[1]);
                    }
                    if($aux[0] == 'country') {
                        array_push($countries, $aux[1]);
                    }
                    if($aux[0] == 'province') {
                        array_push($provinces, $aux[1]);
                    }
                    if($aux[0] == 'canton') {
                        array_push($cantons, $aux[1]);
                    }
                    if($aux[0] == 'district') {
                        array_push($districts, $aux[1]);
                    }
                    if($aux[0] == 'vet') {
                        array_push($ids, $aux[1]);
                    }
                }

                $vets = ViewVetSearch::where(function($query) use ($specialty, $countries, $provinces, $cantons, $districts, $ids) {
                    if(count($specialty) > 0) {
                        foreach ($specialty as $spec) {
                            $query->orWhere('specialities', 'LIKE', '%"' . $spec . '"%');
                        }
                    }
                    if(count($countries) > 0) {
                        foreach ($countries as $country) {
                            $query->orWhere('country', '=', $country);
                        }
                    }
                    if(count($provinces) > 0) {
                        foreach ($provinces as $province) {
                            $query->orWhere('province', '=', $province);
                        }
                    }
                    if(count($cantons) > 0) {
                        foreach ($cantons as $canton) {
                            $query->orWhere('canton', '=', $canton);
                        }
                    }
                    if(count($districts) > 0) {
                        foreach ($districts as $district) {
                            $query->orWhere('district', '=', $district);
                        }
                    }
                    if(count($ids) > 0) {
                        $query->orWhereIn('id', $ids);
                    }
                })
                ->paginate(18);
            }else{
                if(isset($user->country)) {
                    $vets = ViewVetSearch::where('country', '=', $user->country)->paginate(18);
                } else {
                    $vets = ViewVetSearch::paginate(18);
                }
            }
        }

        $thismenu = 'search';
        return view('home.search', compact('thismenu', 'querys', 'criterio', 'doctors', 'vets', 'vet', 'resultIs', 'user'));
        
    }

    public function book(Request $request) {
        $user = Auth::guard('web')->user();

        $vet_id = $request->vet_id;
        $id = User::encryptor('decrypt', $request->vet_id);

        $doctor = User::select('id', 'id_vet', 'name', 'photo', 'code', 'rol_id')
                ->where('id', '=', $id)     
                ->where('enabled', '=', 1)
                ->where('lock', '=', 0)
                ->where('complete', '=', 1)
                ->with('getVet')
                ->first();

        if(!isset($doctor->id)) {
            return redirect()->route('search.index');
        }

        /*** Verifica si puede crear citas en plan free ***/
        $datesEmpty = false;
        $vet = Vets::where('id', '=', $doctor->id_vet)->first();

        $setting = Setting::getLimitsSetting();
        
        $maxAppoint = 0;
        if($vet->pro == 1) {
            $maxAppoint = $setting->max_appointment_pro;
        }else{
            $maxAppoint = $setting->max_appointment_free;
        }

        $vetUsers = Vets::getUserMyVet($doctor->id_vet);
        $ids = [];
        foreach ($vetUsers as $value) {
            array_push($ids, $value->id);
        }

        $start = Carbon::now()->startOfMonth()->format('Y-m-d') . ' 00:00:00';
        $end = Carbon::now()->endOfMonth()->format('Y-m-d') . ' 23:59:59';
        $appointmentCounter = AppointmentClient::whereIn('id_user', $ids)->whereBetween('created_at', [$start, $end])->count();

        if(($maxAppoint > 0) && ($appointmentCounter >= $maxAppoint)) {
            $datesEmpty = true;
        }
        /**********/

        $now = Carbon::now()->format('Y-m-d H:i:s');
        $date = (isset($request->date)) ? base64_decode($request->date) : date('Y-m-d');

        if($datesEmpty == true) {
            $hours = [];
        }else{
            $hours = AppointmentHour::select('id', 'date', 'hour')
                ->where('status', '=', 0)
                ->where('id_user', '=', $id)
                ->where('date', '>=', date('Y-m-d'))
                ->where('date', '=', $date)
                ->where(function ($query) use ($now, $user) {
                    $query->whereIn('user_reserve', [0, $user->id])
                        ->orWhere('expire', '<', $now)
                        ->orWhereNull('expire');
                })
                ->orderBy('hour', 'asc');

            if(date('Y-m-d') == $date) {
                $hours = $hours->where('hour', '>', date('H:i:s'));            
            }
            $hours = $hours->get();
        }

        $pets = Pet::select('id', 'name', 'photo')->where('id_user', '=', $user->id)->where('dead_flag', '=', 0)->get();

        $countryName = (isset($doctor['getVet']['country'])) ? $doctor['getVet']['country'] : '';
        $provinceName = (isset($doctor['getVet']['province'])) ? $doctor['getVet']['province'] : '';
        $cantonsName  = (isset($doctor['getVet']['canton'])) ? $doctor['getVet']['canton'] : '';
        $districtName = (isset($doctor['getVet']['district'])) ? $doctor['getVet']['district'] : '';

        $ubication = Countries::getResumeLocation($countryName, $provinceName, $cantonsName, $districtName);

        if(isset($request->api)) {
            return ['type' => 'success', 'doctor' => $doctor, 'hours' => $hours, 'date' => $date, 'vet_id' => $vet_id, 'pets' => $pets, 'ubication' => $ubication];
        }else{
            $thismenu = 'book';
            return view('home.book', compact('thismenu', 'doctor', 'hours', 'date', 'vet_id', 'pets', 'ubication'));
        }
    }

    public function getPetData(Request $request) {
        $user = Auth::guard('web')->user();

        $id = $request->id;
        $id_vet = $request->id_vet;

        if(($id != 0)&&($id_vet != 0)){
            if(isset($request->api)) {
                $lang = 'es';
            }else{
                $lang = Config::get('app.locale');
            }

            if($user->rol_id == 8) {
                $pet = Pet::select('id', 'id_user', 'type', 'breed')->where('id', '=', $id)->where('id_user', '=', $user->id)->first();
            }else{
                $pet = Pet::select('id', 'id_user', 'type', 'breed')->where('id', '=', $id)->first();
            }
    
            $breedsAvailable = AnimalBreedVets::where('id_vet', '=', $id_vet)->pluck('id_breed')->toArray();
    
            $breeds = AnimalBreed::select('id', 'title_' . $lang . ' as title')->where('type', '=', $pet->type)->where('enabled', '=', 1)->whereIn('id', $breedsAvailable)->orderBy('title_' . $lang, 'ASC')->get();
    
            $images = AnimalBreedImage::select('id', 'title_' . $lang . ' as title', 'image')->where('id_breed', '=', $pet->breed)->get();
    
            if(isset($request->api)) {
                return ['type' => 'success', 'breeds' => $breeds, 'images' => $images, 'breedSelected' => $pet->breed];
            }else{
                return response()->json(array('breeds' => $breeds, 'images' => $images, 'breedSelected' => $pet->breed));
            }
        }else{
            if(isset($request->api)) {
                return ['type' => 'success', 'breeds' => [], 'images' => [], 'breedSelected' => 0];
            }else{
                return response()->json(array('breeds' => [], 'images' => [], 'breedSelected' => 0));
            }
        }       
    }

    public function getPetDataImages(Request $request) {
        $id = $request->id;

        if(isset($request->api)) {
            $lang = 'es';
        }else{
            $lang = Config::get('app.locale');
        }

        $images = AnimalBreedImage::select('id', 'title_' . $lang . ' as title', 'image')->where('id_breed', '=', $id)->get();

        if(isset($request->api)) {
            return ['type' => 'success', 'images' => $images];
        }else{
            return response()->json(array('images' => $images));
        }
    }

    public function saveBook(Request $request) {
        $user = Auth::guard('web')->user();

        $doctor = User::encryptor('decrypt', $request->doctor);

        $doctorRow = User::select('id', 'id_vet', 'rol_id')->where('id', '=', $doctor)->first();

        $pet = $request->petSelected;

        $hour = AppointmentHour::where('id', '=', $request->hourSelected)->first();
        
        if((isset($hour->id))&&($hour->status == 0)) {

            $appointment = AppointmentClient::create([
                'id_user' => $doctor,
                'id_pet' => $pet,
                'id_owner' => $user->id,
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

            if($doctorRow->rol_id == 6) {
                $appointment->breed_grooming = $request->breed;
                $appointment->image_grooming = $request->imageSelected;
                $appointment->desc_grooming = ($request->imageSelected == 0) ? $request->grooming_personalize : '';
                $appointment->update();
            }

            $hour->status = 1;
            $hour->update();

            if($request->hasfile('bookAttach')) {
                
                foreach($request->file('bookAttach') as $file) {
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

            (new AppointmentController)->notifiedCreateAppointment($appointment->id);
            
            if(isset($request->api)) {
                return ['type' => 'success', 'save' => 1, 'error' => '', 'id' => User::encryptor('encrypt', $appointment->id)];
            }else{
                return response()->json(array('save' => '1', 'error' => '', 'id' => User::encryptor('encrypt', $appointment->id)));
            }
        }else{
            if(isset($request->api)) {
                return ['type' => 'success', 'save' => '0', 'error' => trans('dash.msg.error.hour.not.available', [], 'es'), 'id' => 0];
            }else{
                return response()->json(array('save' => '0', 'error' => trans('dash.msg.error.hour.not.available'), 'id' => 0));
            }
        }
    }

    public function bookmessage(Request $request) {
        $id = User::encryptor('decrypt', $request->id);

        $appointment = AppointmentClient::select('id', 'id_user', 'id_pet', 'id_owner', 'id_hours', 'date', 'hour', 'status')
                ->where('id', '=', $id)
                ->with('getDoctor')
                ->first();

        if(isset($request->api)) {
            return ['type' => 'success', 'appointment' => $appointment];
        }else{
            return view('home.bookmessage', compact('appointment'));
        }
    }  

    public function plan() {
        $user = Auth::guard('web')->user();

        $vet = Vets::where('id', '=', $user->id_vet)->first();

        $pros = SettingPro::where('enabled', '=', 1)->orderBy('pro', 'desc')->get();

        $setting = Setting::select('id', 'price_pro')->where('id', '=', 1)->first();

        $payments = Payment::where('id_vet', '=', $user->id_vet)->where('code', '=', '1')->orderBy('id', 'desc')->limit(20)->get();

        return view('home.plan', compact('vet', 'pros', 'setting', 'payments'));
    }

    public function startPlan() {
        die;
        $user = Auth::guard('web')->user();

        $userAdmin = User::select('id', 'email', 'name')->where('id_vet', '=', $user->id_vet)->where('rol_id', '=', 3)->first();

        $vet = Vets::where('id', '=', $user->id_vet)->first();

        $data = [
            'clinic' => (isset($vet->company)) ? $vet->company : '', 
            'adminid' => $userAdmin->id, 
            'admin' => $userAdmin->name, 
            'email' => $userAdmin->email, 
            'createBy' => $user->name
        ];
        $template = view('emails.general.start-plan', $data)->render();

        $setting = Setting::getEmailSetting();

        $row = Notifications::create([
            'id_user' => 0,
            'to' => (isset($setting->email_to)) ? $setting->email_to : '',
            'subject' => 'Solicitud de adquirir plan PRO',
            'description' => $template,
            'attach' => '',
            'email' => 1,
            'sms' => 0,
            'whatsapp' => 0,
            'status' => 0,
            'attemps' => 0
        ]);

        return response()->json(array('success' => '1'));
    }

    public function cancelPro(Request $request) {
        $reason = $request->reason;

        $user = Auth::guard('web')->user();

        $cancel = SuscriptionCancel::create([
            'id_user' => $user->id,
            'id_vet' => $user->id_vet,
            'reason' => $reason,
            'survey' => ''
        ]);

        $vet = Vets::where('id', '=', $user->id_vet)->first();

        $vet->pro = 0;
        $vet->token = '';
        $vet->email_token = '';
        $vet->expire = null;
        $vet->update();

        $data = [
            'name' => $user->name,
            'code' => User::encryptor('encrypt',$cancel->id)
        ];
        $template = view('emails.general.cancel-plan-pro', $data)->render();

        Notifications::create([
            'id_user' => $user->id,
            'to' => $user->email,
            'subject' => trans('dash.label.cancel.pro.title'),
            'description' => $template,
            'attach' => '',
            'email' => 1,
            'sms' => 0,
            'whatsapp' => 0,
            'status' => 0,
            'attemps' => 0
        ]);

        $data = [
            'cancel' => $cancel,
            'vet' => $vet,
            'user' => $user
        ];

        $template = view('emails.general.cancel-plan-pro-admin', $data)->render();

        $setting = Setting::getEmailSetting();

        Notifications::create([
            'id_user' => 0,
            'to' => (isset($setting->email_to)) ? $setting->email_to : '',
            'subject' => 'Suscripción a Vetegram PRO cancelada',
            'description' => $template,
            'attach' => '',
            'email' => 1,
            'sms' => 0,
            'whatsapp' => 0,
            'status' => 0,
            'attemps' => 0
        ]);

        return response()->json(array('success' => '1'));
    }

    public function payment() {
        $user = Auth::guard('web')->user();

        $setting = Setting::select('id', 'price_pro', 'term_es', 'term_en')->where('id', '=', 1)->first();

        $tilopay = Setting::getTilopaySetting();

        $token = '';

        $payload = [
            'apiuser' => $tilopay->tilopay_user,
            'password' => $tilopay->tilopay_pass,
            'key' => $tilopay->tilopay_key
        ];

        $result = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'accept' => 'application/json'
            ])->acceptJson()->post(env('Tilopay') . '/loginSdk', $payload);

        if(isset($result['access_token'])) {
            $token = $result['access_token'];
        }

        $country  = '';
        $province = '';
        $canton   = '';
        $district = '';

        if($user->country == 53) {
            $country = 'Costa Rica';
            $provinceAux = Province::select('id', 'title')->where('id', '=', $user->province)->first();
            $cantonAux = Canton::select('id', 'title')->where('id_province', '=', $user->province)->where('id', '=', $user->canton)->first();
            $districtAux = District::select('id', 'title')->where('id_canton', '=', $user->canton)->where('id', '=', $user->district)->first();

            $province = (isset($provinceAux->title)) ? $provinceAux->title : 'San Jose';
            $canton = (isset($cantonAux->title)) ? $cantonAux->title : 'Escazu';
            $district = (isset($districtAux->title)) ? $districtAux->title : 'Escazu';
        }else{
            $countryAux = Countries::select('id', 'title')->where('id', '=', $user->country)->first();
            $country = (isset($countryAux->title)) ? $countryAux->title : 'Costa Rica';

            $province = ($user->province != '') ? $user->province : 'San Jose';
            $canton = ($user->canton != '') ? $user->canton : 'Escazu';
            $district = ($user->district != '') ? $user->district : 'Escazu';
        }

        $parts = explode(' ', $user->name);
        $firstName = $parts[0];
        $lastName = isset($parts[1]) ? $parts[1] : 'lastname';

        return view('home.payment', compact('setting', 'token', 'user', 'country', 'province', 'canton', 'district', 'firstName', 'lastName'));
    }

    public function responseTilopay(Request $request) {
        
        $code = (isset($request->code)) ? $request->code : 3;
        $description = (isset($request->description)) ? $request->description : 'Rechazado';
        $auth = (isset($request->auth)) ? $request->auth : '';
        $orderNumber = (isset($request->order)) ? $request->order : '';
        $orderid = (isset($request->tpt)) ? $request->tpt : 0;
        $token = (isset($request->crd)) ? $request->crd : '';
        $OrderHash = (isset($request->OrderHash)) ? $request->OrderHash : '';
        $returnData = (isset($request->returnData)) ? $request->returnData : '';

        try {
            $user = Auth::guard('web')->user();

            if((isset($user->id)) && ($returnData != $user->id) && ($returnData != '')) {
                $user = User::select('id', 'email', 'name', 'id_vet')->where('id', '=', $returnData)->first();
            }elseif((!isset($user->id)) && ($returnData != '')){
                $user = User::select('id', 'email', 'name', 'id_vet')->where('id', '=', $returnData)->first();
            }
        } catch (\Throwable $th) {
            $user = User::select('id', 'email', 'name')->where('id', '=', $returnData)->first();
        }

        if(isset($user->id)) {
            $tilopay = Setting::getTilopaySetting();

            $hash = $this->getHashTilopay($orderid, $orderNumber, $code, $auth, $user->email, $tilopay);

            $http = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $uri = $_SERVER['REQUEST_URI'];
            $url = $http . $host . $uri;

            $payment = Payment::create([
                'id_user' => $user->id,
                'id_vet' => $user->id_vet,
                'currency' => 'USD',
                'amount' => $tilopay->price_pro,
                'code' => $code,
                'responseText' => $description,
                'auth' => $auth,
                'orderNumber' => $orderNumber,
                'orderid' => $orderid,
                'hash' => json_encode(['hash' => $hash, 'tilohash' => $OrderHash, 'url' => $url])
            ]);

            if($code == '1') {
                $vet = Vets::where('id', '=', $user->id_vet)->first();

                if(isset($vet->id)) {
                    $sendEmail = true;
                    if($vet->pro == 1) {
                        $initial = $vet->expire;
                        $sendEmail = false;
                    }else{
                        $initial = date('Y-m-d');
                    }

                    $expire = Carbon::createFromFormat('Y-m-d', $initial);
                    $expire->addMonth();
                    $expire = $expire->format('Y-m-d');

                    $vet->pro = 1;
                    $vet->token = $token;
                    $vet->email_token = $user->email;
                    $vet->expire = $expire;
                    $vet->update();

                    if($sendEmail == true) {
                        $pros = SettingPro::where('enabled', '=', 1)->where('pro', '=', 1)->orderBy('id', 'asc')->get();

                        $data = [
                            'name' => $user->name,
                            'pros' => $pros
                        ];
                        $template = view('emails.general.subscription-confirm', $data)->render();
                
                        Notifications::create([
                            'id_user' => $user->id,
                            'to' => $user->email,
                            'subject' => trans('dash.label.active.pro.title'),
                            'description' => $template,
                            'attach' => '',
                            'email' => 1,
                            'sms' => 0,
                            'whatsapp' => 0,
                            'status' => 0,
                            'attemps' => 0
                        ]);

                        $data = [
                            'payment' => $payment,
                            'vet' => $vet,
                            'user' => $user
                        ];

                        $template = view('emails.general.subscription-confirm-admin', $data)->render();
                
                        $setting = Setting::getEmailSetting();

                        Notifications::create([
                            'id_user' => 0,
                            'to' => (isset($setting->email_to)) ? $setting->email_to : '',
                            'subject' => 'Suscripción a Vetegram PRO',
                            'description' => $template,
                            'attach' => '',
                            'email' => 1,
                            'sms' => 0,
                            'whatsapp' => 0,
                            'status' => 0,
                            'attemps' => 0
                        ]);
                    }else{
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
                    }
                }
            }
        }

        return redirect()->route('home.paymessage', ['code' => $code, 'text' => urlencode($description)]);
    }

    public function getHashTilopay($orderid, $orderNumber, $responseCode, $auth, $email, $tilopay) {        

        $shared_secret = $orderid . '|' . $tilopay->tilopay_key . '|' . $tilopay->tilopay_pass;
        $params = [
            'api_Key' => $tilopay->tilopay_key,
            'api_user' => $tilopay->tilopay_user,
            'orderId' => $orderid,
            'external_orden_id' => $orderNumber,
            'amount' => number_format($tilopay->price_pro, 2),
            'currency' => 'USD',
            'responseCode' => $responseCode,
            'auth' => $auth,
            'email' => $email
        ];
    
        return hash_hmac('sha256', http_build_query($params), $shared_secret);
    }

    public function paymessage(Request $request) {
        $code = $request->code;
        $text = $request->text;

        return view('home.paymessage', compact('code', 'text'));
    }

    public function adminstore() {
        return view('home.adminstore');
    }

    public function addproduct() {
        return view('home.addproduct');
    }
    
}
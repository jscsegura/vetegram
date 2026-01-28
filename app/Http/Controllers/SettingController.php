<?php

namespace App\Http\Controllers;

use App\Console\Commands\GenerateHours;
use App\Models\AnimalBreed;
use App\Models\AnimalBreedVets;
use App\Models\AnimalTypes;
use App\Models\AppointmentHour;
use App\Models\AppointmentTemplate;
use App\Models\PhysicalCategory;
use App\Models\PhysicalCategoryUser;
use App\Models\User;
use App\Models\Vets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class SettingController extends Controller {
    
    public function __construct() {}
    
    public function index(Request $request) {
        $user = Auth::guard('web')->user();

        $template1 = AppointmentTemplate::where('id_user', '=', $user->id)->where('day', '=', 1)->orderBy('hour', 'ASC')->get();
        $template2 = AppointmentTemplate::where('id_user', '=', $user->id)->where('day', '=', 2)->orderBy('hour', 'ASC')->get();
        $template3 = AppointmentTemplate::where('id_user', '=', $user->id)->where('day', '=', 3)->orderBy('hour', 'ASC')->get();
        $template4 = AppointmentTemplate::where('id_user', '=', $user->id)->where('day', '=', 4)->orderBy('hour', 'ASC')->get();
        $template5 = AppointmentTemplate::where('id_user', '=', $user->id)->where('day', '=', 5)->orderBy('hour', 'ASC')->get();
        $template6 = AppointmentTemplate::where('id_user', '=', $user->id)->where('day', '=', 6)->orderBy('hour', 'ASC')->get();
        $template7 = AppointmentTemplate::where('id_user', '=', $user->id)->where('day', '=', 0)->orderBy('hour', 'ASC')->get();

        $profile = User::select('id', 'mode', 'online_booking')->where('id', '=', $user->id)->first();

        $mode = $profile->mode;
        $online_booking = $profile->online_booking;        

        return view('setting.index', compact('template1', 'template2', 'template3', 'template4', 'template5', 'template6', 'template7', 'mode', 'online_booking'));
    }

    public function generateTemplate(Request $request) {
        $user = Auth::guard('web')->user();

        $time  = $request->loadTime * 60;
        $start = $request->loadStart;
        $end   = $request->loadEnd;
        $mode  = $request->loadMode;

        $insertData = [];

        if(isset($_POST['loadDays'])){
            for($i = 0;$i < count($_POST['loadDays']);$i++){
                if($_POST['loadDays'][$i] != ""){
                    $day = $_POST['loadDays'][$i];
                    $startHour = $start;
                    
                    $today = date('Y-m-d H:i:s');
                    while (strtotime($startHour) < strtotime($end)) {
                        array_push($insertData, ['id_user' => $user->id, 'day' => $day, 'hour' => $startHour, 'created_at' => $today]);
                   
                        $aux = strtotime($startHour);
                        $startHour = date("H:i:s",$aux + $time);
                    }
                }
            }
            if(count($insertData) > 0) {
                AppointmentTemplate::insert($insertData);
            }
        }

        $profile = User::where('id', '=', $user->id)->first();

        if(isset($profile->id)) {
            $profile->mode = $mode;
            $profile->update();
        }

        return redirect()->route('sett.index');
    }

    public function edit(Request $request) {
        $user = Auth::guard('web')->user();
        
        $date = (isset($request->date)) ? date("Y-m-d", strtotime(str_replace("/","-", base64_decode($request->date)))) : date('Y-m-d');

        $day = Carbon::createFromFormat('Y-m-d', $date)->format('w');

        $hours = AppointmentHour::where('id_user', '=', $user->id)->where('date', '=', $date)->orderBy('hour', 'ASC')->get();

        return view('setting.edit', compact('date', 'hours', 'day'));
    }

    public function addHour(Request $request) {
        $user = Auth::guard('web')->user();

        $hour = $request->hour . ':' . $request->minute . ':00';

        $exist = AppointmentTemplate::where('id_user', '=', $user->id)->where('day', '=', $request->day)->where('hour', '=', $hour)->first(); 

        if(isset($exist->id)) {
            return response()->json(array('type' => '401'));
        }else{
            $hour = AppointmentTemplate::create([
                'id_user' => $user->id,
                'day' => $request->day,
                'hour' => $hour,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return response()->json(array('type' => '200', 'hour' => date("h:i A", strtotime($request->hour . ':' . $request->minute . ':00')), 'text' => date("Hi", strtotime($request->hour . ':' . $request->minute . ':00')), 'id' => $hour->id));
    }

    public function delHour(Request $request) {
        $user = Auth::guard('web')->user();

        $hour = AppointmentTemplate::where('id', '=', $request->id)->where('id_user', '=', $user->id)->first();

        $removeRow = 0;
        if(isset($hour->id)) {
            $hour->delete();
            $removeRow = 1;
        }

        return response()->json(array('type' => '200', 'isdelete' => $removeRow));
    }

    function setTemplate(Request $request) {
        $user = Auth::guard('web')->user();

        $templates = AppointmentTemplate::where('id_user', '=', $user->id)->where('day', '=', $request->day)->orderBy('hour', 'ASC')->get();
        
        foreach ($templates as $template) {
            AppointmentHour::create([
                'id_user' => $user->id,
                'date' => $request->date,
                'hour' => $template->hour,
                'status' => 0,
                'expire' => null,
                'user_reserve' => 0
            ]);
        }

        return response()->json(array('type' => '200'));
    }

    public function addAvailableHour(Request $request) {
        $user = Auth::guard('web')->user();

        $hour = $request->hour . ':' . $request->minute . ':00';

        $exist = AppointmentHour::where('id_user', '=', $user->id)->where('date', '=', $request->date)->where('hour', '=', $hour)->first(); 

        if(isset($exist->id)) {
            return response()->json(array('type' => '401'));
        }else{
            $hourRow = AppointmentHour::create([
                'id_user' => $user->id,
                'date' => $request->date,
                'hour' => $hour,
                'status' => 0,
                'expire' => null,
                'user_reserve' => 0
            ]);
        }

        return response()->json(array('type' => '200', 'hour' => date("h:i A", strtotime($request->hour . ':' . $request->minute . ':00')), 'text' => date("Hi", strtotime($request->hour . ':' . $request->minute . ':00')), 'id' => $hourRow->id));
    }

    public function delAvailableHour(Request $request) {
        $user = Auth::guard('web')->user();

        $hour = AppointmentHour::where('id_user', '=', $user->id)->where('id', '=', $request->id)->first();

        $removeRow = 0;
        if(isset($hour->id)) {
            $hour->delete();
            $removeRow = 1;
        }

        return response()->json(array('type' => '200', 'isdelete' => $removeRow));
    }

    public function delAllHour(Request $request) {
        $user = Auth::guard('web')->user();

        if((isset($request->template))&&($request->template == true)) {
            AppointmentTemplate::where('id_user', '=', $user->id)->delete();
        }else{
            $hours = AppointmentHour::where('id_user', '=', $user->id)->where('date', '=', $request->date)->get();

            $now = date('Y-m-d H:i:s');
            foreach ($hours as $hour) {
                if($hour->status == 0) {
                    $availableForDelete = true;
                    if(($hour->user_reserve > 0)&&($hour->expire != '')) {
                        $thisnow = strtotime($now);
                        $expire = strtotime($hour->expire);

                        if($thisnow < $expire) {
                            $availableForDelete = false;
                        }
                    }   
                    if($availableForDelete == true) {
                        $hour->delete();
                    }
                }
            }
        }

        return response()->json(array('type' => '200'));
    }

    public function updateMode(Request $request) {
        $user = Auth::guard('web')->user();

        $mode = $request->mode;
        $onlineBooking = $request->onlineBooking;

        $profile = User::select('id', 'mode', 'process')->where('id', '=', $user->id)->first();

        if(isset($profile->id)) {
            $now = date('Y-m-d');
            $now = date("Y-m-d",strtotime($now."- 1 days")); 

            $profile->mode = $mode;
            $profile->process = $now;
            $profile->online_booking = $onlineBooking;
            $profile->update();

            if($mode == 1) {
                (new GenerateHours())->runHours($profile->id);
            }
        }

        return response()->json(array('type' => '200'));
    }

    public function grooming(Request $request) {
        $user = Auth::guard('web')->user();

        $lang = Config::get('app.locale');

        $animalTypes = AnimalTypes::select('id', 'title_' . $lang . ' as title')->where('enabled', '=', 1)->get();
        
        $rows = [];
        foreach ($animalTypes as $type) {
            $breeds = AnimalBreed::select('id', 'title_' . $lang . ' as title')->where('type', '=', $type->id)->where('enabled', '=', 1)->orderBy('title_' . $lang, 'ASC')->get();

            array_push($rows, ['type' => $type->title, 'breeds' => $breeds]);
        }

        $breeds = AnimalBreedVets::where('id_vet', '=', $user->id_vet)->pluck('id_breed')->toArray();

        return view('setting.grooming', compact('rows', 'breeds'));
    }

    public function groomingSave(Request $request) {
        $user = Auth::guard('web')->user();

        $rows = $request->input('breed', []);

        AnimalBreedVets::where('id_vet', '=', $user->id_vet)->delete();

        foreach ($rows as $row) {
            $breedvet = new AnimalBreedVets();
            $breedvet->id_breed = $row;
            $breedvet->id_vet = $user->id_vet;
            $breedvet->save();
        }

        session()->flash('success', trans('dash.success.update.breed.vets'));

        return redirect()->route('sett.grooming');
    }

    public function physicalexam() {
        $user = Auth::guard('web')->user();

        $categories = PhysicalCategory::where('enabled', '=', 1)->orderBy('title_' . Config::get('app.locale'), 'ASC')->with('options')->get();

        $vetCategories = PhysicalCategoryUser::where('id_vet', '=', $user->id_vet)->get();

        $rowOptions = [];
        foreach ($vetCategories as $row) {
            if($row->options != '') {
                $options = json_decode($row->options, true);
                foreach ($options as $option) {
                    array_push($rowOptions, $option);
                }
            }
        }

        return view('setting.physicalexam', compact('categories', 'rowOptions'));
    }

    public function physicalexamStore(Request $request) {
        $user = Auth::guard('web')->user();

        $options = $request->input('options', []);

        $rows = [];
        foreach ($options as $option) {
            $data = explode('-', $option);
            if(isset($rows[$data[0]])) {
                $aux = $rows[$data[0]];
                array_push($aux, $data[1]);
                $rows[$data[0]] = $aux;
            }else{
                $rows[$data[0]] = [$data[1]];
            }
        }

        PhysicalCategoryUser::where('id_vet', '=', $user->id_vet)->delete();

        foreach ($rows as $key =>$row) {
            $category = new PhysicalCategoryUser();
            $category->id_vet = $user->id_vet;
            $category->id_category = $key;
            $category->options = json_encode($row);
            $category->save();
        }

        return redirect()->route('sett.physicalexam');
    }

}
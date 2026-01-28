<?php

namespace App\Http\Controllers;

use App\Console\Commands\sendNotifieds;
use App\Models\AnimalBreed;
use App\Models\AnimalTypes;
use App\Models\AppointmentAttachment;
use App\Models\AppointmentClient;
use App\Models\AppointmentNote;
use App\Models\AppointmentRecipe;
use App\Models\AppointmentRecipeDetails;
use App\Models\Notifications;
use App\Models\Pet;
use App\Models\Reminder;
use App\Models\User;
use App\Models\UserVetDoctor;
use App\Models\Vaccine;
use App\Models\VaccineItem;
use App\Models\VeterinaryCredential;
use App\Models\Vets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use PDF;
use Image;

class PetController extends Controller {
    
    public function __construct() {}
    
    public function detail(Request $request) {
        if(isset($request->api)) {
            $id = $request->id;
        }else{
            $id = User::encryptor('decrypt', $request->id);
        }

        $pet = Pet::where('id', '=', $id)->with('getBreed')->first();

        $owner = User::select('id', 'name', 'email', 'phone')->where('id', '=', $pet->id_user)->first();

        $credentials = VeterinaryCredential::userHasCredentials($owner->id);

        $appointments = AppointmentClient::select('id', 'date', 'hour', 'reason', 'status')
            ->where('id_pet', '=', $id)
            ->orderBy('date', 'desc')
            ->orderBy('hour', 'desc');
        if($credentials['access'] == false) {
            $vetUsers = Vets::getUserMyVet($credentials['id_vet']);
            $ids = [];
            foreach ($vetUsers as $value) {
                array_push($ids, $value->id);
            }
            
            $appointments = $appointments->whereIn('id_user', $ids);
        }
        $appointments = $appointments->get();
        
        $lang = Config::get('app.locale');

        $allTypes = AnimalTypes::where('enabled', '=', 1)->get();
        $allBreed = AnimalBreed::where('enabled', '=', 1)->where('type', '=', $pet->type)->get();

        if(isset($request->api)) {
            return ['type' => 'success', 'pet' => $pet, 'owner' => $owner, 'appointments' => $appointments, 'lang' => $lang, 'allTypes' => $allTypes, 'allBreed' => $allBreed, 'credentials' => $credentials];
        }else{
            $thismenu = 'petappointment';
            return view('pet.detail', compact('pet', 'owner', 'appointments', 'lang', 'thismenu', 'allTypes', 'allBreed', 'credentials'));
        }
    }
    
    public function vaccines(Request $request) {
        $sectionVaccine = 0;
        if(isset($request->api)) {
            $id = $request->id;
        }else{
            $id = User::encryptor('decrypt', $request->id);
        }

        $pet = Pet::where('id', '=', $id)->with('getBreed')->first();

        $owner = User::select('id', 'name', 'email', 'phone')->where('id', '=', $pet->id_user)->first();

        $credentials = VeterinaryCredential::userHasCredentials($owner->id);

        $vaccines = Vaccine::where('id_pet', '=', $pet->id)->where('section', '=', 0)->with('getDoctor')->orderBy('created_at', 'desc');
        if($credentials['access'] == false) {
            $vaccines = $vaccines->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $vaccines = $vaccines->get();

        $lang = Config::get('app.locale');

        $allTypes = AnimalTypes::where('enabled', '=', 1)->get();
        $allBreed = AnimalBreed::where('enabled', '=', 1)->where('type', '=', $pet->type)->get();

        $vaccineItems = VaccineItem::where('type', '=', 1)->where('enabled', '=', 1)->orderBy('title_' . Config::get('app.locale'), 'ASC')->get();

        if(isset($request->api)) {
            return ['type' => 'success', 'sectionVaccine' => $sectionVaccine, 'pet' => $pet, 'owner' => $owner, 'vaccines' => $vaccines, 'lang' => $lang, 'allTypes' => $allTypes, 'allBreed' => $allBreed, 'credentials' => $credentials, 'vaccineItems' => $vaccineItems];
        }else{
            $thismenu = 'petvaccines';
            return view('pet.vaccines', compact('sectionVaccine', 'pet', 'owner', 'lang', 'thismenu', 'vaccines', 'allTypes', 'allBreed', 'credentials', 'vaccineItems'));
        }
        
    }

    public function desparat(Request $request) {
        $sectionVaccine = 1;
        if(isset($request->api)) {
            $id = $request->id;
        }else{
            $id = User::encryptor('decrypt', $request->id);
        }

        $pet = Pet::where('id', '=', $id)->with('getBreed')->first();

        $owner = User::select('id', 'name', 'email', 'phone')->where('id', '=', $pet->id_user)->first();

        $credentials = VeterinaryCredential::userHasCredentials($owner->id);

        $vaccines = Vaccine::where('id_pet', '=', $pet->id)->where('section', '=', 1)->with('getDoctor')->orderBy('created_at', 'desc');
        if($credentials['access'] == false) {
            $vaccines = $vaccines->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $vaccines = $vaccines->get();

        $lang = Config::get('app.locale');

        $allTypes = AnimalTypes::where('enabled', '=', 1)->get();
        $allBreed = AnimalBreed::where('enabled', '=', 1)->where('type', '=', $pet->type)->get();

        $desparacitanteItems = VaccineItem::where('type', '=', 2)->where('enabled', '=', 1)->orderBy('title_' . Config::get('app.locale'), 'ASC')->get();

        if(isset($request->api)) {
            return ['type' => 'success', 'sectionVaccine' => $sectionVaccine, 'pet' => $pet, 'owner' => $owner, 'vaccines' => $vaccines, 'lang' => $lang, 'allTypes' => $allTypes, 'allBreed' => $allBreed, 'credentials' => $credentials, 'desparacitanteItems' => $desparacitanteItems];
        }else{
            $thismenu = 'petdesparations';
            return view('pet.vaccines', compact('sectionVaccine', 'pet', 'owner', 'lang', 'thismenu', 'vaccines', 'allTypes', 'allBreed', 'credentials', 'desparacitanteItems'));
        }
    }

    public function attach(Request $request) {
        if(isset($request->api)) {
            $id = $request->id;
        }else{
            $id = User::encryptor('decrypt', $request->id);
        }

        $pet = Pet::where('id', '=', $id)->with('getBreed')->first();

        $owner = User::select('id', 'name', 'email', 'phone')->where('id', '=', $pet->id_user)->first();

        $credentials = VeterinaryCredential::userHasCredentials($owner->id);
        
        $attachs = AppointmentAttachment::select('id', 'title', 'folder', 'attach', 'created_by', 'created_at')->where('id_pet', $id);
        if($credentials['access'] == false) {
            $attachs = $attachs->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $attachs = $attachs->get();

        $lang = Config::get('app.locale');

        $allTypes = AnimalTypes::where('enabled', '=', 1)->get();
        $allBreed = AnimalBreed::where('enabled', '=', 1)->where('type', '=', $pet->type)->get();

        if(isset($request->api)) {
            return ['type' => 'success', 'pet' => $pet, 'owner' => $owner, 'attachs' => $attachs, 'lang' => $lang, 'allTypes' => $allTypes, 'allBreed' => $allBreed, 'credentials' => $credentials];
        }else{
            $thismenu = 'petattach';
            return view('pet.attach', compact('pet', 'owner', 'lang', 'attachs', 'thismenu', 'allTypes', 'allBreed', 'credentials'));
        }
        
    }

    public function recipes(Request $request) {
        if(isset($request->api)) {
            $id = $request->id;
        }else{
            $id = User::encryptor('decrypt', $request->id);
        }

        $pet = Pet::where('id', '=', $id)->with('getBreed')->first();

        $owner = User::select('id', 'name', 'email', 'phone')->where('id', '=', $pet->id_user)->first();
        
        $credentials = VeterinaryCredential::userHasCredentials($owner->id);

        $recipes = AppointmentRecipe::select('id', 'created_at')->where('id_pet', '=', $id)->with('detail');
        if($credentials['access'] == false) {
            $recipes = $recipes->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $recipes = $recipes->get();

        $lang = Config::get('app.locale');

        $allTypes = AnimalTypes::where('enabled', '=', 1)->get();
        $allBreed = AnimalBreed::where('enabled', '=', 1)->where('type', '=', $pet->type)->get();

        if(isset($request->api)) {
            return ['type' => 'success', 'pet' => $pet, 'owner' => $owner, 'recipes' => $recipes, 'lang' => $lang, 'allTypes' => $allTypes, 'allBreed' => $allBreed, 'credentials' => $credentials];
        }else{
            $thismenu = 'petrecipes';
            return view('pet.recipes', compact('pet', 'owner', 'lang', 'thismenu', 'recipes', 'allTypes', 'allBreed', 'credentials'));
        }
        
    }

    public function owners(Request $request) {
        $user = Auth::guard('web')->user();

        $search = (isset($request->search)) ? base64_decode($request->search) : '';
        
        $patients = UserVetDoctor::where('id_doctor', '=', $user->id)->distinct('id_client')->pluck('id_client');

        if($search != "") {
            $param = '%' . $search . '%';
            $pets = Pet::whereIn('id_user', $patients)
                ->where('name', 'like', $param)
                ->pluck('id_user');

            $users = User::select('id', 'name', 'email', 'phone')
                ->whereIn('id', $patients)
                ->where(function ($query) use ($search, $pets) {
                    $search = '%' . $search . '%';
                    $query->where('name', 'like', $search)
                        ->orWhere('email', 'like', $search)
                        ->orWhere('phone', 'like', $search)
                        ->orWhereIn('id', $pets);
                })
                ->with('getPets')
                ->get();
        }else{
            $users = User::select('id', 'name', 'email', 'phone')->whereIn('id', $patients)->with('getPets')->get();
        }

        $animalTypes = AnimalTypes::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->get();

        $thismenu = 'owners';
        return view('pet.owners', compact('thismenu', 'users', 'search', 'animalTypes'));
    }

    public function myPets(Request $request) {
        $user = Auth::guard('web')->user();

        $pets = Pet::select('id', 'name', 'photo')->where('id_user', '=', $user->id)->get();

        $animalTypes = AnimalTypes::select('id', 'title_es', 'title_en')->where('enabled', '=', 1)->get();

        if(isset($request->api)) {
            return ['type' => 'success', 'pets' => $pets, 'animalTypes' => $animalTypes];
        }else{
            $thismenu = 'pets';
            return view('pet.my-pets', compact('thismenu', 'pets', 'animalTypes'));
        }
    }

    public function savePet(Request $request) {
        $user = Auth::guard('web')->user();

        $pet = new Pet();
        $pet->id_user = $user->id;
        $pet->name    = $request->name;
        $pet->type    = $request->animaltype;
        $pet->breed   = $request->breed;
        $pet->photo   = '';
        $pet->save();

        if($request->hasfile('file')) {
            $file = $request->file('file');
            $imageName = uniqid().time().'profilepet.'.$file->extension();

            if(!File::isDirectory(public_path('files/pet/photos'))) {
                File::makeDirectory(public_path('files/pet/photos'), '0777', true, true);
                chmod(public_path('files/pet/photos'), 0777);
            }

            $newImage = Image::make($file->getRealPath());
            if($newImage != null){
                $new_width  = 500;
                $new_height = 500;
            
                $newImage->resize($new_width, $new_height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            
                $newImage->save(public_path('files/pet/photos/' . $imageName));

                $pet->photo = 'pet/photos/' . $imageName;
                $pet->update();
            }
        }

        if(isset($request->api)) {
            return ['type' => 'success'];
        }else{
            session()->flash('success', 'yes');
            return redirect()->route('pets.index');
        }
    }

    public function editPet(Request $request) {
        $user = Auth::guard('web')->user();

        $petId = $request->petId;

        if($user->rol_id == 8) {
            $pet = Pet::where('id', '=', $petId)->where('id_user', '=', $user->id)->first();
        }else{
            $pet = Pet::where('id', '=', $petId)->first();
        }        

        if(isset($pet->id)) {
            if(isset($request->name)) {
                $pet->name = $request->name;
            }

            if(isset($request->animaltype)) {
                $pet->type = $request->animaltype;
            }

            if(isset($request->breed)) {
                $pet->breed = $request->breed;
            }

            if(isset($request->petage)) {
                $pet->age = date("Y-m-d", strtotime(str_replace("/","-", $request->petage)));
            }
            if(isset($request->sex)) {
                $pet->gender = $request->sex;
            }
            if(isset($request->color)) {
                $pet->color = $request->color;
            }
            if(isset($request->castrated)) {
                $pet->castrate = $request->castrated;
            }
            if(isset($request->feeding)) {
                $pet->alimentation = $request->feeding;
            }
            if(isset($request->blood)) {
                $pet->blood = $request->blood;
            }
            if(isset($request->disease)) {
                $pet->disease = $request->disease;
            }
            if(isset($request->deadFlag)) {
                $pet->dead_flag = $request->deadFlag;
            }else{
                $pet->dead_flag = 0;
            }

            $pet->update();
        }

        if(isset($request->api)) {
            return ['type' => 'success'];
        }else{
            session()->flash('success', trans('auth.success.update.profile'));
            return redirect()->back();
        }
        
    }

    public function savePhoto(Request $request) {
        $user = Auth::guard('web')->user();

        $petId = $request->petIdImg;

        $pet = Pet::where('id', '=', $petId)->first();

        if(isset($pet->id)) {
            if($request->hasfile('petPhoto')) {
                $file = $request->file('petPhoto');
                $imageName = uniqid().time().'profilepet.'.$file->extension();
    
                if(!File::isDirectory(public_path('files/pet/photos'))) {
                    File::makeDirectory(public_path('files/pet/photos'), '0777', true, true);
                    chmod(public_path('files/pet/photos'), 0777);
                }

                if(File::exists(public_path('files/' . $pet->photo))) {
                    File::delete(public_path('files/' . $pet->photo));
                }

                $newImage = Image::make($file->getRealPath());
                if($newImage != null){
                    $new_width  = 500;
                    $new_height = 500;
             
                    $newImage->resize($new_width, $new_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
             
                    $newImage->save(public_path('files/pet/photos/' . $imageName));

                    $pet->photo = 'pet/photos/' . $imageName;
                    $pet->update();
                }
            }
        }

        if(isset($request->api)) {
            return ['type' => 'success', 'message' => trans('auth.success.update.profile')];
        }else{
            session()->flash('success', trans('auth.success.update.profile'));
            return redirect()->back();
        }
    }

    public function delete(Request $request) {
        $user = Auth::guard('web')->user();

        $petId = $request->id;

        $pet = Pet::where('id', '=', $petId)->where('id_user', '=', $user->id)->first();

        if(isset($pet->id)) {
            $appointments = AppointmentClient::where('id_pet', '=', $petId)->get();
            $attachs      = AppointmentAttachment::where('id_pet', '=', $petId)->get();
            $notes        = AppointmentNote::where('id_pet', '=', $petId)->get();
            $recipes      = AppointmentRecipe::where('id_pet', '=', $petId)->get();
            $vaccines     = Vaccine::where('id_pet', '=', $petId)->get();
            $reminders    = Reminder::where('id_pet', '=', $petId)->get();

            foreach ($appointments as $value) {
                $value->delete();
            }
            foreach ($attachs as $value) {
                if(File::exists(public_path('files/' . $value->folder . '/' . $value->attach))) {
                    File::delete(public_path('files/' . $value->folder . '/' . $value->attach));
                }
                $value->delete();
            }
            foreach ($notes as $value) {
                $value->delete();
            }
            foreach ($recipes as $value) {
                AppointmentRecipeDetails::where('id_recipe', '=', $value->id)->delete();
                $value->delete();
            }
            foreach ($vaccines as $value) {
                $value->delete();
            }
            foreach ($reminders as $value) {
                $value->delete();
            }

            $pet->delete();

            return response()->json(array('type' => '200', 'process' => '1'));
        }

        return response()->json(array('type' => '200', 'process' => '0'));
    }

    public function getAccess(Request $request) {
        $user = Auth::guard('web')->user();

        $id = User::encryptor('decrypt', $request->id);

        $pet = Pet::select('id', 'name', 'id_user')->where('id', '=', $id)->first();

        if(isset($pet->id)) {
            $owner = User::select('id', 'name', 'email', 'phone')->where('id', '=', $pet->id_user)->first();

            if(isset($owner->id)) {
                $vet = Vets::where('id', '=', $user->id_vet)->first();

                $data = [
                    'name' => $owner->name,
                    'vetName' => ($vet->company != '') ? $vet->company : $vet->social_name, 
                    'code'    => User::encryptor('encrypt', $vet->id . '-' . $owner->id)
                ];
                $template = view('emails.general.permit-application', $data)->render();
    
                $row = Notifications::create([
                    'id_user' => 0,
                    'to' => (isset($owner->email)) ? $owner->email : '',
                    'subject' => trans('dash.label.permit.application'),
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

            return response()->json(array('type' => '200', 'message' => '1'));

        }

        return response()->json(array('type' => '200', 'message' => '0'));
    }

    public function setAccess(Request $request) {
        $code = User::encryptor('decrypt', $request->code);

        $ids = explode("-", $code);

        if((isset($ids[0])) && (isset($ids[1]))) {
            VeterinaryCredential::setCredentials($ids[1], $ids[0]);
        }

        return view('pet.set-access');
    }

    public function downloadHistory(Request $request) {
        $id = User::encryptor('decrypt', $request->id);

        $pet = Pet::where('id', '=', $id)->with('getUser')->with('getType')->with('getBreed')->first();

        $appointments = AppointmentClient::where('id_pet', '=', $id)
            ->orderBy('date', 'desc')
            ->orderBy('hour', 'desc')
            ->with('getAllNotes')
            ->with('getRecipesId')
            ->with('getDoctor')
            ->get();

        $credentials = VeterinaryCredential::userHasCredentials($pet->id_user);

        $recipes = AppointmentRecipe::select('id', 'created_by', 'created_at')->where('id_pet', '=', $id)->with('detail')->with('getDoctor');
        if($credentials['access'] == false) {
            $recipes = $recipes->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $recipes = $recipes->get();

        $vaccines = Vaccine::where('id_pet', '=', $id)->where('section', '=', 0)->orderBy('created_at', 'desc');
        if($credentials['access'] == false) {
            $vaccines = $vaccines->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $vaccines = $vaccines->get();

        $desparat = Vaccine::where('id_pet', '=', $id)->where('section', '=', 1)->orderBy('created_at', 'desc');
        if($credentials['access'] == false) {
            $desparat = $desparat->where('id_vet_created', '=', $credentials['id_vet']);
        }
        $desparat = $desparat->get();

        $filename = 'HistorialClinico' . date('dmY_Hia') . '.pdf'; 
        
        $data = [
            'pet' => $pet,
            'appointments' => $appointments,
            'recipes' => $recipes,
            'vaccines' => $vaccines,
            'desparat' => $desparat,
            'credentials' => $credentials
        ];
        
        $pdf = PDF::loadView('pdf.historical', $data);

        return $pdf->download($filename);
    }

    public function viewAttach(Request $request) {
        $id = User::encryptor('decrypt', $request->id);

        $attach = AppointmentAttachment::select('id', 'title', 'folder', 'attach', 'created_at')->where('id', '=', $id)->first();

        return view('pet.view-attach', compact('attach'));
    }

    public function entryVaccine(Request $request) {
        $id = $request->id;

        return view('pet.add-entry', compact('id'));
    }

}
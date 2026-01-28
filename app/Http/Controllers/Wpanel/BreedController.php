<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\AnimalBreed;
use App\Models\AnimalBreedImage;
use App\Models\AnimalTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Image;

class BreedController extends Controller {

    public function __construct() {}
    
    public function index(Request $request) {
        $type = $request->type;

        $row = AnimalTypes::where('id', '=', $type)->first();

        return view('wpanel.breed.index', compact('type', 'row'));
    }

    public function list(Request $request) {
        $type = $request->type;

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');

        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $records = [];
        $totalRecordswithFilter = 0;
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $totalRecordswithFilter = AnimalBreed::select('count(*) as allcount')->where('type', '=', $type)->search($searchValue)->count();

            $records = AnimalBreed::orderBy($columnName, $columnSortOrder)
                ->search($searchValue)
                ->select('id', 'title_es', 'enabled')
                ->where('type', '=', $type)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }

        $result = array();
        foreach ($records as $row) {
            $result[] = array(
                'id' => $row->id,
                'title_es' => $row->title_es,
                'enabled' => $row->enabled
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $result
        );

        echo json_encode($response);
        exit;
    }

    public function create(Request $request) {
        $type = $request->type;

        $row = AnimalTypes::where('id', '=', $type)->first();

        return view('wpanel.breed.create', compact('type', 'row'));
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
                            
            $breed = new AnimalBreed();
            $breed->type     = $request->type;
            $breed->title_es = $request->title_es;
            $breed->title_en = $request->title_en;
            $breed->enabled  = 1;
            $breed->save();

            session()->flash('success', 'Raza de animal creado exitosamente!');

            return redirect(route('wp.animal-breed.index', $request->type));
        }
        die;
    }

    public function edit(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $breed = AnimalBreed::where('id', '=', $request->id)->first();

            $row = AnimalTypes::where('id', '=', $breed->type)->first();
            
            return view('wpanel.breed.edit', compact('breed', 'row'));
        }
    }

    public function update(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $breed = AnimalBreed::where('id', '=', $request->id)->first();

            $breed->title_es = $request->title_es;
            $breed->title_en = $request->title_en;
            $breed->update();

            session()->flash('success', 'Raza de animal actualizado exitosamente!');

            return redirect(route('wp.animal-breed.index', $breed->type));
        }
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $breed = AnimalBreed::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($breed->id)) {
                if($breed->enabled == 1) {
                    $breed->enabled = 0;
                    $breed->update();
                    $enabled = 0;
                }else{
                    $breed->enabled = 1;
                    $breed->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function delete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            AnimalBreed::where('id', '=', $request->id)->delete();
        }
        return response()->json(array('type' => '200'));
    }

    public function images(Request $request) {
        $id = $request->id;

        $breed = AnimalBreed::select('id', 'title_es', 'type', 'enabled')->where('id', '=', $id)->first();

        $rows = AnimalBreedImage::where('id_breed', '=', $id)->get();

        return view('wpanel.breed.images', compact('rows', 'breed'));
    }

    public function imageList(Request $request) {
        $id = $request->id;

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');

        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $records = [];
        $totalRecordswithFilter = 0;
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $totalRecordswithFilter = AnimalBreedImage::select('count(*) as allcount')->where('id_breed', '=', $id)->search($searchValue)->count();

            $records = AnimalBreedImage::orderBy($columnName, $columnSortOrder)
                ->search($searchValue)
                ->select('id', 'title_es', 'image', 'enabled')
                ->where('id_breed', '=', $id)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }

        $result = array();
        foreach ($records as $row) {
            $result[] = array(
                'id' => $row->id,
                'title_es' => $row->title_es,
                'image' => asset($row->image),
                'enabled' => $row->enabled
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $result
        );

        echo json_encode($response);
        exit;
    }

    public function createImage(Request $request) {
        $id = $request->id;

        $breed = AnimalBreed::select('id', 'title_es', 'enabled')->where('id', '=', $id)->first();

        return view('wpanel.breed.createImage', compact('id', 'breed'));
    }

    public function storeImage(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {

            if($request->hasfile('photo')) {
                $file = $request->file('photo');
                $imageName = uniqid().time().'grooming.'.$file->extension();
                
                if(!File::isDirectory(public_path('files/grooming/images'))) {
                    File::makeDirectory(public_path('files/grooming/images'), '0777', true, true);
                }

                $newImage = Image::make($file->getRealPath());
                if($newImage != null){
                    $new_width  = 400;
                    $new_height = 400;
                
                    $newImage->resize($new_width, $new_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $newImage->save(public_path('files/grooming/images/' . $imageName));

                    $image = new AnimalBreedImage();
                    $image->id_breed = $request->breedId;
                    $image->title_es = $request->title_es;
                    $image->title_en = $request->title_en;
                    $image->image    = 'files/grooming/images/' . $imageName;
                    $image->enabled  = 1;
                    $image->save();
                }
            }

            session()->flash('success', 'Imagen de Grooming creado exitosamente!');

            return redirect(route('wp.animal-breed.images', $request->breedId));
        }
        die;
    }

    public function editImage(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $row = AnimalBreedImage::where('id', '=', $request->id)->first();

            $breed = AnimalBreed::where('id', '=', $row->id_breed)->first();
            
            return view('wpanel.breed.editImage', compact('breed', 'row'));
        }
    }

    public function updateImage(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $image = AnimalBreedImage::where('id', '=', $request->id)->first();

            $image->title_es = $request->title_es;
            $image->title_en = $request->title_en;
            $image->update();

            if($request->hasfile('photo')) {
                $file = $request->file('photo');
                $imageName = uniqid().time().'grooming.'.$file->extension();
                
                if(!File::isDirectory(public_path('files/grooming/images'))) {
                    File::makeDirectory(public_path('files/grooming/images'), '0777', true, true);
                }

                $newImage = Image::make($file->getRealPath());
                if($newImage != null){
                    $new_width  = 400;
                    $new_height = 400;
                
                    $newImage->resize($new_width, $new_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $newImage->save(public_path('files/grooming/images/' . $imageName));

                    $image->image = 'files/grooming/images/' . $imageName;
                    $image->update();
                }
            }

            session()->flash('success', 'Imagen de Grooming actualizado exitosamente!');

            return redirect(route('wp.animal-breed.images', $image->id_breed));
        }
    }

    public function enabledImage(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $breed = AnimalBreedImage::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($breed->id)) {
                if($breed->enabled == 1) {
                    $breed->enabled = 0;
                    $breed->update();
                    $enabled = 0;
                }else{
                    $breed->enabled = 1;
                    $breed->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function deleteImage(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $image = AnimalBreedImage::where('id', '=', $request->id)->first();

            if(File::exists(public_path($image->image))) {
                File::delete(public_path( $image->image));
            }

            $image->delete();
        }
        return response()->json(array('type' => '200'));
    }

    public function deleteFile(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $image = AnimalBreedImage::select('id', 'image')->where('id', '=', $request->id)->first();

            if($image->image != '') {
                if (file_exists(public_path($image->image))) {
                    @unlink(public_path($image->image));
                }
            }

            $image->image = '';
            $image->update();
        }

        $obligatory = true;
        return view('wpanel.generic.photo', compact('obligatory'));
    }

}
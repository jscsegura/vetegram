<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AboutMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Image;

class AboutController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.about.index');
    }

    public function list(Request $request) {
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
            $totalRecordswithFilter = About::select('count(*) as allcount')->search($searchValue)->count();

            $records = About::orderBy($columnName, $columnSortOrder)
                ->search($searchValue)
                ->select('id', 'title_es', 'enabled')
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

    public function create() {
        return view('wpanel.about.create');
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
                            
            $about = new About();
            $about->title_es = $request->title_es;
            $about->title_en = $request->title_en;
            $about->description_es = $request->description_es;
            $about->description_en = $request->description_en;
            $about->image = $request->icon;
            $about->enabled = 1;
            $about->save();

            session()->flash('success', 'Sobre nosotros creado exitosamente!');

            return redirect(route('wp.about.index'));
        }
        die;
    }

    public function edit($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $about = About::where('id', '=', $id)->first();
            
            return view('wpanel.about.edit', compact('about'));
        }
    }

    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $about = About::where('id', '=', $id)->first();

            $about->title_es = $request->title_es;
            $about->title_en = $request->title_en;
            $about->description_es = $request->description_es;
            $about->description_en = $request->description_en;
            $about->image = $request->icon;
            $about->update();

            session()->flash('success', 'Sobre nosotros actualizado exitosamente!');

            return redirect(route('wp.about.index'));
        }
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $about = About::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($about->id)) {
                if($about->enabled == 1) {
                    $about->enabled = 0;
                    $about->update();
                    $enabled = 0;
                }else{
                    $about->enabled = 1;
                    $about->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function delete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {            
            About::where('id', '=', $request->id)->delete();
        }
        return response()->json(array('type' => '200'));
    }

    public function deletefileintro(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $about = AboutMain::select('id', 'image')->where('id', '=', $request->id)->first();

            if($about->image != '') {
                if (file_exists(public_path('files/' . $about->image))) {
                    @unlink(public_path('files/' . $about->image));
                }
            }

            $about->image = '';
            $about->update();
        }

        $obligatory = true;
        return view('wpanel.generic.photo', compact('obligatory'));
    }

    public function intro() {
        $about = AboutMain::where('id', '=', 1)->first();

        if(!isset($about->id)) {
            $about = new AboutMain();
            $about->id = 1;
            $about->title_es = '';
            $about->title_en = '';
            $about->description_es = '';
            $about->description_en = '';
            $about->image = '';
            $about->save();
        }

        return view('wpanel.about.intro', compact('about'));
    }

    public function saveIntro(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $about = AboutMain::where('id', '=', $id)->first();

            $about->title_es = $request->title_es;
            $about->title_en = $request->title_en;
            $about->description_es = $request->description_es;
            $about->description_en = $request->description_en;
            $about->update();

            if($request->hasfile('photo')) {
                $file = $request->file('photo');
                $imageName = uniqid().time().'abouts.'.$file->extension();
    
                if(!File::isDirectory(public_path('files/about'))) {
                    File::makeDirectory(public_path('files/about'), '0777', true, true);
                    chmod(public_path('files/about'), 0777);
                }
    
                $newImage = Image::make($file->getRealPath());
                if($newImage != null){
                    $new_width  = 1920;
                    $new_height = 800;
                
                    $newImage->resize($new_width, $new_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                
                    $newImage->save(public_path('files/about/' . $imageName));
    
                    $about->image = 'about/' . $imageName;
                    $about->update();
                }
            }

            session()->flash('success', 'Sobre nosotros actualizado exitosamente!');

            return view('wpanel.about.intro', compact('about'));
        }
    }

}
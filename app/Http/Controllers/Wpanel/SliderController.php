<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Image;

class SliderController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.slider.index');
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
            $totalRecordswithFilter = Slider::select('count(*) as allcount')->search($searchValue)->count();

            $records = Slider::orderBy($columnName, $columnSortOrder)
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
        return view('wpanel.slider.create');
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
                            
            $slider = new Slider();
            $slider->title_es = $request->title_es;
            $slider->title_en = $request->title_en;
            $slider->description_es = $request->description_es;
            $slider->description_en = $request->description_en;
            $slider->image = '';
            $slider->image_movil = '';
            $slider->enabled = 1;
            $slider->save();

            if($request->hasfile('photo')) {
                $file = $request->file('photo');
                $imageName = uniqid().time().'slider.'.$file->extension();
    
                if(!File::isDirectory(public_path('files/sliders'))) {
                    File::makeDirectory(public_path('files/sliders'), '0777', true, true);
                    chmod(public_path('files/sliders'), 0777);
                }
    
                $newImage = Image::make($file->getRealPath());
                if($newImage != null){
                    $new_width  = 1920;
                    $new_height = 800;
                
                    $newImage->resize($new_width, $new_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                
                    $newImage->save(public_path('files/sliders/' . $imageName));
    
                    $slider->image = 'sliders/' . $imageName;
                    $slider->update();
                }
            }

            if($request->hasfile('photomovil')) {
                $file = $request->file('photomovil');
                $imageName = uniqid().time().'slidermv.'.$file->extension();
    
                if(!File::isDirectory(public_path('files/sliders'))) {
                    File::makeDirectory(public_path('files/sliders'), '0777', true, true);
                    chmod(public_path('files/sliders'), 0777);
                }
    
                $newImage = Image::make($file->getRealPath());
                if($newImage != null){
                    $new_width  = 800;
                    $new_height = 950;
                
                    $newImage->resize($new_width, $new_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                
                    $newImage->save(public_path('files/sliders/' . $imageName));
    
                    $slider->image_movil = 'sliders/' . $imageName;
                    $slider->update();
                }
            }

            session()->flash('success', 'Slider creado exitosamente!');

            return redirect(route('wp.slider.index'));
        }
        die;
    }

    public function edit($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $slider = Slider::where('id', '=', $id)->first();
            
            return view('wpanel.slider.edit', compact('slider'));
        }
    }

    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $slider = Slider::where('id', '=', $id)->first();

            $slider->title_es = $request->title_es;
            $slider->title_en = $request->title_en;
            $slider->description_es = $request->description_es;
            $slider->description_en = $request->description_en;
            $slider->update();

            if($request->hasfile('photo')) {
                $file = $request->file('photo');
                $imageName = uniqid().time().'slider.'.$file->extension();
    
                if(!File::isDirectory(public_path('files/sliders'))) {
                    File::makeDirectory(public_path('files/sliders'), '0777', true, true);
                    chmod(public_path('files/sliders'), 0777);
                }
    
                $newImage = Image::make($file->getRealPath());
                if($newImage != null){
                    $new_width  = 1920;
                    $new_height = 800;
                
                    $newImage->resize($new_width, $new_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                
                    $newImage->save(public_path('files/sliders/' . $imageName));
    
                    $slider->image = 'sliders/' . $imageName;
                    $slider->update();
                }
            }

            if($request->hasfile('photomovil')) {
                $file = $request->file('photomovil');
                $imageName = uniqid().time().'slidermv.'.$file->extension();
    
                if(!File::isDirectory(public_path('files/sliders'))) {
                    File::makeDirectory(public_path('files/sliders'), '0777', true, true);
                    chmod(public_path('files/sliders'), 0777);
                }
    
                $newImage = Image::make($file->getRealPath());
                if($newImage != null){
                    $new_width  = 800;
                    $new_height = 950;
                
                    $newImage->resize($new_width, $new_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                
                    $newImage->save(public_path('files/sliders/' . $imageName));
    
                    $slider->image_movil = 'sliders/' . $imageName;
                    $slider->update();
                }
            }

            session()->flash('success', 'Slider actualizado exitosamente!');

            return redirect(route('wp.slider.index'));
        }
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $slider = Slider::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($slider->id)) {
                if($slider->enabled == 1) {
                    $slider->enabled = 0;
                    $slider->update();
                    $enabled = 0;
                }else{
                    $slider->enabled = 1;
                    $slider->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function delete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $slider = Slider::select('id', 'image', 'image_movil')->where('id', '=', $request->id)->first();
            
            if($slider->image != '') {
                if (file_exists(public_path('files/' . $slider->image))) {
                    @unlink(public_path('files/' . $slider->image));
                }
            }

            if($slider->image_movil != '') {
                if (file_exists(public_path('files/' . $slider->image_movil))) {
                    @unlink(public_path('files/' . $slider->image_movil));
                }
            }

            $slider = Slider::where('id', '=', $request->id)->delete();
        }
        return response()->json(array('type' => '200'));
    }

    public function deletefile(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $slider = Slider::select('id', 'image')->where('id', '=', $request->id)->first();

            if($slider->image != '') {
                if (file_exists(public_path('files/' . $slider->image))) {
                    @unlink(public_path('files/' . $slider->image));
                }
            }

            $slider->image = '';
            $slider->update();
        }

        $obligatory = true;
        return view('wpanel.generic.photo', compact('obligatory'));
    }

    public function deletefileMovil(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $slider = Slider::select('id', 'image_movil')->where('id', '=', $request->id)->first();

            if($slider->image_movil != '') {
                if (file_exists(public_path('files/' . $slider->image_movil))) {
                    @unlink(public_path('files/' . $slider->image_movil));
                }
            }

            $slider->image_movil = '';
            $slider->update();
        }

        $obligatory = true;$name = 'photomovil';
        return view('wpanel.generic.photo', compact('obligatory', 'name'));
    }

}
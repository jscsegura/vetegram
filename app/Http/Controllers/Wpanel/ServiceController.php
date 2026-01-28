<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Image;

class ServiceController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.service.index');
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
            $totalRecordswithFilter = Service::select('count(*) as allcount')->search($searchValue)->count();

            $records = Service::orderBy($columnName, $columnSortOrder)
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
        return view('wpanel.service.create');
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
                            
            $service = new Service();
            $service->title_es = $request->title_es;
            $service->title_en = $request->title_en;
            $service->description_es = $request->description_es;
            $service->description_en = $request->description_en;
            $service->image = '';
            $service->enabled = 1;
            $service->save();

            if($request->hasfile('photo')) {
                $file = $request->file('photo');
                $imageName = uniqid().time().'services.'.$file->extension();
    
                if(!File::isDirectory(public_path('files/services'))) {
                    File::makeDirectory(public_path('files/services'), '0777', true, true);
                    chmod(public_path('files/services'), 0777);
                }
    
                $newImage = Image::make($file->getRealPath());
                if($newImage != null){
                    $new_width  = 1920;
                    $new_height = 800;
                
                    $newImage->resize($new_width, $new_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                
                    $newImage->save(public_path('files/services/' . $imageName));
    
                    $service->image = 'services/' . $imageName;
                    $service->update();
                }
            }

            session()->flash('success', 'Servicio creado exitosamente!');

            return redirect(route('wp.service.index'));
        }
        die;
    }

    public function edit($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $service = Service::where('id', '=', $id)->first();
            
            return view('wpanel.service.edit', compact('service'));
        }
    }

    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $service = Service::where('id', '=', $id)->first();

            $service->title_es = $request->title_es;
            $service->title_en = $request->title_en;
            $service->description_es = $request->description_es;
            $service->description_en = $request->description_en;
            $service->update();

            if($request->hasfile('photo')) {
                $file = $request->file('photo');
                $imageName = uniqid().time().'service.'.$file->extension();
    
                if(!File::isDirectory(public_path('files/services'))) {
                    File::makeDirectory(public_path('files/services'), '0777', true, true);
                    chmod(public_path('files/services'), 0777);
                }
    
                $newImage = Image::make($file->getRealPath());
                if($newImage != null){
                    $new_width  = 1920;
                    $new_height = 800;
                
                    $newImage->resize($new_width, $new_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                
                    $newImage->save(public_path('files/services/' . $imageName));
    
                    $service->image = 'services/' . $imageName;
                    $service->update();
                }
            }

            session()->flash('success', 'Servicio actualizado exitosamente!');

            return redirect(route('wp.service.index'));
        }
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $service = Service::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($service->id)) {
                if($service->enabled == 1) {
                    $service->enabled = 0;
                    $service->update();
                    $enabled = 0;
                }else{
                    $service->enabled = 1;
                    $service->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function delete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $service = Service::select('id', 'image')->where('id', '=', $request->id)->first();
            
            if($service->image != '') {
                if (file_exists(public_path('files/' . $service->image))) {
                    @unlink(public_path('files/' . $service->image));
                }
            }

            $service = Service::where('id', '=', $request->id)->delete();
        }
        return response()->json(array('type' => '200'));
    }

    public function deletefile(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $service = Service::select('id', 'image')->where('id', '=', $request->id)->first();

            if($service->image != '') {
                if (file_exists(public_path('files/' . $service->image))) {
                    @unlink(public_path('files/' . $service->image));
                }
            }

            $service->image = '';
            $service->update();
        }

        $obligatory = true;
        return view('wpanel.generic.photo', compact('obligatory'));
    }

}
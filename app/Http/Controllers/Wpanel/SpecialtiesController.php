<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\Specialties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecialtiesController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.specialties.index');
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
            $totalRecordswithFilter = Specialties::select('count(*) as allcount')->search($searchValue)->count();

            $records = Specialties::orderBy($columnName, $columnSortOrder)
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
        return view('wpanel.specialties.create');
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
                            
            $specialties = new Specialties();
            $specialties->title_es = $request->title_es;
            $specialties->title_en = $request->title_en;
            $specialties->enabled  = 1;
            $specialties->save();

            session()->flash('success', 'Especialidad creada exitosamente!');

            return redirect(route('wp.specialties.index'));
        }
        die;
    }

    public function edit($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $specialtie = Specialties::where('id', '=', $id)->first();
            
            return view('wpanel.specialties.edit', compact('specialtie'));
        }
    }

    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $specialties = Specialties::where('id', '=', $id)->first();

            $specialties->title_es = $request->title_es;
            $specialties->title_en = $request->title_en;
            $specialties->update();

            session()->flash('success', 'Especialidad actualizada exitosamente!');

            return redirect(route('wp.specialties.index'));
        }
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $specialties = Specialties::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($specialties->id)) {
                if($specialties->enabled == 1) {
                    $specialties->enabled = 0;
                    $specialties->update();
                    $enabled = 0;
                }else{
                    $specialties->enabled = 1;
                    $specialties->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function delete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            Specialties::where('id', '=', $request->id)->delete();
        }
        return response()->json(array('type' => '200'));
    }

}
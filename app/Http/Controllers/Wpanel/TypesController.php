<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\AnimalTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypesController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.types.index');
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
            $totalRecordswithFilter = AnimalTypes::select('count(*) as allcount')->search($searchValue)->count();

            $records = AnimalTypes::orderBy($columnName, $columnSortOrder)
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
        return view('wpanel.types.create');
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
                            
            $types = new AnimalTypes();
            $types->title_es = $request->title_es;
            $types->title_en = $request->title_en;
            $types->enabled  = 1;
            $types->save();

            session()->flash('success', 'Tipo de animal creado exitosamente!');

            return redirect(route('wp.animal-types.index'));
        }
        die;
    }

    public function edit($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $types = AnimalTypes::where('id', '=', $id)->first();
            
            return view('wpanel.types.edit', compact('types'));
        }
    }

    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $types = AnimalTypes::where('id', '=', $id)->first();

            $types->title_es = $request->title_es;
            $types->title_en = $request->title_en;
            $types->update();

            session()->flash('success', 'Tipo de animal actualizado exitosamente!');

            return redirect(route('wp.animal-types.index'));
        }
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $types = AnimalTypes::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($types->id)) {
                if($types->enabled == 1) {
                    $types->enabled = 0;
                    $types->update();
                    $enabled = 0;
                }else{
                    $types->enabled = 1;
                    $types->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function delete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            AnimalTypes::where('id', '=', $request->id)->delete();
        }
        return response()->json(array('type' => '200'));
    }

}
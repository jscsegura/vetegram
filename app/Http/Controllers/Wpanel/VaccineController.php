<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\VaccineItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaccineController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.vaccine.index');
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
            $totalRecordswithFilter = VaccineItem::select('count(*) as allcount')->search($searchValue)->count();

            $records = VaccineItem::orderBy($columnName, $columnSortOrder)
                ->search($searchValue)
                ->select('id', 'type', 'title_es', 'interval', 'enabled')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }

        $result = array();
        foreach ($records as $row) {
            $result[] = array(
                'id' => $row->id,
                'type' => ($row->type == 1) ? 'Vacunas' : 'Desparasitante',
                'title_es' => $row->title_es,
                'interval' => $row->interval . ' días',
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
        return view('wpanel.vaccine.create');
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
                            
            $vaccine = new VaccineItem();
            $vaccine->type = $request->type;
            $vaccine->title_es = $request->title_es;
            $vaccine->title_en = $request->title_en;
            $vaccine->interval = $request->interval;
            $vaccine->enabled  = 1;
            $vaccine->save();

            session()->flash('success', 'Item creado exitosamente!');

            return redirect(route('wp.vaccine.index'));
        }
        die;
    }

    public function edit($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $vaccine = VaccineItem::where('id', '=', $id)->first();
            
            return view('wpanel.vaccine.edit', compact('vaccine'));
        }
    }

    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $vaccine = VaccineItem::where('id', '=', $id)->first();

            $vaccine->type = $request->type;
            $vaccine->title_es = $request->title_es;
            $vaccine->title_en = $request->title_en;
            $vaccine->interval = $request->interval;
            $vaccine->update();

            session()->flash('success', 'Item actualizado exitosamente!');

            return redirect(route('wp.vaccine.index'));
        }
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $vaccine = VaccineItem::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($vaccine->id)) {
                if($vaccine->enabled == 1) {
                    $vaccine->enabled = 0;
                    $vaccine->update();
                    $enabled = 0;
                }else{
                    $vaccine->enabled = 1;
                    $vaccine->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function delete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            VaccineItem::where('id', '=', $request->id)->delete();
        }
        return response()->json(array('type' => '200'));
    }

}
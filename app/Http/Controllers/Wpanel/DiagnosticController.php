<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\Diagnostic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosticController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.diagnostic.index');
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
            $totalRecordswithFilter = Diagnostic::select('count(*) as allcount')->search($searchValue)->count();

            $records = Diagnostic::orderBy($columnName, $columnSortOrder)
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
        return view('wpanel.diagnostic.create');
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
                            
            $diagnostic = new Diagnostic();
            $diagnostic->title_es = $request->title_es;
            $diagnostic->title_en = $request->title_en;
            $diagnostic->enabled = 1;
            $diagnostic->save();

            session()->flash('success', 'Diagnostico creado exitosamente!');

            return redirect(route('wp.diagnostic.index'));
        }
        die;
    }

    public function edit($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $diagnostic = Diagnostic::where('id', '=', $id)->first();
            
            return view('wpanel.diagnostic.edit', compact('diagnostic'));
        }
    }

    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $diagnostic = Diagnostic::where('id', '=', $id)->first();

            $diagnostic->title_es = $request->title_es;
            $diagnostic->title_en = $request->title_en;
            $diagnostic->update();

            session()->flash('success', 'Diagnostico actualizado exitosamente!');

            return redirect(route('wp.diagnostic.index'));
        }
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $diagnostic = Diagnostic::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($diagnostic->id)) {
                if($diagnostic->enabled == 1) {
                    $diagnostic->enabled = 0;
                    $diagnostic->update();
                    $enabled = 0;
                }else{
                    $diagnostic->enabled = 1;
                    $diagnostic->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function delete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            Diagnostic::where('id', '=', $request->id)->delete();
        }
        return response()->json(array('type' => '200'));
    }

}
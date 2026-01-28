<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.language.index');
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
            $totalRecordswithFilter = Language::select('count(*) as allcount')->search($searchValue)->count();

            $records = Language::orderBy($columnName, $columnSortOrder)
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
        return view('wpanel.language.create');
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
                            
            $language = new Language();
            $language->title_es = $request->title_es;
            $language->title_en = $request->title_en;
            $language->enabled  = 1;
            $language->save();

            session()->flash('success', 'Especialidad creada exitosamente!');

            return redirect(route('wp.language.index'));
        }
        die;
    }

    public function edit($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $language = Language::where('id', '=', $id)->first();
            
            return view('wpanel.language.edit', compact('language'));
        }
    }

    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $language = Language::where('id', '=', $id)->first();

            $language->title_es = $request->title_es;
            $language->title_en = $request->title_en;
            $language->update();

            session()->flash('success', 'Especialidad actualizada exitosamente!');

            return redirect(route('wp.language.index'));
        }
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $language = Language::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($language->id)) {
                if($language->enabled == 1) {
                    $language->enabled = 0;
                    $language->update();
                    $enabled = 0;
                }else{
                    $language->enabled = 1;
                    $language->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function delete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            Language::where('id', '=', $request->id)->delete();
        }
        return response()->json(array('type' => '200'));
    }

}
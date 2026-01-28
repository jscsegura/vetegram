<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.countries.index');
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
            $totalRecordswithFilter = Countries::select('count(*) as allcount')->search($searchValue)->count();

            $records = Countries::orderBy($columnName, $columnSortOrder)
                ->search($searchValue)
                ->select('id', 'title', 'iso2', 'iso3', 'phonecode', 'enabled')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }

        $result = array();
        foreach ($records as $row) {
            $result[] = array(
                'id' => $row->id,
                'title' => $row->title,
                'iso2' => $row->iso2,
                'iso3' => $row->iso3,
                'phonecode' => $row->phonecode,
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

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $country = Countries::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($country->id)) {
                if($country->enabled == 1) {
                    $country->enabled = 0;
                    $country->update();
                    $enabled = 0;
                }else{
                    $country->enabled = 1;
                    $country->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

}
<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\Canton;
use App\Models\Countries;
use App\Models\District;
use App\Models\Language;
use App\Models\Pet;
use App\Models\Province;
use App\Models\Specialties;
use App\Models\User;
use App\Models\Vets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.client.index');
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
            $totalRecordswithFilter = User::select('count(*) as allcount')->search($searchValue)->where('rol_id', '=', 8)->count();

            $records = User::orderBy($columnName, $columnSortOrder)
                ->search($searchValue)
                ->select('id', 'name', 'email', 'phone', 'rol_id', 'lock', 'enabled')
                ->where('rol_id', '=', 8)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }

        $result = array();
        foreach ($records as $row) {
            $result[] = array(
                'id' => $row->id,
                'name' => $row->name,
                'email' => $row->email,
                'phone' => $row->phone,
                'rol_id' => $row->rol_id,
                'lock' => $row->lock,
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

    public function detail(Request $request) {
        $id = $request->id;

        $user = User::where('id', '=', $id)->first();

        $country = Countries::where('id', '=', $user->country)->first();

        $province  = '';
        $canton    = '';
        $district = '';
        if((isset($country->id)) &&($country->id == 53)) {
            $province  = Province::where('id', '=', $user->province)->first();
            $canton    = Canton::where('id', '=', $user->canton)->first();
            $district = District::where('id', '=', $user->district)->first();

            $province  = $province->title;
            $canton    = $canton->title;
            $district = $district->title;
        }else{
            $province  = $user->province;
            $canton    = $user->canton;
            $district = $user->district;
        }

        $pets = Pet::select('id', 'id_user', 'name', 'type', 'breed')
            ->where('id_user', '=', $user->id)
            ->with('getType')
            ->with('getBreed')
            ->orderBy('name', 'ASC')
            ->get();

        return view('wpanel.client.detail', compact('user', 'country', 'province', 'canton', 'district', 'pets'));
    }

    public function lock(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $user = User::select('id', 'lock')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($user->id)) {
                if($user->lock == 1) {
                    $user->lock = 0;
                    $user->update();
                    $enabled = 0;
                }else{
                    $user->lock = 1;
                    $user->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $user = User::select('id', 'enabled', 'email_verified_at')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($user->id)) {
                if($user->enabled == 1) {
                    $user->enabled = 0;
                    $user->update();
                    $enabled = 0;
                }else{
                    $user->enabled = 1;
                    $user->email_verified_at = date('Y-m-d H:i:s');
                    $user->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.lock', compact('enabled', 'id'));
            }
        }
        die;
    }

}
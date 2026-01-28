<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller {

    public function __construct() {}
    
    public function index() {
        $types = Audit::select('auditable_type')->distinct()->get();

        return view('wpanel.logs.index', compact('types'));
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

        $type  = $_GET['type'];
        $event = $_GET['event'];
        $auditid = $_GET['auditid'];

        $records = [];
        $totalRecordswithFilter = 0;
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $totalRecordswithFilter = Audit::select('count(*) as allcount')
                ->search($searchValue);
            
            if($type != '') {
                $totalRecordswithFilter = $totalRecordswithFilter->where('auditable_type', '=', $type);
            }
            if($event != '') {
                $totalRecordswithFilter = $totalRecordswithFilter->where('event', '=', $event);
            }
            if($auditid != '') {
                $totalRecordswithFilter = $totalRecordswithFilter->where('auditable_id', '=', $auditid);
            }
            $totalRecordswithFilter = $totalRecordswithFilter->count();

            $records = Audit::orderBy($columnName, $columnSortOrder)
                ->search($searchValue)
                ->select('id', 'user_id', 'event', 'auditable_type', 'auditable_id', 'old_values', 'new_values', 'ip_address', 'tags', 'created_at')
                ->skip($start)
                ->take($rowperpage);
            
            if($type != '') {
                $records = $records->where('auditable_type', '=', $type);
            }
            if($event != '') {
                $records = $records->where('event', '=', $event);
            }
            if($auditid != '') {
                $records = $records->where('auditable_id', '=', $auditid);
            }
            $records = $records->get();
        }

        $result = array();
        foreach ($records as $row) {
            $author = json_decode($row->tags, true);

            $model = $row->auditable_type;
            $model = ($model != 'Login') ? $model::getModelName() : 'Login';

            $result[] = array(
                'id' => $row->id, 
                'user_id' => $row->user_id, 
                'event' => $row->event, 
                'auditable_type' => $model, 
                'auditable_id' => $row->auditable_id, 
                'ip_address' => $row->ip_address, 
                'author' => (isset($author['email'])) ? $author['email'] : '', 
                'created_at' => $row->created_at
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

        $audit = Audit::where('id', '=', $id)->first();

        $author = json_decode($audit->tags, true);
        $old_values = ($audit->old_values != '') ? json_decode($audit->old_values, true) : [];
        $new_values = ($audit->new_values != '') ? json_decode($audit->new_values, true) : [];

        $oldRegister = '';
        $newRegister = '';

        foreach ($old_values as $index => $value) {
            $oldRegister .= $index . ': ' . $value . '<br />';
        }
        foreach ($new_values as $index => $value) {
            $newRegister .= $index . ': ' . $value . '<br />';
        }

        $userid = (isset($author['id'])) ? $author['id'] : '';
        $name   = (isset($author['name'])) ? $author['name'] : '';
        $email  = (isset($author['email'])) ? $author['email'] : '';
        $module = (isset($author['guard'])) ? $author['guard'] : '';
        $url    = (isset($audit->url)) ? $audit->url : '';

        return response()->json(array('type' => '200', 
                                    'userid' => $userid, 
                                    'name' => $name, 
                                    'email' => $email, 
                                    'module' => $module,
                                    'url' => $url,
                                    'oldRegister' => $oldRegister,
                                    'newRegister' => $newRegister
                                ));
    }

}
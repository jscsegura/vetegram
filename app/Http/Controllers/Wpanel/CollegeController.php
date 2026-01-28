<?php

namespace App\Http\Controllers\Wpanel;

use App\Exports\CollegeFormatExcel;
use App\Http\Controllers\Controller;
use App\Imports\CollegeImport;
use App\Models\MedicalCollege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CollegeController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.college.index');
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
            $totalRecordswithFilter = MedicalCollege::select('count(*) as allcount')->search($searchValue)->count();

            $records = MedicalCollege::orderBy($columnName, $columnSortOrder)
                ->search($searchValue)
                ->select('id', 'code', 'name', 'dni', 'category')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }

        $result = array();
        foreach ($records as $row) {
            $result[] = array(
                'id' => $row->id,
                'code' => $row->code,
                'name' => $row->name,
                'dni' => $row->dni,
                'category' => $row->category
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
        return view('wpanel.college.create');
    }

    public function store(Request $request) {
        if ($request->file('file')) {

            $rows = null;
            $file = $request->file('file');
            if ($file) {
                try {
                    $import = new CollegeImport;

                    Excel::import($import, $file);
                    $rows = $import->getRows();
                } catch (\Exception $e) {}
            }

            if (count($rows) > 0) {

                if($request->action == 1) {
                    MedicalCollege::truncate();
                }

                for ($i = 0; $i < count($rows); $i++) {
                    $data = $rows[$i];

                    if($request->action == 0) {
                        MedicalCollege::updateOrCreate(
                            ['dni' => $data[0]],
                            [
                                'code' => $data[1],
                                'name' => $data[2],
                                'dni' => $data[0],
                                'category' => $data[3],
                                'enabled' => 1
                            ]
                        );
                    }else{
                        MedicalCollege::create([
                            'code' => $data[1],
                            'name' => $data[2],
                            'dni' => $data[0],
                            'category' => $data[3],
                            'enabled' => 1
                        ]);
                    }
                }

                session()->flash('success', 'Registros agregados correctamente!');
            }else{
                session()->flash('error', 'No se encontraron registros para agregar!');
            }
        }else{
            session()->flash('error', 'No se encontro el archivo a procesar!');
        }

        return redirect(route('wp.college.index'));
    }

    public function format() {
        return Excel::download(new CollegeFormatExcel(), 'Format.xlsx');
    }

}
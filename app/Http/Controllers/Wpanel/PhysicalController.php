<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\PhysicalCategory;
use App\Models\PhysicalOption;
use App\Models\PhysicalSuboption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhysicalController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.physical.index');
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
            $totalRecordswithFilter = PhysicalCategory::select('count(*) as allcount')->search($searchValue)->count();

            $records = PhysicalCategory::orderBy($columnName, $columnSortOrder)
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
        return view('wpanel.physical.create');
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
                            
            $category = new PhysicalCategory();
            $category->title_es = $request->title_es;
            $category->title_en = $request->title_en;
            $category->enabled = 1;
            $category->save();

            session()->flash('success', 'Categoria creada exitosamente!');

            return redirect(route('wp.physical.index'));
        }
        die;
    }

    public function edit($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $category = PhysicalCategory::where('id', '=', $id)->first();
            
            return view('wpanel.physical.edit', compact('category'));
        }
    }

    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $category = PhysicalCategory::where('id', '=', $id)->first();

            $category->title_es = $request->title_es;
            $category->title_en = $request->title_en;
            $category->update();
            
            session()->flash('success', 'Categoria actualizada exitosamente!');

            return redirect(route('wp.physical.index'));
        }
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $category = PhysicalCategory::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($category->id)) {
                if($category->enabled == 1) {
                    $category->enabled = 0;
                    $category->update();
                    $enabled = 0;
                }else{
                    $category->enabled = 1;
                    $category->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function delete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $category = PhysicalCategory::where('id', '=', $request->id)->first();

            $options = PhysicalOption::where('id_category', '=', $request->id)->get();

            foreach ($options as $option) {
                $suboptions = PhysicalSuboption::where('id_option', '=', $option->id)->get();
                $option->delete();

                foreach ($suboptions as $suboption) {
                    $suboption->delete();
                }
            }

            $category->delete();            
        }
        return response()->json(array('type' => '200'));
    }

    public function options(Request $request) {
        $categoryId = $request->category;

        return view('wpanel.physical.options', compact('categoryId'));
    }

    public function listOptions(Request $request) {
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

        $categoryId = $request->category;

        $records = [];
        $totalRecordswithFilter = 0;
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $totalRecordswithFilter = PhysicalOption::select('count(*) as allcount')->where('id_category', '=', $categoryId)->search($searchValue)->count();

            $records = PhysicalOption::orderBy($columnName, $columnSortOrder)
                ->search($searchValue)
                ->where('id_category', '=', $categoryId)
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

    public function createOptions(Request $request) {
        $categoryId = $request->category;

        return view('wpanel.physical.create-options', compact('categoryId'));
    }

    public function storeOptions(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $categoryId = $request->category;
                            
            $category = new PhysicalOption();
            $category->id_category = $categoryId;
            $category->title_es = $request->title_es;
            $category->title_en = $request->title_en;
            $category->type = $request->type;
            $category->enabled = 1;
            $category->save();

            session()->flash('success', 'Opción creada exitosamente!');

            return redirect(route('wp.physical.options', $categoryId));
        }
        die;
    }

    public function editOptions($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {        
            $option = PhysicalOption::where('id', '=', $id)->first();
            
            return view('wpanel.physical.edit-options', compact('option'));
        }
    }

    public function updateOptions(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $option = PhysicalOption::where('id', '=', $id)->first();

            $option->title_es = $request->title_es;
            $option->title_en = $request->title_en;
            $option->type = $request->type;
            $option->update();
            
            session()->flash('success', 'Opción actualizada exitosamente!');

            return redirect(route('wp.physical.options', $option->id_category));
        }
    }

    public function enabledOptions(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $option = PhysicalOption::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($option->id)) {
                if($option->enabled == 1) {
                    $option->enabled = 0;
                    $option->update();
                    $enabled = 0;
                }else{
                    $option->enabled = 1;
                    $option->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function deleteOptions(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $option = PhysicalOption::where('id', '=', $request->id)->first();

            $suboptions = PhysicalSuboption::where('id_option', '=', $option->id)->get();
            
            foreach ($suboptions as $suboption) {
                $suboption->delete();
            }

            $option->delete();      
        }
        return response()->json(array('type' => '200'));
    }

    public function suboptions(Request $request) {
        $optionId = $request->option;

        $option = PhysicalOption::where('id', '=', $optionId)->first();

        $optionIdCategory = $option->id_category;

        return view('wpanel.physical.suboptions', compact('optionId', 'optionIdCategory'));
    }

    public function listSuboptions(Request $request) {
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

        $optionId = $request->option;

        $records = [];
        $totalRecordswithFilter = 0;
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $totalRecordswithFilter = PhysicalSuboption::select('count(*) as allcount')->where('id_option', '=', $optionId)->search($searchValue)->count();

            $records = PhysicalSuboption::orderBy($columnName, $columnSortOrder)
                ->search($searchValue)
                ->where('id_option', '=', $optionId)
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

    public function createSuboptions(Request $request) {
        $optionId = $request->option;

        return view('wpanel.physical.create-suboptions', compact('optionId'));
    }

    public function storeSuboptions(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $optionId = $request->option;
                            
            $option = new PhysicalSuboption();
            $option->id_option = $optionId;
            $option->title_es = $request->title_es;
            $option->title_en = $request->title_en;
            $option->type = $request->type;
            $option->enabled = 1;
            $option->save();

            session()->flash('success', 'Opción creada exitosamente!');

            return redirect(route('wp.physical.Suboptions', $optionId));
        }
        die;
    }

    public function editSuboptions($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {        
            $option = PhysicalSuboption::where('id', '=', $id)->first();
            
            return view('wpanel.physical.edit-suboptions', compact('option'));
        }
    }

    public function updateSuboptions(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $option = PhysicalSuboption::where('id', '=', $id)->first();

            $option->title_es = $request->title_es;
            $option->title_en = $request->title_en;
            $option->type = $request->type;
            $option->update();
            
            session()->flash('success', 'Opción actualizada exitosamente!');

            return redirect(route('wp.physical.Suboptions', $option->id_option));
        }
    }

    public function enabledSuboptions(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $option = PhysicalSuboption::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($option->id)) {
                if($option->enabled == 1) {
                    $option->enabled = 0;
                    $option->update();
                    $enabled = 0;
                }else{
                    $option->enabled = 1;
                    $option->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function deleteSuboptions(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $suboption = PhysicalSuboption::where('id', '=', $request->id)->first();
            $suboption->delete();            
        }
        return response()->json(array('type' => '200'));
    }

}
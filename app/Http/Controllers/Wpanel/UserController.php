<?php

namespace App\Http\Controllers\Wpanel;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\RolMenu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function __construct() {}
    
    public function index() {
        return view('wpanel.user.index');
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
            $totalRecordswithFilter = User::select('count(*) as allcount')->search($searchValue)->where('rol_id', '=', 1)->count();

            $records = User::orderBy($columnName, $columnSortOrder)
                ->search($searchValue)
                ->select('id', 'name', 'lastname', 'email', 'enabled')
                ->where('rol_id', '=', 1)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }

        $result = array();
        foreach ($records as $row) {
            $result[] = array(
                'id' => $row->id,
                'name' => $row->name,
                'lastname' => $row->lastname,
                'email' => $row->email,
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
        $sections = Menu::select('id', 'title')->where('enabled', '=', 1)->orderBy('title', 'asc')->get();
        return view('wpanel.user.create', compact('sections'));
    }

    public function store(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            if($request->txtPassword == $request->txtPasswordConfirm) {
                $existEmail = User::where('email', '=', $request->email)->count();

                if($existEmail > 0) {
                    session()->flash('error', 'El correo ya se encuentra registrado');
                    return redirect()->back();
                }
                
                $user = new User();
                $user->name              = $request->name;
                $user->lastname          = $request->lastname;
                $user->email             = $request->email;
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->password          = Hash::make($request->txtPassword);
                $user->rol_id            = 1;
                $user->facebook          = 0;
                $user->google            = 0;
                $user->enabled           = 1;
                $user->save();

                $roles = $request->chkRole;
                if (is_array($roles)) {
                    foreach ($roles as $roleKey => $roleValue) {
                        $rol = new RolMenu();
                        $rol->id_user = $user->id;
                        $rol->id_menu = $roleValue;
                        $rol->save();
                    }
                }

                if(isset($request->photo)) {
                    $imageName = uniqid().time().'.'.$request->photo->extension();
                    if($request->photo->move(public_path('files/user/image'), $imageName)) {
                        $user->photo = $imageName;
                        $user->update();
                    }
                }

                session()->flash('success', 'Usuario creado exitosamente!');

                return redirect(route('wp.users.index'));
            }
        }
        die;
    }

    public function edit($id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $user = User::where('id', '=', $id)->first();
            $sections = Menu::select('id', 'title')->where('enabled', '=', 1)->orderBy('title', 'asc')->get();
            $rols = RolMenu::where('id_user', '=', $id)->pluck('id_menu')->toArray();

            return view('wpanel.user.edit', compact('user', 'sections', 'rols'));
        }
    }

    public function update(Request $request, $id) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $user = User::where('id', '=', $id)->first();

            $user->name     = $request->name;
            $user->lastname = $request->lastname;
        
            if(($request->txtPassword != '')&&($request->txtPassword == $request->txtPasswordConfirm)) {
                $user->password = Hash::make($request->txtPassword);
            }

            $user->update();

            RolMenu::where('id_user', '=', $id)->delete();
            $roles = $request->chkRole;
            if (is_array($roles)) {
                foreach ($roles as $roleKey => $roleValue) {
                    $rol = new RolMenu();
                    $rol->id_user = $user->id;
                    $rol->id_menu = $roleValue;
                    $rol->save();
                }
            }

            if(isset($request->photo)) {
                $imageName = uniqid().time().'.'.$request->photo->extension();
                if($request->photo->move(public_path('files/user/image'), $imageName)) {
                    $user->photo = $imageName;
                    $user->update();
                }
            }

            session()->flash('success', 'Usuario actualizado exitosamente!');

            return redirect(route('wp.users.index'));
        }
    }

    public function enabled(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $id = $request->id;

            $user = User::select('id', 'enabled')->where('id', '=', $id)->first();

            $enabled = 0;
            if(isset($user->id)) {
                if($user->enabled == 1) {
                    $user->enabled = 0;
                    $user->update();
                    $enabled = 0;
                }else{
                    $user->enabled = 1;
                    $user->update();
                    $enabled = 1;
                }

                return view('wpanel.generic.enabled', compact('enabled', 'id'));
            }
        }
        die;
    }

    public function delete(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $user = User::select('id', 'photo')->where('id', '=', $request->id)->first();

            if($user->photo != '') {
                if (file_exists(public_path('files/user/image/' . $user->photo))) {
                    @unlink(public_path('files/user/image/' . $user->photo));
                }
            }

            RolMenu::where('id_user', '=', $request->id)->delete();
            User::where('id', '=', $request->id)->forceDelete();
        }
        return response()->json(array('type' => '200'));
    }

    public function deletefile(Request $request) {
        if (Auth::guard('admin')->user()->rol_id == 1) {
            $user = User::select('id', 'photo')->where('id', '=', $request->id)->first();

            if($user->photo != '') {
                if (file_exists(public_path('files/user/image/' . $user->photo))) {
                    @unlink(public_path('files/user/image/' . $user->photo));
                }
            }

            $user->photo = '';
            $user->update();
        }
        return view('wpanel.generic.photo');
    }

}
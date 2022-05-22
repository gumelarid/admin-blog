<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\NavModel;
use App\Models\RoleModel;
use App\Models\SettingModel;
use App\Models\UserAccessModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('access.menu');
    }
    
    public function index(){
        $title = 'Role';


        $data = RoleModel::all();
        $setting = SettingModel::first();
        return view('dashboard.role.index', compact('title','data','setting'));
    }

    public function store(Request $request){
        $valid = Validator::make($request->all(),[
            'role_name' => 'required|unique:user_role,role'
        ]);

        if ($valid->fails()) {
            return redirect('dashboard/role')->withErrors($valid)->withInput();
        };

        RoleModel::create([
            'role' => $request->role_name
        ]);

        $notification = array(
            'message' => 'Success Add New Role',
            'alert-type' => 'success'
        );

        return Redirect::to('dashboard/role')->with($notification);
    }

    public function update(Request $request,$id = null){
        if ($id !== null) {
            $check = RoleModel::where('role_id', $id);

            if(count($check->get()) <= 0){
                $notification = array(
                    'message' => 'Oops role not found',
                    'alert-type' => 'warning'
                );
        
                return Redirect::to('dashboard/role')->with($notification);
            };

            $valid = Validator::make($request->all(),[
                'role_name' => 'required|unique:user_role,role'
            ]);
    
            if ($valid->fails()) {
                return redirect('dashboard/role')->withErrors($valid)->withInput();
            };

            $check->update([
                'role' => $request->role_name
            ]);

            $notification = array(
                'message' => 'Success Update Role',
                'alert-type' => 'success'
            );
    
            return Redirect::to('dashboard/role')->with($notification);
        };

        return Redirect::to('dashboard/role');
    }

    public function destroy($id = null){

        if ($id !== null) {
            $check = RoleModel::where('role_id', $id);

            if (count($check->get()) <= 0) {
                $notification = array(
                    'message' => 'Oopps Role not found',
                    'alert-type' => 'warning'
                );
                
                return Redirect::to('/dashboard/role')->with($notification);
            };

            $availableUser = User::where('role_id', $id);
            if (count($availableUser->get()) >= 1) {
                $notification = array(
                    'message' => 'Oopps Role has been taken, please change role in user first',
                    'alert-type' => 'warning'
                );
                
                return Redirect::to('/dashboard/role')->with($notification);
            };

            $check->delete();
            $notification = array(
                'message' => 'Success Delete Role',
                'alert-type' => 'success'
            );
            
            return Redirect::to('/dashboard/role')->with($notification);

        };

        return Redirect::to('/dashboard/role');
    }


    // access
    public function access(Request $request){
        
        $role = RoleModel::where('role_id', $request->query('role'))->first();
        if (!$role) {
            $notification = array(
                'message' => 'Oopps Role not found',
                'alert-type' => 'warning'
            );
            
            return Redirect::to('/dashboard/role')->with($notification);
        };

        $title = 'User Access : '.$role->role;
        $nav = NavModel::where('is_active', '1')->get();
        return view('dashboard.access.index', compact('title','role','nav'));
    }

    public function checked(Request $request){
        $checkAccess = UserAccessModel::where('nav_id', $request->nav)
                                    ->where('role_id', $request->role)
                                    ->first();
        if (!$checkAccess) {
            UserAccessModel::create([
                'access_id' => Str::uuid(),
                'role_id'   => $request->role,
                'nav_id'    => $request->nav
            ]);

            $notification = array(
                'message' => 'Access '.$request->name.' Enable',
                'alert' => 'success'
            );
            
            return $notification;
        }else{
            UserAccessModel::where('nav_id', $request->nav)
                                    ->where('role_id', $request->role)
                                    ->delete();
            
            $notification = array(
                'message' => 'Access '.$request->name.' Disabled',
                'alert' => 'warning'
            );
                                    
            return $notification;
        }
    }
}

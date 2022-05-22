<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('access.menu');
    }
    
    private function _validasi($data){
        if ($data->fails()) {
           
            return redirect('/dashboard/user')
                        ->withErrors($data)
                        ->withInput();
        };

    }

    public function index(){
        $title = "User List";
        $data = User::get();
        $role = RoleModel::all();
        return view('dashboard.user.index', compact('title','data','role'));
    }

    public function store(Request $request){
        $valid = Validator::make($request->all(),[
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required|min:8',
            'role'      => 'required',
        ]);

        if ($valid->fails()) {
            return redirect('/dashboard/user')
                        ->withErrors($valid)
                        ->withInput();
        };

        User::create([
            'user_id'       => Str::uuid(),
            'user_name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'        => 1,
            'role_id'          => $request->role,
            'profile'       => 'default.png'
        ]);

        $notification = array(
            'message' => 'Success Add User',
            'alert-type' => 'success'
        );
        
        return Redirect::to('/dashboard/user')->with($notification);
    }

    public function change(Request $request){
        $check = User::where('user_id', $request->query('user'));

        if (count($check->get()) <= 0) {
            $notification = array(
                'message' => 'Oopps user not found',
                'alert-type' => 'warning'
            );
            
            return Redirect::to('/dashboard/user')->with($notification);
        };

        $check->update([
            'status' => $request->query('status') == 1 ? 0 : 1
        ]);

        $notification = array(
            'message'       => 'Success update status user',
            'alert-type'    => 'success'
        );

        return Redirect::to('/dashboard/user')->with($notification);
    }

    public function update(Request $request, $id = null){
        if ($id !== null) {
    
            $check = User::where('user_id', $id);

            if (count($check->get()) <= 0) {
                $notification = array(
                    'message' => 'Oopps user not found',
                    'alert-type' => 'warning'
                );
                
                return Redirect::to('/dashboard/user')->with($notification);
            };

            if ($request->password == null) {
                $valid = Validator::make($request->all(),[
                    'name'      => 'required',
                    'role'      => 'required',
                ]);

                if ($valid->fails()) {
                    return redirect('/dashboard/user')
                                ->withErrors($valid)
                                ->withInput();
                };

                $check->update([
                    'user_name'     => $request->name,
                    'role_id'     => $request->role
                ]);
            }else{
                $valid = Validator::make($request->all(),[
                    'name'      => 'required',
                    'password'  => 'required|min:8',
                    'role'      => 'required',
                ]);

                if ($valid->fails()) {
                    return redirect('/dashboard/user')
                                ->withErrors($valid)
                                ->withInput();
                };

                $check->update([
                    'user_name'     => $request->name,
                    'password' => Hash::make($request->password),
                    'role_id'     => $request->role
                ]);
            }

           
    
            $notification = array(
                'message'       => 'Success update user',
                'alert-type'    => 'success'
            );
    
            return Redirect::to('/dashboard/user')->with($notification);
            

        };
        return Redirect::to('/dashboard/user');
    }

    public function destroy($id = null){

        if ($id !== null) {
            $check = User::where('user_id', $id);

            if (count($check->get()) <= 0) {
                $notification = array(
                    'message' => 'Oopps user not found',
                    'alert-type' => 'warning'
                );
                
                return Redirect::to('/dashboard/user')->with($notification);
            };

            $check->delete();
            $notification = array(
                'message' => 'Success Delete User',
                'alert-type' => 'success'
            );
            
            return Redirect::to('/dashboard/user')->with($notification);

        };

        return Redirect::to('/dashboard/user');
    }
}

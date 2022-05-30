<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function __construct(){
        $this->middleware('access.menu');
    }

    private function _upload($file){
        $name_file = time()."_".$file->getClientOriginalName();
        $dir = 'assets/profile/';
        $file->move($dir,$name_file);

        return $name_file;
    }

    public function index(){
        $title = 'My Profile';
        $profile = User::where('user_id', Auth::user()->user_id)->first();
        $detail = UserDetailModel::where('user_id', Auth::user()->user_id)->first();
        return view('dashboard.profile.index', compact('title', 'profile', 'detail'));
    }

    public function update(Request $request){
        
        $check = User::where('user_id', $request->id)->first();

        if (!$check) {
            $notification = array(
                'message' => 'Oopps user not found',
                'alert-type' => 'warning'
            );
            
            return Redirect::to('/dashboard/profile')->with($notification);
        };

        if($request->password !== null){
            $valid = Validator($request->all(),[
                'profile'   => 'file|image|mimes:jpeg,png,jpg|max:1048',
                'name'      => 'required',
                'password'  => 'min:8'
            ]);

            $password = Hash::make($request->password);
        }else{
            $valid = Validator($request->all(),[
                'profile'   => 'file|image|mimes:jpeg,png,jpg|max:1048',
                'name'      => 'required',
            ]);

            $password = $check->password;
        }


        if ($valid->fails()) {
            return redirect('/dashboard/profile')->withErrors($valid)->withInput();
        }

        if ($request->file()) {
            $file = $request->file('profile');
            if ($check->profile !== 'default.png') {
                File::delete('assets/profile/'. $check->profile);
            }

            $profile = $this->_upload($file);
        }else{
            $profile = $check->profile;
        }

        $check->update([
            'user_name'   => $request->name,
            'password'    => $request->password !== null ?  $password : $password,
            'profile'     => $request->file() ? $profile : $profile
        ]);

        $detail = UserDetailModel::where('user_id', $request->id)->update([
            'detail'   => $request->detail,
        ]);
        
        $notification = array(
            'message'       => 'Success update Profile',
            'alert-type'    => 'success'
        );

        return Redirect::to('/dashboard/profile')->with($notification);
    }


    public function reset(Request $request)
    {
        $check = User::where('user_id', $request->query('id'))->first();

        if (!$check) {
            $notification = array(
                'message' => 'Oopps user not found',
                'alert-type' => 'warning'
            );
            
            return Redirect::to('/dashboard/profile')->with($notification);
        };

        if ($check->profile !== 'default.png') {
            File::delete('assets/profile/'. $check->profile);
            $check->update([
                'profile'     => 'default.png'
            ]);
        };

        $notification = array(
            'message'       => 'Success Reset Profile',
            'alert-type'    => 'success'
        );

        return Redirect::to('/dashboard/profile')->with($notification);
    }
}

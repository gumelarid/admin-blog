<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(){
        $title = 'Wellcome To World';
       
        if (Auth::check()) {
            
            $notification = array(
                'message'   => 'Wellcome back '.Auth::user()->user_name,
                'alert-type'=> 'info'
            );

            return Redirect::to('/dashboard')->with($notification);
        };

        return view('dashboard.auth.login', compact('title'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        };

       

        $check = User::where('email', $request->email);
       
        if (!$check->first()) {
            return redirect('/')->withErrors('Opp You Are Not Registered !');
        };

        $status = $check->where('status', 1);
       
        if (!$status->first()) {
            return redirect('/')->withErrors('Opp Your account disabled, please contact your admin !');
        };
       
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            $notification = array(
                'message'   => 'Wellcome back '.Auth::user()->user_name,
                'alert-type'=> 'info'
            );

            return Redirect::to('/dashboard')->with($notification);
        }else{
            return redirect('/')->withErrors('Opp Wrong Paaword !');
        }
    }

    public function logout()
    {
        Auth::logout(); 
        return redirect('/')->withErrors('You Logout Now !');
    }
}

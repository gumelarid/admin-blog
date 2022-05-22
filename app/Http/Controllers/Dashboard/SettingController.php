<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('access.menu');
    }

    private function _upload($file){
        $name_file = time()."_".$file->getClientOriginalName();
        $dir = 'assets/logo/';
        $file->move($dir,$name_file);

        return $name_file;
    }

    public function index(){
        $title = 'Settings';
        $setting = SettingModel::get();
        return view('dashboard.settings.index', compact('title','setting'));
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'logo'   => 'file|image|mimes:jpeg,png,jpg|max:1048',
            'title'  => 'required',
            'description'   => 'required',
        ]);

        if ($valid->fails()) {
            return redirect('/dashboard/setting')->withErrors($valid)->withInput();
        };

        $check = SettingModel::where('id_setting', $request->id_setting);
        if ($check->first()) {

            if ($request->is_developer !== 'on') {
                $check->update([
                    'is_developer'      => 0,
                ]);
            }else{
                $check->update([
                    'is_developer'      => 1,
                ]);
            };

            if ($request->is_logo !== 'on') {
                $check->update([
                    'is_logo'      => 0,
                ]);
            }else{
                $check->update([
                    'is_logo'      => 1,
                ]);
            };

            if ($request->file()) {
                $file = $request->file('logo');
                $lg = $check->first();
                if ($lg->logo !== 'logo_default.png') {
                    File::delete('assets/logo/'. $lg->logo);
                }
    
                $logo = $this->_upload($file);
            }else{
                $lg = $check->first();
                $logo = $lg->logo;
            }

            $check->update([
                'webname'           => $request->title,
                'logo'              => $request->file() ? $logo : $logo,
                'description'       => $request->description,
                'meta_description'  => $request->meta
            ]);


            $notification = array(
                'message' => 'Success Update Setting',
                'alert-type' => 'success'
            );
            
            return Redirect::to('/dashboard/setting')->with($notification);

        };

        return redirect('/dashboard/setting');
        
    }
}

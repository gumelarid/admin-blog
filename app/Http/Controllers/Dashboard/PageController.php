<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('access.menu');
    }
    
    public function index()
    {
        $title = 'List Page';

        $data = PageModel::all();

        return view('dashboard.page.index', compact('title', 'data'));
    }

    public function add()
    {
        $title = 'Add Page';

        return view('dashboard.page.add', compact('title'));
    }

    public function store(Request $request)
    {
      
        $valid = Validator($request->all(),[
            'title'      => 'required',
        ]);

        if ($valid->fails()) {
            return redirect('/dashboard/page/add')->withErrors($valid)->withInput();
        };

        PageModel::create([
            'page_id'        => Str::uuid(),
            'slug_page'      => Str::slug($request->title),
            'title_page'     => $request->title,
            'description'    => (isset($request->description)) ? $request->description : '',
        ]);

        $notification = array(
            'message'       => 'Success Add Page',
            'alert-type'    => 'success'
        );

        return Redirect::to('/dashboard/page')->with($notification);
    }

    public function edit($id)
    {
        $title = 'Edit Page';
        $data = PageModel::where('page_id', $id)->first();

        if (!$data) {
            return redirect('/dashboard/page')->with('warning','Page Not Found');
        };

        return view('dashboard.page.edit', compact('title', 'data'));
    }

    public function update(Request $request)
    {
        $valid = Validator($request->all(),[
            'title'      => 'required',
        ]);

        if ($valid->fails()) {
            return redirect('/dashboard/page/add')->withErrors($valid)->withInput();
        };

        $check = PageModel::where('page_id', $request->id);

        if (!$check->first()) {
            return redirect('/dashboard/page')->with('warning','Page Not Found');
        };


        $check->update([
            'slug_page'      => Str::slug($request->title),
            'title_page'     => $request->title,
            'description'    => (isset($request->description)) ? $request->description : '',
        ]);

        $notification = array(
            'message'       => 'Success Update Page',
            'alert-type'    => 'success'
        );

        return Redirect::to('/dashboard/page')->with($notification);
    }

    public function destroy($id){
        $check = PageModel::where('page_id', $id);

        if ($check->first()) {
            $check->delete();

            $notification = array(
                'message'       => 'Success Delete Page',
                'alert-type'    => 'success'
            );
    
            return Redirect::to('/dashboard/page')->with($notification);
        };

        return redirect('/dashboard/page')->with('warning','Data Not Found');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ArticleModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    public function __construct()
    {
        $this->middleware('access.menu');
    }
    
    private function _upload($file){
        $name_file = time()."_".$file->getClientOriginalName();
        $dir = 'assets/article/';
        $file->move($dir,$name_file);

        return $name_file;
    }

    public function index()
    {
        $title = 'List Article';

        $data = ArticleModel::all();

        return view('dashboard.article.index', compact('title', 'data'));
    }

    public function add()
    {
        $title = 'Add Article';

        $category = CategoryModel::all();

        return view('dashboard.article.add', compact('title', 'category'));
    }

    public function store(Request $request)
    {
      
        $valid = Validator($request->all(),[
            'thumb'   => 'file|image|mimes:jpeg,png,jpg|max:1048',
            'title'      => 'required',
            'category'  => 'required'
        ]);

        if ($valid->fails()) {
            return redirect('/dashboard/article/add')->withErrors($valid)->withInput();
        };


        ArticleModel::create([
            'article_id'        => Str::uuid(),
            'slug_article'      => Str::slug($request->title),
            'title_article'     => $request->title,
            'category_id'       => $request->category,
            'user_id'           => Auth::user()->user_id,
            'meta_description'  => (isset($request->meta)) ? $request->meta : '',
            'description'       => (isset($request->description)) ? $request->description : '',
            'status'            => (isset($request->is_publish)) ? 1 : 0,
            'thumbnail'         => ($request->file('thumb') !== null ) ? $this->_upload($request->file('thumb')) : null,
            'views' => 0
        ]);

        $notification = array(
            'message'       => 'Success Add Article',
            'alert-type'    => 'success'
        );

        return Redirect::to('/dashboard/article')->with($notification);
    }

    public function edit($id)
    {
        $title = 'Edit Article';
        $data = ArticleModel::where('article_id', $id)->first();

        if (!$data) {
            return redirect('/dashboard/article')->with('warning','Article Not Found');
        };
        
        $category = CategoryModel::all();

        return view('dashboard.article.edit', compact('title', 'category', 'data'));
    }

    public function update(Request $request)
    {
        $valid = Validator($request->all(),[
            'thumb'   => 'file|image|mimes:jpeg,png,jpg|max:1048',
            'title'      => 'required',
            'category'  => 'required'
        ]);

        if ($valid->fails()) {
            return redirect('/dashboard/article/edit/'.$request->id)->withErrors($valid)->withInput();
        };

        $check = ArticleModel::where('article_id', $request->id);

        if (!$check->first()) {
            return redirect('/dashboard/article')->with('warning','Article Not Found');
        };

        if ($request->file('thumb')) {
            $th = $check->first();
            if ($th->thumbnail !== null) {
                File::delete('assets/article/'. $th->thumbnail);
            };
            $thumbnail = $this->_upload($request->file('thumb'));
        }

        $check->update([
            'slug_article'      => Str::slug($request->title),
            'title_article'     => $request->title,
            'category_id'       => $request->category,
            'meta_description'  => (isset($request->meta)) ? $request->meta : '',
            'description'       => (isset($request->description)) ? $request->description : '',
            'status'            => ($request->is_publish == 'on') ? 1 : 0,
            'thumbnail'         => (isset($thumbnail)) ? $thumbnail : null,
            'views' => 0
        ]);

        $notification = array(
            'message'       => 'Success Update Article',
            'alert-type'    => 'success'
        );

        return Redirect::to('/dashboard/article')->with($notification);
    }

    public function destroy($id){
        $check = ArticleModel::where('article_id', $id);

        if ($check->first()) {
            $check->delete();
            return redirect('/dashboard/article')->with('success','Delete Article Success');
        };

        return redirect('/dashboard/article')->with('warning','Data Not Found');
    }
}

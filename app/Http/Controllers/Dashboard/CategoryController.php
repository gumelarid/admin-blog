<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ArticleModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('access.menu');
    }
    
    public function index()
    {
       $title = 'List Category';
       $data = CategoryModel::all();

       return view('dashboard.category.index', compact('title','data'));
    }

    public function store(Request $request){
        $valid = Validator::make($request->all(),[
            'category'  => 'required|unique:category,category',
        ]);

        if ($valid->fails()) {
            return redirect('/dashboard/category')->withErrors($valid)->withInput();
        };

        CategoryModel::create([
            'category_id'    => Str::uuid(),
            'category' => $request->category,
            'slug_category' => Str::slug($request->category)
        ]);


        $notification = array(
            'message'       => 'Success Add Category',
            'alert-type'    => 'success'
        );

        return Redirect::to('/dashboard/category')->with($notification);
    }

    public function update(Request $request, $id = null)
    {
        $valid = Validator::make($request->all(),[
            'category' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect('/dashboard/category')
                        ->withErrors($valid)
                        ->withInput();
        };


        $check = CategoryModel::where('category_id',$id);
        if (!$check->first()) {
            $notification = array(
                'message'       => 'Category not found',
                'alert-type'    => 'warning'
            );
    
            return Redirect::to('/dashboard/category')->with($notification);
        };

       

        $check->update([
            'category' => $request->category,
            'slug_category' => Str::slug($request->category)
        ]);

        $notification = array(
            'message'       => 'Success Update Category',
            'alert-type'    => 'success'
        );

        return Redirect::to('/dashboard/category')->with($notification);
    }

    public function destroy($id = null)
    {

        $category = CategoryModel::where('category_id', $id);
        if (!$category->first()) {
            $notification = array(
                'message'       => 'Category not found',
                'alert-type'    => 'warning'
            );
    
            return Redirect::to('/dashboard/category')->with($notification);
        };

        $check = ArticleModel::where('category_id', $id)->first();
        if ($check) {
            $notification = array(
                'message'       => 'Opps, Category Has been Taken in article',
                'alert-type'    => 'warning'
            );
    
            return Redirect::to('/dashboard/category')->with($notification);
        };

        $category->delete();

        $notification = array(
            'message'       => 'Success Delete Category',
            'alert-type'    => 'success'
        );

        return Redirect::to('/dashboard/category')->with($notification);
    }
}

<?php

use App\Http\Controllers\Dashboard\ArticleController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\NavController;
use App\Http\Controllers\Dashboard\PageController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserAccessController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\SettingController;
use Illuminate\Support\Facades\Route;
use PhpParser\NodeVisitor\NameResolver;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth'], function(){
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index']);

    // role
    Route::get('/dashboard/role', [RoleController::class, 'index']);
    Route::post('/dashboard/role/add', [RoleController::class, 'store']);
    Route::post('/dashboard/role/edit/{id}', [RoleController::class, 'update']);
    Route::get('/dashboard/role/delete/{id}', [RoleController::class, 'destroy']);
    Route::get('/dashboard/role/access', [RoleController::class, 'access']);
    Route::post('/dashboard/role/access/checked', [RoleController::class, 'checked']);


    // My Profile
    Route::get('/dashboard/profile', [ProfileController::class,'index']);
    Route::post('/dashboard/profile/update', [ProfileController::class,'update']);
    Route::get('/dashboard/profile/reset', [ProfileController::class,'reset']);

    // Users
    Route::get('/dashboard/user', [UserController::class, 'index']);
    Route::post('/dashboard/user/add', [UserController::class, 'store']);
    Route::get('/dashboard/user/status', [UserController::class, 'change']);
    Route::post('/dashboard/user/edit/{id}', [UserController::class, 'update']);
    Route::get('/dashboard/user/delete/{id}', [UserController::class, 'destroy']);


    // Navigation 
    Route::get('/dashboard/navigation', [NavController::class,'index']);
    Route::post('/dashboard/navigation/add', [NavController::class, 'store']);
    Route::get('/dashboard/navigation/status', [NavController::class, 'change']);
    Route::post('/dashboard/navigation/edit/{id}', [NavController::class, 'update']);
    Route::get('/dashboard/navigation/delete/{id}', [NavController::class, 'destroy']);


    // setting
    Route::get('/dashboard/setting', [SettingController::class, 'index']);
    Route::post('/dashboard/setting/save', [SettingController::class, 'store']);


    Route::get('logout', [AuthController::class, 'logout']);



    // category
    Route::get('/dashboard/category', [CategoryController::class,'index']);
    Route::post('/dashboard/category/add', [CategoryController::class, 'store']);
    Route::post('/dashboard/category/edit/{id}', [CategoryController::class, 'update']);
    Route::get('/dashboard/category/delete/{id}', [CategoryController::class, 'destroy']);



    // article
    Route::get('/dashboard/article', [ArticleController::class,'index']);
    Route::get('/dashboard/article/add', [ArticleController::class, 'add']);
    Route::post('/dashboard/article/save', [ArticleController::class, 'store']);
    Route::get('/dashboard/article/edit/{id}', [ArticleController::class, 'edit']);
    Route::post('/dashboard/article/update', [ArticleController::class, 'update']);
    Route::get('/dashboard/article/delete/{id}', [ArticleController::class, 'destroy']);

    // page
    Route::get('/dashboard/page', [PageController::class,'index']);
    Route::get('/dashboard/page/add', [PageController::class, 'add']);
    Route::post('/dashboard/page/save', [PageController::class, 'store']);
    Route::get('/dashboard/page/edit/{id}', [PageController::class, 'edit']);
    Route::post('/dashboard/page/update', [PageController::class, 'update']);
    Route::get('/dashboard/page/delete/{id}', [PageController::class, 'destroy']);


    // error
    Route::get('/dashboard/error', function(){
        $title = 'Opss, Page Not Found';
        return view('dashboard.error',compact('title'));
    });
});
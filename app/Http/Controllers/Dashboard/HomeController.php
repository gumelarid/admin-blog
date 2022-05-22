<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $title = 'Dashboard';
        return view('dashboard/home', compact('title'));
    }
}

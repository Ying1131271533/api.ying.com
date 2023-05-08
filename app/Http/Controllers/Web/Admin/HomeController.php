<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * 后台首页
     */
    public function index()
    {
        return view('admin.home.index');
    }

    /**
     * welcome
     */
    public function welcome()
    {
        return view('admin.home.welcome');
    }
}

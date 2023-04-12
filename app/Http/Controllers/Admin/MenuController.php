<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class MenuController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        if($type == 'all') return cache_menus_all();
        return cache_menus();
    }
}

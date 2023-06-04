<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * 列表
     */
    public function index()
    {
        return view('admin.brand.index');
    }

    /**
     * 添加
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * 修改
     */
    public function edit()
    {
        return view('admin.brand.edit');
    }
}

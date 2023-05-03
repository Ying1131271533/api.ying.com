<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class CitieController extends BaseController
{
    /**
     * 省市县数据
     */
    public function index(Request $request)
    {
        $parent_code = $request->query('parent_code', '000000');
        return cities_cache($parent_code);
    }
}

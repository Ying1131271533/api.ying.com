<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\UrlGenerator;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        echo '阿卡丽';
    }

    public function name()
    {
        // $url = app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('test.name');
       $url = app(UrlGenerator::class)->version('v1')->route('test.name');
       dd($url);
    }
}

<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Express extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Express';
    }
}

<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PublicService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PublicService';
    }
}

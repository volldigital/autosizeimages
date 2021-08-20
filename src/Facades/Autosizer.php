<?php

namespace VOLLdigital\Autosizeimages\Facades;

use Illuminate\Support\Facades\Facade;

class Autosizer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'autosizer';
    }
}

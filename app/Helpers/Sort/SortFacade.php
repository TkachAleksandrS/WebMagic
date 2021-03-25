<?php

namespace App\Helpers\Sort;

use Illuminate\Support\Facades\Facade;

class SortFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'sort';
    }
}

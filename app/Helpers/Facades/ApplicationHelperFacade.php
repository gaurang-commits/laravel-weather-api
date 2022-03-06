<?php
namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

class ApplicationHelperFacade extends Facade 
{
    /**
     * |--------------------------------
     * | Application Helper Facade
     * |--------------------------------
     * | Facade class to be called whenever the class Application Helper is called
     * |
     */

    /**
     * 
     */

    protected static function getFacadeAccessor()
    {
        return 'App\Helpers\ApplicationHelper';
    }
}
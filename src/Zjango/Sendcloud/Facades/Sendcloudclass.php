<?php
/**
 */
namespace Zjango\Sendcloud\Facades;

use Illuminate\Support\Facades\Facade;

class  SendcloudClass extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sendcloud';
    }
}
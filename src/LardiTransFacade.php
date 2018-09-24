<?php
/**
 * Created by PhpStorm.
 * User: mammut
 * Date: 24.09.18
 * Time: 17:13
 */

namespace MammutAlex\LardiTransLaravel;

use Illuminate\Support\Facades\Facade;

class LardiTransFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return LardiTrans::class;
    }
}
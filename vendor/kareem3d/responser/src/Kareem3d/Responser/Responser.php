<?php namespace Kareem3d\Responser;

use Illuminate\Support\Facades\Facade;

class Responser extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor() { return 'Kareem3d\Responser\Response'; }
}
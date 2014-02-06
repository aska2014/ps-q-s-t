<?php

use Illuminate\Support\Facades\URL as LaravelURL;

class URL extends LaravelURL {

    /**
     * @param $path
     * @return mixed
     */
    public static function lib($path)
    {
        return static::asset('app/lib/' . ltrim($path, '/'));
    }

}
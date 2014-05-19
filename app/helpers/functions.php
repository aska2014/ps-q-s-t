<?php

if(! function_exists('random_identifier'))
{
    /**
     * Generate random string
     *
     * @param $length
     * @return string
     */
    function random_identifier($length)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return strtoupper($key);
    }
}
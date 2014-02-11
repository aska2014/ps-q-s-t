<?php namespace Kareem3d\Helper;

class EmptyClass {

    /**
     * @param $property
     * @return $this
     */
    public function __get( $property )
    {
        return $this;
    }

    /**
     * @param $property
     * @param $value
     */
    public function __set( $property, $value )
    {

    }

    /**
     * @param $method
     * @param $arguments
     * @return $this
     */
    public function __call( $method, $arguments )
    {
        return $this;
    }

    /**
     * @param $method
     * @param $arguments
     * @return static
     */
    public static function __callStatic( $method, $arguments )
    {
        return new static;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '';
    }
}
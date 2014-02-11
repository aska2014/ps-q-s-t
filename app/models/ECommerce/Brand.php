<?php namespace ECommerce;

class Brand extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'brands';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Defining relations
     */
    public function products(){ return $this->hasMany(Product::getClass()); }

    public function orders(){ return $this->hasManyThrough(Order::getClass(), Product::getClass());}
    /*************************************************************************************/

}
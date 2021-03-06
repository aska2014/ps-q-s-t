<?php namespace Location;

use ECommerce\Order;

class City extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'cities';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $with = array('country');

    /**
     * Defining relations
     */
    public function country(){ return $this->belongsTo(Country::getClass());}
    public function orders(){ return $this->hasMany(Order::getClass()); }

}
<?php namespace Location;

use ECommerce\Order;

class Location extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'locations';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $with = array('city');

    /**
     * Defining relations
     */
    public function orders(){ return $this->hasMany(Order::getClass()); }

    public function city(){ return $this->belongsTo(City::getClass()); }

}
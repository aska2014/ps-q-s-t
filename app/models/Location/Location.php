<?php namespace Location;

use ECommerce\Order;
use Kareem3d\Membership\Account;

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
     * @return mixed|void
     */
    public function beforeValidate()
    {
        $this->cleanXSS();
    }

    /**
     * Defining relations
     */
    public function orders(){ return $this->hasMany(Order::getClass()); }

    public function account(){ return $this->hasOne(Account::getClass(), 'shipping_location_id'); }

    public function city(){ return $this->belongsTo(City::getClass()); }

}
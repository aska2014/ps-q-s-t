<?php namespace ECommerce;

use Kareem3d\Membership\UserInfo;
use Location\Location;
use Units\Price;

class Order extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @param UserInfo $userInfo
     * @param Location $location
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function createFrom(UserInfo $userInfo, Location $location)
    {
        return static::create(array(
            'user_info_id' => $userInfo->id,
            'location_id' => $location->id
        ));
    }

    /**
     * @param Product $product
     * @param $quantity
     * @return void
     */
    public function addProduct(Product $product, $quantity)
    {
        $this->products()->attach($product, array(
            'quantity' => $quantity
        ));
    }

    /**
     * @param Product $product
     * @param $quantity
     */
    public function addGift(Product $product, $quantity)
    {
        $this->gifts()->attach($product, array(
            'quantity' => $quantity
        ));
    }

    /**
     * @param $objects
     */
    public function addProducts($objects)
    {
        foreach($objects as $object)
        {
            $this->addProduct($object->product, $object->quantity);
        }
    }

    /**
     * @param $objects
     */
    public function addGifts($objects)
    {
        foreach($objects as $object)
        {
            $this->addProduct($object->product, $object->quantity);
        }
    }

    /**
     * @param UserInfo $userInfo
     */
    public function setUserInfo(UserInfo $userInfo)
    {
        $this->userInfo()->associate($userInfo);
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location)
    {
        $this->location()->associate($location);
    }

    /**
     * Defining relations
     */
    public function location(){ return $this->belongsTo(Location::getClass());}
    public function userInfo(){ return $this->belongsTo(UserInfo::getClass());}

    public function gifts(){ return $this->belongsToMany(Product::getClass(), 'gift_order'); }
    public function products(){ return $this->belongsToMany(Product::getClass(), 'product_order'); }

}
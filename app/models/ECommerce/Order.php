<?php namespace ECommerce;

use Cart\Cart;
use Cart\Item;
use Kareem3d\Membership\Account;
use Kareem3d\Membership\UserInfo;
use Location\Location;
use Units\Currency;
use Units\Price;

class Order extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var bool
     */
    protected $softDelete = true;

    /**
     * @return mixed
     */
    public function getCurrencyAttribute()
    {
        return $this->attributes['currency'] ?: 'QAR';
    }

    /**
     * @param UserInfo $userInfo
     * @param Location $location
     * @param Cart $cart
     * @param Currency $currency
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function createFrom(UserInfo $userInfo, Location $location, Cart $cart, Currency $currency)
    {
        /**
         * @param Order $order
         */
        $order = static::create(array(
            'user_info_id' => $userInfo->id,
            'location_id' => $location->id,
            // Round to the nearest two values
            'price' => $cart->getTotalPrice()->value(),
            'currency' => $currency->__toString()
        ));

        $order->addProducts($cart->getItems());
        $order->addGifts($cart->getGifts());

        return $order;
    }

    /**
     * @param Product $product
     * @param $quantity
     * @param $price
     * @return void
     */
    public function addProduct(Product $product, $quantity, $price)
    {
        if($price instanceof Price) $price = $price->value();

        $this->products()->attach($product, compact('quantity', 'price'));
    }

    /**
     * @param Product $product
     * @param $quantity
     */
    public function addGift(Product $product, $quantity)
    {
        $this->gifts()->attach($product, compact('quantity'));
    }

    /**
     * @param Item[] $objects
     */
    public function addProducts($objects)
    {
        foreach($objects as $object)
        {
            $this->addProduct($object->getProduct(), $object->getQuantity(), $object->getPrice());
        }
    }

    /**
     * @param Item[] $objects
     */
    public function addGifts($objects)
    {
        foreach($objects as $object)
        {
            $this->addGift($object->getProduct(), $object->getQuantity());
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
    public function account(){ return $this->belongsTo(Account::getClass(), 'account_id'); }

    public function gifts(){ return $this->belongsToMany(Product::getClass(), 'gift_order')->withPivot('quantity'); }
    public function products(){ return $this->belongsToMany(Product::getClass(), 'product_order')->withPivot('quantity', 'price'); }

}
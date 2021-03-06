<?php namespace ECommerce;

use Cart\Cart;
use Cart\Item;
use Kareem3d\Membership\Account;
use Kareem3d\Membership\UserInfo;
use Location\Location;
use Migs\MigsPayment;
use Paypal\PaypalPayment;
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
     * @var array
     */
    protected $fillable = array('user_info_id', 'location_id', 'price', 'account_id', 'currency', 'unique_identifier', 'status', 'delivery_time', 'delivery_day');

    /**
     * @return mixed|void
     */
    public function beforeSave()
    {
        $this->attributes['unique_identifier'] = $this->generateUniqueIdentifier();
    }

    /**
     * Generate new unique identifier
     */
    public function generateUniqueIdentifier()
    {
        $number_of_loops = 0;

        while(true)
        {
            $unique = \random_identifier(4);

            // If unique identifier doesn't exist so break from this loop
            if(static::byUniqueIdentifier($unique)->count() == 0) break;

            if(($number_of_loops ++) > 500) {

                throw new \Exception("> 500 loop iterations are used to generate a random unique identifier.");
            }
        }


        return $unique;
    }

    /**
     * @param $query
     * @param $unique
     * @return mixed
     */
    public function scopeByUniqueIdentifier($query, $unique)
    {
        return $query->where('unique_identifier', $unique);
    }

    /**
     * @return mixed
     */
    public function getCurrencyAttribute()
    {
        return $this->attributes['currency'] ?: 'QAR';
    }

    /**
     * @param $dateTimeInputs
     * @param UserInfo $userInfo
     * @param Location $location
     * @param Cart $cart
     * @param Currency $currency
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function createFrom($dateTimeInputs, UserInfo $userInfo, Location $location, Cart $cart, Currency $currency)
    {
        /**
         * @param Order $order
         */
        $order = static::create(array(
            'delivery_time' => isset($dateTimeInputs['time']) ? $dateTimeInputs['time'] : '',
            'delivery_day' => isset($dateTimeInputs['day']) ? $dateTimeInputs['day'] : '',
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

    public function migsPayment(){ return $this->hasOne(MigsPayment::getClass()); }

    public function paypalPayments() { return $this->hasMany(PaypalPayment::getClass()); }
}
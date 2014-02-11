<?php namespace Offers;

use ECommerce\Product;
use Units\Price;

class ProductOffer extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'product_offers';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = array('discount_percentage', 'from_date', 'to_date');

    /**
     * @return mixed|void
     */
    public function beforeSave()
    {
        if($this->to_date == '')
        {
            $this->attributes['from_date'] = '2000-01-01 01:01:01';
            $this->attributes['to_date'] = '2099-01-01 01:01:01';
        }
    }

    /**
     * @param $product
     * @param $attributes
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function createForProduct($product, $attributes)
    {
        unset($attributes['id']);

        if($product instanceof Product) $product = $product->id;

        if($offer = static::current(new \DateTime())->byProduct($product)->first())
        {
            $offer->update($attributes);

            return $offer;
        }

        $attributes['product_id'] = $product;

        return static::create($attributes);
    }

    /**
     * @param $value
     */
    public function setFromDateAttribute($value)
    {
        $this->attributes['from_date'] = date('Y-m-d H:i:s', strtotime($value));
    }

    /**
     * @param $value
     */
    public function setToDateAttribute($value)
    {
        $this->attributes['to_date'] = date('Y-m-d H:i:s', strtotime($value));
    }


    /**
     * @param $query
     * @param $date
     * @return mixed
     */
    public function scopeCurrent($query, $date)
    {
        if($date instanceof \DateTime) $date = $date->format('Y-m-d H:i:s');

        return $query->where(function($query) use($date)
        {
            $query->where('from_date', '<=', $date)->where('to_date', '>=', $date);
        })->orWhereNull('to_date');
    }

    /**
     * @param $query
     * @param $product
     * @return mixed
     */
    public function scopeByProduct($query, $product)
    {
        if($product instanceof Product) $product = $product->id;

        return $query->where('product_id', $product);
    }

    /**
     * @param $beforePrice
     * @param $afterPrice
     * @return void
     */
    public function calculateDiscountFrom($beforePrice, $afterPrice)
    {
        if($beforePrice instanceof Price) $beforePrice = $beforePrice->value;
        if($afterPrice instanceof Price)  $afterPrice = $afterPrice->value;

        // Calculate discount percentage
        $this->discount_percentage = 100 - ($afterPrice / $beforePrice) * 100;
    }

    /**
     * @param \ECommerce\Product $product
     * @param $date
     * @return float
     */
    public static function calculatePriceFromProduct(Product $product, $date)
    {
        if($discount = static::current($date)->byProduct($product)->pluck('discount_percentage'))
        {
            return $product->price->multiply( $discount / 100 );
        }

        return $product->price;
    }

    /**
     * Defining relations
     */
    public function product(){ return $this->belongsTo(Product::getClass()); }

}
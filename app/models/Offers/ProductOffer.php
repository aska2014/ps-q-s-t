<?php namespace Offers;

use ECommerce\Product;
use Units\Price;

class ProductOffer extends \DateRangeModel {

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
    protected $fillable = array('discount_percentage', 'from_date', 'to_date', 'product_id');

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
        if($beforePrice instanceof Price) $beforePrice = $beforePrice->value();
        if($afterPrice instanceof Price)  $afterPrice = $afterPrice->value();

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
            $price = clone($product->getActualPrice());

            return $price->multiply($discount / 100)->round();
        }

        return $product->getActualPrice();
    }

    /**
     * Defining relations
     */
    public function product(){ return $this->belongsTo(Product::getClass()); }

}
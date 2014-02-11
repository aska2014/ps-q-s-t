<?php namespace ECommerce;

use Offers\OfferPosition;
use Offers\ProductOffer;
use Units\Price;

class Product extends \BaseModel {

    /**
     * @var array
     */
    protected $extensions = array('Images');

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $with = array('price');

    /**
     * @var array
     */
    protected $fillable = array('title', 'description', 'model', 'gender', 'category_id', 'brand_id', 'price_id');

    /**
     * @param $query
     * @param $category
     * @return mixed
     */
    public function scopeByCategory($query, $category)
    {
        if($category instanceof Category) $category = $category->id;

        return $query->where('category_id', $category);
    }

    /**
     * @param $query
     * @param $brand
     * @return mixed
     */
    public function scopeByBrand($query, $brand)
    {
        if($brand instanceof Category) $brand = $brand->id;

        return $query->where('brand_id', $brand);
    }

    /**
     * @return mixed
     */
    public function getProductOfferAttribute()
    {
        $productOffer = ProductOffer::byProduct($this)->current(new \DateTime())->first();

        return $productOffer ?: new ProductOffer();
    }

    /**
     * @param $value
     * @param string $currency
     * @return Price
     */
    public function setPrice($value, $currency = '')
    {
        if(! $price = $this->price) $price = new Price();

        $price->fill(compact('value', 'currency'));

        $price->save();

        $this->price()->associate($price);

        $this->save();
    }

    /**
     * @param $from
     * @param $to
     * @param $afterPrice
     * @return void
     */
    public function addDiscountPrice($from, $to, $afterPrice)
    {
        if($afterPrice instanceof Price)  $afterPrice = $afterPrice->value;

        $beforePrice = $this->price->value;

        $this->productOffers()->create(array(
            'discount_percentage' => 100 - ($afterPrice / $beforePrice) * 100,
            'from_date' => $from,
            'to_date' => $to,
        ));
    }

    /**
     * @param $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function setCurrentOffer($attributes)
    {
        // See if there's already current offer on this product
        if($productOffer = ProductOffer::current(new \DateTime())->first())
        {
            $productOffer->update($attributes);

            return $productOffer;
        }

        // Create new product offer otherwise
        return $this->productOffers()->create($attributes);
    }

    /**
     * @return Price
     * @return float
     */
    public function getCurrentPriceAttribute()
    {
        return ProductOffer::calculatePriceFromProduct( $this, new \DateTime() );
    }

    /**
     * Defining relations
     */
    public function category(){ return $this->belongsTo(Category::getClass()); }
    public function brand(){ return $this->belongsTo(Brand::getClass()); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function price(){ return $this->belongsTo(Price::getClass()); }

    public function productOffers(){ return $this->hasMany(ProductOffer::getClass()); }
    public function offerPositions(){ return $this->hasMany(OfferPosition::getClass()); }

    public function productOrders(){ return $this->belongsToMany(Order::getClass(), 'product_order'); }
    public function giftOrders(){ return $this->belongsToMany(Order::getClass(), 'gift_order'); }
    /*************************************************************************************/
}
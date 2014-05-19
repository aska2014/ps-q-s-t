<?php namespace ECommerce;

use Illuminate\Support\Facades\App;
use Offers\OfferPosition;
use Offers\ProductOffer;
use URL, DB;
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
    protected $with = array('brand', 'category');

    /**
     * @var array
     */
    protected $fillable = array('title', 'description', 'model', 'gender', 'category_id', 'brand_id', 'price');

    /**
     * @var array
     */
    protected $prices = array();

    /**
     * @param $query
     * @return mixed
     * @todo
     */
    public function scopeTopSales($query)
    {
        $query->select('products.*')
              ->leftJoin('product_order', 'product_order.product_id', '=', 'products.id')
              ->groupBy('product_order.product_id')
              ->orderBy(DB::raw('SUM(quantity)'), 'ASC');

        return $query;
    }

    /**
     * @param $query
     * @param $price
     * @return mixed
     */
    public function scopePriceGreaterThan($query, $price)
    {
        return $query->where('price', '>=', $price);
    }

    /**
     * @param $query
     * @param $price
     * @return mixed
     */
    public function scopePriceSmallerThan($query, $price)
    {
        return $query->where('price', '<=', $price);
    }

    /**
     * @param $query
     * @todo
     */
    public function scopeMix($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    /**
     * @param $query
     * @param $ids
     * @return mixed
     */
    public function scopeByIds($query, $ids)
    {
        $ids = explode(',', $ids);

        if(count($ids) > 0) return $query->whereIn('id', $ids);

        return $query->where('id', 0);
    }

    /**
     * @param $query
     * @param $category
     * @return mixed
     */
    public function scopeByCategoryName($query, $category)
    {
        return $query->join('categories', 'categories.id', '=', 'products.category_id')
            ->where(DB::raw('LOWER(krq_categories.name)'), '=', $category)->select('products.*');
    }

    /**
     * @param $query
     * @param $brand
     * @return mixed
     */
    public function scopeByBrandName($query, $brand)
    {
        return $query->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where(DB::raw('LOWER(krq_brands.name)'), 'like', $brand.'%')->select('products.*');
    }

    /**
     * @param $query
     * @param $model
     * @return mixed
     */
    public function scopeByModel($query, $model)
    {
        $model = trim(str_replace('model', '', $model));

        return $query->where(DB::raw('LOWER(krq_products.model)'), $model);
    }

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
        if($brand instanceof Brand) $brand = $brand->id;

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
     * @return mixed
     */
    public function getTitleAttribute($value)
    {
        return $value ?: 'Model '. $this->model;
    }

    /**
     * @param $from
     * @param $to
     * @param $afterPrice
     * @return void
     */
    public function addDiscountPrice($from, $to, $afterPrice)
    {
        if($afterPrice instanceof Price)  $afterPrice = $afterPrice->value();

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
     * @return \Units\Price
     */
    public function getActualPrice()
    {
        if(isset($this->prices['actual']))  return $this->prices['actual'];

        return $this->prices['actual'] = Price::make($this->price);
    }

    /**
     * @return Price
     * @return float
     */
    public function getOfferPrice()
    {
        if(isset($this->prices['offer'])) return $this->prices['offer'];

        return $this->prices['offer'] = ProductOffer::calculatePriceFromProduct( $this, new \DateTime() );
    }

    /**
     * @return bool
     */
    public function hasOfferPrice()
    {
        return $this->getOfferPrice()->value() < $this->getActualPrice()->value();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeUnique($query)
    {
        $ids = $this->getVisibleIds();

        return empty($ids) ? $query : $query->whereNotIn('id', $ids);
    }

    /**
     * @return array
     */
    public function getVisibleIds()
    {
        return App::make('VisibleProductRepository')->getIds();
    }

    /**
     * @return string
     */
    public function toCartJson()
    {
        return json_encode(array(
            'id' => $this->id,
            'price' => $this->getOfferPrice()->value(),
            'url' => URL::product($this)
        ));
    }

    /**
     * Defining relations
     */
    public function category(){ return $this->belongsTo(Category::getClass()); }
    public function brand(){ return $this->belongsTo(Brand::getClass()); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productOffers(){ return $this->hasMany(ProductOffer::getClass()); }
    public function offerPositions(){ return $this->hasMany(OfferPosition::getClass()); }

    public function productOrders(){ return $this->belongsToMany(Order::getClass(), 'product_order'); }
    public function giftOrders(){ return $this->belongsToMany(Order::getClass(), 'gift_order'); }
    /*************************************************************************************/
}
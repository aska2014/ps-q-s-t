<?php namespace ECommerce;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Brand extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'brands';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = array('name');


    public function scopeByCategory($query, Category $category)
    {
        return $query->join('products', function($query)
        {
            $query->on('products.brand_id', '=', 'brands.id');
        })
        ->groupBy('brands.id')
        ->where('products.category_id', '=', $category->id)
        ->select('brands.*');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePopular($query)
    {
        return $query->join('products', function($query)
        {
            $query->on('products.brand_id', '=', 'brands.id');
        })
        ->groupBy('brands.id')
        ->orderBy('number_of_products', 'DESC')
        ->select('brands.*', DB::raw('COUNT(*) as number_of_products'));
    }

    /**
     * @param int $take
     * @return Collection
     */
    public function getUniqueProducts($take = 0)
    {
        $query = Product::byCategory($this)->available()->unique();

        if($take > 0) return $query->take($take);

        return $query->get();
    }

    /**
     * Defining relations
     */
    public function products(){ return $this->hasMany(Product::getClass()); }

    public function orders(){ return $this->hasManyThrough(Order::getClass(), Product::getClass());}
    /*************************************************************************************/

}
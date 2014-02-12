<?php namespace ECommerce;

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
     * Defining relations
     */
    public function products(){ return $this->hasMany(Product::getClass()); }

    public function orders(){ return $this->hasManyThrough(Order::getClass(), Product::getClass());}
    /*************************************************************************************/

}
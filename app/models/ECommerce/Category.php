<?php namespace ECommerce;

use Illuminate\Support\Collection;

class Category extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = array('name');

    /**
     * @return mixed
     */
    public function getMainProduct()
    {
        return $this->products->last();
    }

    /**
     * @return mixed
     */
    public function getBrandsAttribute()
    {
        return \App::make('Ecommerce\Brand')->byCategory($this)->get();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotEmpty($query)
    {
        return $query->whereIn('id', function( $query )
        {
            $query->from('products');

            $query->distinct();
            $query->select('category_id');

            return $query;
        });
    }

    /**
     * @param int $take
     * @return Collection
     */
    public function getUniqueProducts($take = 0)
    {
        $query = Product::byCategory($this)->unique();

        if($take > 0) return $query->take($take)->get();

       return $query->get();
    }

    /**
     * Defining relations
     */
    public function parent(){ return $this->belongsTo(Category::getClass()); }

    public function children(){ return $this->hasMany(Category::getClass()); }
    public function products(){ return $this->hasMany(Product::getClass()); }

    public function orders(){ return $this->hasManyThrough(Order::getClass(), Product::getClass());}
    /*************************************************************************************/

}
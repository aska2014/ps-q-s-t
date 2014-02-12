<?php namespace ECommerce;

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
     * @return mixed
     */
    public function getMainProduct()
    {
        return $this->products->first();
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
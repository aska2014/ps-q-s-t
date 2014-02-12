<?php

use Illuminate\Support\Collection;

class VisibleProductRepository  {

    /**
     * @var Collection
     */
    protected $products;

    public function __construct(Collection $products)
    {
        $this->products = $products;
    }

    /**
     * @param $products
     */
    public function add($products)
    {
        $this->products = $this->products->merge($products);
    }

    /**
     * @param $parents
     */
    public function addRecursive($parents)
    {
        foreach($parents as $parent) $this->add($parent->products);
    }

    /**
     * @return array
     */
    public function getIds()
    {
        return $this->products->lists('id');
    }

}
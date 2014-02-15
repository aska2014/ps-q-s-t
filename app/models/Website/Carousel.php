<?php namespace Website;

use Illuminate\Support\Collection;

class Carousel {

    /**
     * @var string
     */
    public $title;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $products;

    /**
     * @param $title
     * @param \Illuminate\Support\Collection $products
     */
    public function __construct($title, Collection $products)
    {
        $this->title = $title;
        $this->products = $products;
    }
}
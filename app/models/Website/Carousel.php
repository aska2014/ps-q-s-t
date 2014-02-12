<?php namespace Website;

class Carousel {

    /**
     * @var string
     */
    public $title;

    /**
     * @var Illuminate\Support\Collection
     */
    public $products;

    /**
     * @param $title
     * @param \Illuminate\Support\Collection $products
     */
    public function __construct($title, \Illuminate\Support\Collection $products)
    {
        $this->title = $title;
        $this->products = $products;
    }
}
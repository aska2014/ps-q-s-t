<?php

use ECommerce\Product;
use Website\Carousel;

class HomeController extends BaseController {

    /**
     * @param Product $products
     */
    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function index()
	{
        $carousel = new Carousel('Top sales of this month', $this->products->topSales()->get());

        return View::make('pages.home', compact('carousel'));
	}

}
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
        $products = $this->products->topSales()->unique()->get();

        $carousel = new Carousel('Top sales of this month', $products);

        return View::make('pages.home', compact('carousel'));
	}

}
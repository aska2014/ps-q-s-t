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
    public function welcome()
    {
        // If agent is mobile and not a tablet then redirect him to the normal home page
        if(Agent::isMobile() && ! Agent::isTablet())
        {
            return $this->index();
        }

        $products = $this->products->topSales()->unique()->take(6)->get();

        return View::make('pages.welcome', compact('products'));
    }

    /**
     * @return mixed
     */
    public function index()
	{
        $products = $this->products->topSales()->unique()->mix()->take(static::PRODUCTS_PER_CAROUSEL)->get();

        $carousel = new Carousel('Top sales for this month', $products);

        return View::make('pages.home', compact('carousel'));
	}

}
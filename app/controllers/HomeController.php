<?php

use ECommerce\Brand;
use ECommerce\Category;
use ECommerce\Product;
use Website\Carousel;

class HomeController extends BaseController {

    /**
     * @param Product $products
     * @param Brand $brands
     * @param Category $categories
     */
    public function __construct(Product $products, Brand $brands, Category $categories)
    {
        $this->products = $products;
        $this->brands = $brands;
        $this->categories = $categories;
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

        $categories = $this->categories->all();

        $products = $this->products->topSales()->unique()->take(6)->get();

        return View::make('pages.welcome', compact('products', 'categories'));
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
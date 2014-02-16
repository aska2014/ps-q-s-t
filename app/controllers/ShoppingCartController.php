<?php

use ECommerce\Product;

class ShoppingCartController extends BaseController {

    /**
     * @param Product $products
     * @param Location\Country $countries
     */
    public function __construct(Product $products, \Location\Country $countries)
    {
        $this->products = $products;
        $this->countries = $countries;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $carousel = new \Website\Carousel('Related products', $this->products->random()->take(static::PRODUCTS_PER_CAROUSEL)->get());

        return View::make('pages.cart', compact('carousel'));
    }

    /**
     * @return mixed
     */
    public function checkout()
    {
        $countries = $this->countries->with('cities')->get();

        return View::make('pages.checkout', compact('countries'));
    }
}
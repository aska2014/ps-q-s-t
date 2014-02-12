<?php

use ECommerce\Product;

class ShoppingCartController extends BaseController {

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
        $carousel = new \Website\Carousel('Related products', $this->products->random()->take(25)->get());

        return View::make('pages.cart', compact('carousel'));
    }

    /**
     * @return mixed
     */
    public function checkout()
    {
        return View::make('pages.checkout');
    }
}
<?php

use Cart\Cart;
use ECommerce\Product;

class ShoppingCartController extends BaseController {

    /**
     * @param Product $products
     * @param Location\Country $countries
     * @param Cart $cart
     */
    public function __construct(Product $products, \Location\Country $countries, Cart $cart)
    {
        $this->products = $products;
        $this->countries = $countries;
        $this->cart = $cart;
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

        $price = $this->cart->getTotalPrice()->multiply(0.9);

        $NBEPrice['QAR'] = $price->round(0)->format();
        $NBEPrice['EGP'] = $price->convertTo(new \Units\Currency('EGP'))->round(0)->format();

        return View::make('pages.checkout', compact('countries', 'NBEPrice'));
    }
}
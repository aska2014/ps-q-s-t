<?php

class ShoppingCartController extends BaseController {

    /**
     * @return mixed
     */
    public function index()
    {
        return View::make('pages.cart');
    }

    /**
     * @return mixed
     */
    public function checkout()
    {
        return View::make('pages.checkout');
    }
}
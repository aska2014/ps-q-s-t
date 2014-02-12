<?php

use ECommerce\Brand;
use ECommerce\Category;
use ECommerce\Product;

class ProductsController extends BaseController {

    /**
     * @param Product $products
     */
    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * @param Product $product
     * @return mixed
     */
    public function product(Product $product)
    {
        return View::make('pages.product', compact('product'));
    }

    /**
     * @param Brand $brand
     * @return mixed
     */
    public function brand(Brand $brand)
    {
        $products = $brand->products;

        return View::make('pages.products', compact('products'));
    }

    /**
     * @param \ECommerce\Category $category
     * @return mixed
     */
    public function category(Category $category)
    {
        $products = $category->products;

        return View::make('pages.products', compact('products'));
    }
}
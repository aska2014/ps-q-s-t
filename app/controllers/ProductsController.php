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
        $carousel = $this->getCarousel();

        return View::make('pages.product', compact('product', 'carousel'));
    }

    /**
     * @param Brand $brand
     * @return mixed
     */
    public function brand(Brand $brand)
    {
        $products = $brand->products;
        $carousel = $this->getCarousel();

        return View::make('pages.products', compact('products', 'carousel'));
    }

    /**
     * @param \ECommerce\Category $category
     * @return mixed
     */
    public function category(Category $category)
    {
        $products = $category->products;
        $carousel = $this->getCarousel();

        return View::make('pages.products', compact('products', 'carousel'));
    }

    /**
     * @return \Website\Carousel
     * @todo
     */
    protected function getCarousel()
    {
        return new \Website\Carousel('Related products', $this->products->random()->take(25)->get());
    }
}
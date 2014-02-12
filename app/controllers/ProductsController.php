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
        $carousel = $this->getCarousel();
        $products = $this->products->byBrand($brand)->unique()->get();

        $this->addToVisible($products);

        return View::make('pages.products', compact('brand', 'products', 'carousel'));
    }

    /**
     * @param \ECommerce\Category $category
     * @return mixed
     */
    public function category(Category $category)
    {
        $carousel = $this->getCarousel();
        $products = $this->products->byCategory($category)->unique()->get();

        $this->addToVisible($products);

        return View::make('pages.products', compact('category', 'products', 'carousel'));
    }

    /**
     * @return \Website\Carousel
     * @todo
     */
    protected function getCarousel()
    {
        $products = $this->products->random()->take(static::PRODUCTS_PER_CAROUSEL)->get();

        return new \Website\Carousel('Related products', $products);
    }
}
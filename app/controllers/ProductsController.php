<?php

use ECommerce\Brand;
use ECommerce\Category;
use ECommerce\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductsController extends BaseController {

    /**
     * @param Product $products
     */
    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * @param $category
     * @param $brand
     * @param $title
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return mixed
     */
    public function product($category, $brand, $title)
    {
        $product = $this->products->byCategoryName($category)->byBrandName($brand)->byModel(str_replace('model', '', $title))->first();

        // Fail if no product was found
        if(is_null($product)) throw new ModelNotFoundException();

        $carousel = $this->getCarousel();

        return View::make('pages.product', compact('product', 'carousel'));
    }

    /**
     * @param $brand
     * @return mixed
     */
    public function brand($brand)
    {
        $products = $this->products->byBrandName($brand)->unique()->paginate(12);

        $carousel = $this->getCarousel();

        return View::make('pages.products', compact('brand', 'products', 'carousel'));
    }

    /**
     * @param $category
     * @return mixed
     */
    public function category($category)
    {
        $products = $this->products->byCategoryName($category)->unique()->paginate(12);

        $carousel = $this->getCarousel();

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
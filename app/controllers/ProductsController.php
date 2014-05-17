<?php

use ECommerce\Brand;
use ECommerce\Category;
use ECommerce\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductsController extends BaseController {

    /**
     * @param Product $products
     * @param Offers\MassOffer $massOffers
     */
    public function __construct(Product $products, \Offers\MassOffer $massOffers)
    {
        $this->products = $products;
        $this->massOffers = $massOffers;
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
        list($category, $brand, $title) = $this->convertSlugs($category, $brand, $title);

        $product = $this->products->orderByDate()->byCategoryName($category)->byBrandName($brand)->byModel($title)->first();

        // Fail if no product was found
        if(is_null($product)) throw new ModelNotFoundException();

        $carousel = $this->getCarousel();

        return View::make('pages.product', compact('product', 'carousel'));
    }


    /**
     * @return mixed
     */
    public function chooseGifts()
    {
        $products = $this->massOffers->current(new DateTime('now'))->first()->filterGiftsFromCollection($this->products->all());

        return View::make('pages.choose_gifts', compact('products'));
    }

    /**
     * @param $brand
     * @return mixed
     */
    public function brand($brand)
    {
        $brand = $this->convertSlugs($brand);

        $products = $this->products->orderByDate()->byBrandName($brand)->unique()->paginate(static::PRODUCTS_PER_PAGE);

        $carousel = $this->getCarousel();

        return View::make('pages.products', compact('brand', 'products', 'carousel'));
    }

    /**
     * @param $category
     * @return mixed
     */
    public function category($category)
    {
        $category = $this->convertSlugs($category);

        $products = $this->products->orderByDate()->byCategoryName($category)->unique()->paginate(static::PRODUCTS_PER_PAGE);

        $carousel = $this->getCarousel();

        return View::make('pages.products', compact('category', 'products', 'carousel'));
    }

    /**
     * @param $category
     * @param $brand
     */
    public function categoryBrand($category, $brand)
    {
        $brand = $this->convertSlugs($brand);
        $category = $this->convertSlugs($category);

        $products = $this->products->orderByDate()->byBrandName($brand)->byCategoryName($category)->unique()->paginate(static::PRODUCTS_PER_PAGE);

        $carousel = $this->getCarousel();

        return View::make('pages.products', compact('brand', 'products', 'carousel'));
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
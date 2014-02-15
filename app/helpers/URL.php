<?php

use ECommerce\Brand;
use ECommerce\Category;
use ECommerce\Product;
use Illuminate\Support\Facades\URL as LaravelURL;

class URL extends LaravelURL {

    /**
     * @param $path
     * @return mixed
     */
    public static function lib($path)
    {
        return static::asset('app/lib/' . ltrim($path, '/'));
    }

    /**
     * @param Product $product
     * @return mixed
     */
    public static function product(Product $product)
    {
        return static::route('product', array(
            'category_name' => strtolower($product->category->name),
            'brand_name' => strtolower($product->brand->name),
            'title' => strtolower('model' . $product->model)
        ));
    }

    /**
     * @param Category $category
     * @return mixed
     */
    public static function category(Category $category)
    {
        return static::route('category', $category->name);
    }

    /**
     * @param ECommerce\Brand $brand
     * @return mixed
     */
    public static function brand(Brand $brand)
    {
        return static::route('brand', $brand->name);
    }

}
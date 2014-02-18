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
            'category_name' => static::encode($product->category->name),
            'brand_name' => static::encode($product->brand->name),
            'title' => static::encode('model-' . $product->model)
        ));
    }

    /**
     * @param Category $category
     * @return mixed
     */
    public static function category(Category $category)
    {
        return static::route('category', static::encode($category->name));
    }

    /**
     * @param ECommerce\Brand $brand
     * @return mixed
     */
    public static function brand(Brand $brand)
    {
        return static::route('brand', static::encode($brand->name));
    }


    /**
     * @param $title
     * @return string
     */
    public static function encode( $title )
    {
        $title = str_replace(' ', '-', $title);

        $title = str_replace('&', '-and-', $title);

        return strtolower($title);
    }


    /**
     * @param $slug
     * @return string
     */
    public static function decode( $slug )
    {
        $slug = str_replace('-and-', '&', $slug);

        $slug = str_replace('-', ' ', $slug);

        return strtolower($slug);
    }
}
<?php

use ECommerce\Product;

class ProductController extends BaseController {

    /**
     * @param Product $products
     */
    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * @param $id
     */
    public function getOne($id)
    {
        $product = $this->products->findOrFail($id);

        return Response::json(array(
            'title' => $product->title,
            'image' => $product->getImage('main')->getSmallest()->url,
            'url'   => URL::product($product),
            'brand' => $product->brand->name,
            'category' => $product->category->name,
            'model' => $product->model,
            'price' => $product->getOfferPrice()->value()
        ));
    }
}
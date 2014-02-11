<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kareem
 * Date: 2/8/14
 * Time: 5:54 PM
 * To change this template use File | Settings | File Templates.
 */

use ECommerce\Product;
use Units\Price;

class FreakProductController extends \Kareem3d\Freak\Core\ElementController {

    /**
     * @param \ECommerce\Product $products
     */
    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * Show all the resources.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->products->with('category', 'brand')->get();
    }

    /**
     * Show details about the resource.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->products->with('category', 'brand')->findOrFail($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCategory($id)
    {
        return $this->products->byCategory($id)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getBrand($id)
    {
        return $this->products->byBrand($id)->get();
    }

    /**
     * Insert new resource.
     *
     * @return mixed
     */
    public function store()
    {
        $product = $this->products->create(Input::all());

        $product->setPrice(Input::get('price.value'), Input::get('price.currency'));

        return $product;
    }

    /**
     * Update an existing resource.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        $product = $this->products->findOrFail($id);

        $product->update(Input::all());

        $product->setPrice(Input::get('price.value'), Input::get('price.currency'));
    }

    /**
     * Delete a resource
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $this->products->findOrFail($id)->delete();
    }
}
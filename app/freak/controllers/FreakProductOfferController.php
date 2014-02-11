<?php

class FreakProductOfferController extends \Kareem3d\Freak\Core\ElementController {

    /**
     * @param \Offers\ProductOffer $offers
     * @param \ECommerce\Product $products
     */
    public function __construct(\Offers\ProductOffer $offers, \ECommerce\Product $products)
    {
        $this->offers = $offers;
        $this->products = $products;
    }

    /**
     * Show all the resources.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->offers->all();
    }

    /**
     * Show details about the resource.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->offers->findOrFail($id);
    }

    /**
     * @param $id
     */
    public function getProductCurrent($id)
    {
        return $this->offers->byProduct($id)->current(new DateTime())->first();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function postProduct($id)
    {
        dd($id);
        return $this->offers->createForProduct($id, Input::all());
    }

    /**
     * Insert new resource.
     *
     * @return mixed
     */
    public function store()
    {
        return $this->products->find(Input::get('product_id'))->setCurrentOffer(Input::all());
    }

    /**
     * Update an existing resource.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        $this->offers->findOrFail($id)->update(Input::all());
    }

    /**
     * Delete a resource
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $this->offers->findOrFail($id)->delete();
    }
}
<?php

use ECommerce\Order;

class FreakOrderController extends \Kareem3d\Freak\Core\ElementController {

    /**
     * @param Order $orders
     */
    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Show all the resources.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->orders->with('products', 'gifts', 'userInfo', 'location')->get();
    }

    /**
     * Show details about the resource.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->orders->with('products', 'gifts', 'userInfo', 'location', 'migsPayment', 'paypalPayments')->findOrFail($id);
    }

    /**
     * Insert new resource.
     *
     * @return mixed
     */
    public function store()
    {
        return $this->orders->create(Input::all());
    }

    /**
     * Update an existing resource.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        $this->orders->findOrFail($id)->update(Input::all());
    }

    /**
     * Delete a resource
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $this->orders->findOrFail($id)->delete();
    }
}
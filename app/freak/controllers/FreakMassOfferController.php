<?php

class FreakMassOfferController extends \Kareem3d\Freak\Core\ElementController {

    /**
     * @param \Offers\MassOffer $offers
     */
    public function __construct(\Offers\MassOffer $offers)
    {
        $this->offers = $offers;
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
        // TODO: Implement show() method.
    }

    /**
     * Insert new resource.
     *
     * @return mixed
     */
    public function store()
    {
        // TODO: Implement store() method.
    }

    /**
     * Update an existing resource.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        // TODO: Implement update() method.
    }

    /**
     * Delete a resource
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}
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
        return $this->offers->findOrFail($id);
    }

    /**
     * Insert new resource.
     *
     * @return mixed
     */
    public function store()
    {
        return $this->offers->create(Input::all());
    }

    /**
     * Update an existing resource.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        $offer = $this->offers->findOrFail($id);

        $offer->update(Input::all());

        return $offer;
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
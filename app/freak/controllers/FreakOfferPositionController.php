<?php

class FreakOfferPositionController extends \Kareem3d\Freak\Core\ElementController {

    /**
     * @param \Offers\OfferPosition $positions
     */
    public function __construct(\Offers\OfferPosition $positions)
    {
        $this->positions = $positions;
    }

    /**
     *
     */
    public function getCurrent()
    {
        return $this->positions->getAllActive();
    }

    /**
     * Show all the resources.
     *
     * @return mixed
     */
    public function index()
    {
        // TODO: Implement index() method.
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
        return $this->positions->create(Input::all());
    }

    /**
     * Update an existing resource.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        $this->positions->findOrFail($id)->update(Input::all());
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
<?php

use ECommerce\Brand;

class FreakBrandController extends \Kareem3d\Freak\Core\ElementController {

    /**
     * @param Brand $brands
     */
    public function __construct(Brand $brands)
    {
        $this->brands = $brands;
    }

    /**
     * Show all the resources.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->brands->all();
    }

    /**
     * Show details about the resource.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->brands->findOrFail($id);
    }

    /**
     * Insert new resource.
     *
     * @return mixed
     */
    public function store()
    {
        return $this->brands->create(Input::all());
    }

    /**
     * Update an existing resource.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        $this->brands->findOrFail($id)->update(Input::all());
    }

    /**
     * Delete a resource
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $this->brands->findOrFail($id)->delete();
    }
}
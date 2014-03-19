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
        return $this->products->with('category', 'brand', 'productOffers')->findOrFail($id)->toJson();
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
        return $this->products->create(Input::all());
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

        return $product;
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


    public function postFacebook($id)
    {
        \Units\Currency::setCurrent('QAR');

        $product = $this->products->findOrFail($id);

        if(! $facebookTitle = Input::get('title'))
        {
            $facebookTitle = $product->title . PHP_EOL;

            if($product->hasOfferPrice())
            {
                $facebookTitle .= 'Special Offer <<<<<'.$product->getActualPrice().' QAR>>>>>>';
            }

            else
            {
                $facebookTitle .= 'Price ' .$product->getActualPrice() . ' QAR';
            }
        }

        $fb = new Facebook(Config::get('facebook.config'));

        $params = array(
            "access_token" => Config::get('facebook.access_token'),
            "message" => $facebookTitle,
            'description' => $facebookTitle,
            "source" => $product->getImage('main')->getLargest()->url,
            "link" => URL::product($product)
        );

        try {
            $fb->api('/'.Config::get('facebook.page_id').'/feed', 'POST', $params);

            return Redirect::back()->with('success', 'Product has been posted to facebook successfully.');
        } catch(Exception $e) {

            dd('Eb3tly elmsg de yhoby: ' . $e->getMessage());
        }
    }
}
<?php

use Cart\Cart;
use Cart\ItemFactoryInterface;
use ECommerce\Order;
use ECommerce\Product;
use Kareem3d\Membership\UserInfo;
use Location\Location;

class CheckoutController extends BaseController {

    /**
     * @var Cart\Cart
     */
    protected $cart;

    /**
     * @var ECommerce\Order
     */
    protected $orders;

    /**
     * @var ECommerce\Product
     */
    protected $products;

    /**
     * @var Location\Location
     */
    protected $locations;

    /**
     * @var Kareem3d\Membership\UserInfo
     */
    protected $userInfo;

    /**
     * @var Cart\ItemFactoryInterface
     */
    protected $itemFactory;

    /**
     * @param Cart $cart
     * @param Order $orders
     * @param Product $products
     * @param Location $locations
     * @param UserInfo $userInfo
     * @param ItemFactoryInterface $itemFactory
     */
    public function __construct(Cart $cart, Order $orders, Product $products, Location $locations,
                                UserInfo $userInfo, ItemFactoryInterface $itemFactory)
    {
        $this->cart = $cart;
        $this->orders = $orders;
        $this->products = $products;
        $this->locations = $locations;
        $this->userInfo = $userInfo;
        $this->itemFactory = $itemFactory;
    }

    /**
     * @return mixed
     */
    public function postCreateOrder()
    {
        $this->cart->hardValidate();

        // First create order
        $order = $this->createOrder(Input::get('Location'), Input::get('UserInfo'));

        // If there were errors
        if(! $this->emptyErrors())
        {
            // Redirect with errors
            Responser::errors($this->getErrors());
        }

        $this->messageToUser(
            'Thanks '. ucfirst($order->userInfo->first_name) .'! Order has been placed successfully.',
            'We will contact you soon at <span style="color:#C20676">'.$order->userInfo->contact_number.'</span>
            to confirm time of delivery and shipping address.<br /><br />
             Thank you for choosing QBrando <strong>online shop for luxury in Qatar</strong><br /><br />
            <a href='.URL::route('home').'>Go back home</a>'
        );
    }

    /**
     * Create user and location
     */
    protected function createOrder($locationInputs, $userInfoInputs)
    {
        $location = $this->locations->newInstance($locationInputs);

        if(! $location->validate())
        {
            $this->addErrors($location->getValidatorMessages());
        }

        $userInfo = $this->userInfo->newInstance($userInfoInputs);

        if(! $userInfo->validate())
        {
            $this->addErrors($userInfo->getValidatorMessages());
        }

        if($this->emptyErrors())
        {
            $location->save();
            $userInfo->save();

            $order = $this->orders->createFrom($this->userInfo, $this->locations);

            $order->addProducts($this->cart->getItems());
            $order->addGifts($this->cart->getGifts());

            return $order;
        }
    }

    /**
     * @param $productItems
     * @param $giftItems
     * @return bool
     */
    protected function validateCart($productItems, $giftItems)
    {
        return $this->cart->hardValidate($productItems, $giftItems);
    }

}
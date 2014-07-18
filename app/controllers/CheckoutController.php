<?php

use Cart\Cart;
use Cart\ItemFactoryInterface;
use ECommerce\Order;
use ECommerce\Product;
use Kareem3d\Membership\UserInfo;
use Location\Location;
use Migs\MigsPayment;
use Migs\MigsRequest;
use Paypal\PaypalPayment;
use Paypal\PaypalProcess;
use Units\Price;

class CheckoutController extends BaseController {

    /**
     * @param Cart $cart
     * @param Order $orders
     * @param Product $products
     * @param Location $locations
     * @param Migs\MigsManager $migsManager
     * @param UserInfo $userInfo
     * @param ItemFactoryInterface $itemFactory
     * @param MigsPayment $migsPayments
     * @param Paypal\PaypalProcess $paypalProcess
     * @param PaypalPayment $paypalPayments
     */
    public function __construct(Cart $cart, Order $orders, Product $products, Location $locations, \Migs\MigsManager $migsManager,
                                UserInfo $userInfo, ItemFactoryInterface $itemFactory, MigsPayment $migsPayments, PaypalProcess $paypalProcess,
                                PaypalPayment $paypalPayments)
    {
        $this->cart = $cart;
        $this->orders = $orders;
        $this->products = $products;
        $this->locations = $locations;
        $this->userInfo = $userInfo;
        $this->itemFactory = $itemFactory;
        $this->migsPayments = $migsPayments;
        $this->migsManager = $migsManager;
        $this->paypalProcess = $paypalProcess;
        $this->paypalPayments = $paypalPayments;
    }

    /**
     * @return mixed
     */
    public function postCreateOrder()
    {
        $this->cart->hardValidate();

        // First create order
        $order = $this->createOrder(Input::get('Location'), Input::get('UserInfo'), Input::get('Contact'));

        // If there were errors
        if(! $this->emptyErrors())
        {
            // Redirect with errors
            return Responser::errors($this->getErrors());
        }

        // Check payment method
        if(Input::get('Payment.method') === 'credit_card') {

            return $this->payWithCreditCard($order);

        } elseif(Input::get('Payment.method') === 'paypal') {

            return $this->payWithPaypal($order);

        } else {

            return $this->payOnDelivery($order);
        }
    }

    /**
     * @param Order $order
     * @return mixed
     */
    protected function payWithPaypal(Order $order)
    {
        $total = Price::make($order->price)->setCurrency($order->currency);

        // Discount 10% and convert to USD
        $total->multiply(0.9);
        $total->convertTo('USD');

        $return = $this->paypalProcess->setExpressCheckout($total, URL::route('paypal.succeed'), URL::route('paypal.canceled'));

        // Create new paypal payment with token and awaiting state
        $paypalPayment = $this->paypalPayments->newInstance();
        $paypalPayment->token = $return['token'];
        $paypalPayment->awaiting();
        $order->paypalPayments()->save($paypalPayment);

        // Redirect to paypal to continue payment process
        return Redirect::to($return['url']);
    }

    /**
     * Pay on delivery
     */
    protected function payOnDelivery(Order $order)
    {
        // Destory cart. Order has been made
        $this->itemFactory->destroy();

        return $this->messageToUser(
            'Thanks '. ucfirst($order->userInfo->first_name) .'! Order has been placed successfully.',
            'We will contact you soon at <span style="color:#C20676">'.Input::get('Contact.number').'</span>
            to confirm time of delivery and shipping address.<br /><br />
             Thank you for choosing QBrando <strong>online shop for luxury in Qatar</strong><br /><br />
            <a href='.URL::route('home').'>Go back home</a>'
        );
    }

    /**
     * Save that this user wants to make a payment with credit card
     */
    protected function payWithCreditCard(Order $order)
    {
        $total = Price::make($order->price);
        $total->setCurrency($order->currency);

        // Discount 10%
        $total->multiply(0.9);

        // Create new migs payment
        $migsPayment = $order->migsPayment()->create(array(
            'amount' => $total->convertTo('EGP')->round(0)->value(),
            'currency' => 'EGP'
        ));

        return $this->migsManager->makePaymentRequest($migsPayment, URL::route('migs.back'));
    }


    /**
     * Create user and location
     */
    protected function createOrder($locationInputs, $userInfoInputs, $contactInputs)
    {
        $location = $this->locations->newInstance($locationInputs);

        if(! $location->validate())
        {
            $this->addErrors($location->getValidatorMessages());
        }

        // Create user information
        $userInfo = $this->userInfo->newInstance($userInfoInputs);

        if(! $userInfo->validate())
        {
            $this->addErrors($userInfo->getValidatorMessages());
        }

        if($this->emptyErrors())
        {
            $location->save();
            $userInfo->save();

            // Create contact information for this user
            foreach($contactInputs as $type => $value)
            {
                if($value) $userInfo->contacts()->create(compact('type', 'value'));
            }

            // Save order with the current currency
            $order = $this->orders->createFrom($userInfo, $location, $this->cart, \Units\Currency::getCurrent());

            // Put order unique identifier in the session
            Session::put('order_unique_identifier', $order->unique_identifier);

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
<?php
class PaymentController extends BaseController {

    /**
     * Display pament methods
     */
    public function showMethods()
    {
        // Display payment methods
    }


    /**
     * Pay on delivery
     */
    public function payOnDelivery()
    {
        $order = $this->getOrderFromSession();

        return $this->messageToUser(
            'Thanks '. ucfirst($order->userInfo->first_name) .'! Order has been placed successfully.',
            'We will contact you soon at <span style="color:#C20676">'.Input::get('Contact.number').'</span>
            to confirm time of delivery and shipping address.<br /><br />
             Thank you for choosing QBrando <strong>online shop for luxury in Qatar</strong><br /><br />
            <a href='.URL::route('home').'>Go back home</a>'
        );
    }

    /**
     * Pay with national bank of egypt
     */
    public function payWithNBE()
    {
        $order = $this->getOrderFromSession();

    }

    /**
     *
     */
    protected function getOrderFromSession()
    {
        return $this->orders->byUniqueIdentifier(Session::get('order_unique_identifer'));
    }

} 
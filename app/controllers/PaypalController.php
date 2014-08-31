<?php

use ECommerce\Order;
use Paypal\PaypalPayment;
use Paypal\PaypalProcess;

class PaypalController extends BaseController {

    /**
     * @param PaypalPayment $paypalPayments
     * @param PaypalProcess $paypalProcess
     * @param Cart\ItemFactoryInterface $itemFactory
     */
    public function __construct(PaypalPayment $paypalPayments, PaypalProcess $paypalProcess, \Cart\ItemFactoryInterface $itemFactory)
    {
        $this->paypalPayments = $paypalPayments;
        $this->paypalProcess = $paypalProcess;
        $this->itemFactory = $itemFactory;
    }

    /**
     * Back from paypal with succeed.
     *
     * @return mixed
     */
    public function backSucceed()
    {
        $token = Input::get('token');

        $paypalPayment = $this->paypalPayments->getByToken($token);
        $order = $paypalPayment->order;

        $paypal = $this->paypalProcess->getExpressCheckoutDetails($token);

        // Add gross amount to the paypal payment
        $paypalPayment->gross_amount = $paypal['order']['total'];
        $paypalPayment->currency = $paypal['order']['currency'];
        $paypalPayment->save();

        $data = compact('paypal', 'order', 'token');

        return View::make('pages.paypal.confirm', $data);
    }

    /**
     * Back from paypal with failure
     *
     * @return mixed
     */
    public function backCanceled()
    {
        $token = Input::get('token');

        $paypalPayment = $this->paypalPayments->getByToken($token);
        $paypalPayment->canceled();
        $paypalPayment->save();

        return Redirect::route('checkout');
    }

    /**
     * User confirmed the paypal details.
     * Do express checkout. (last step)
     *
     * @throws Exception
     */
    public function postConfirmPayment()
    {
        $payerID = Input::get('payerID');
        $token = Input::get('token');

        if(! $paypalPayment = $this->paypalPayments->getByToken($token)) throw new Exception('In postConfirmPayment: Couldn\'t get paypalPayment by token.');

        $transaction = $this->paypalProcess->doExpressCheckout($paypalPayment, $payerID);

        // Set fee amount for this payment
        $paypalPayment->fee_amount = $transaction['feeAmount']->value;
        $paypalPayment->transaction_id = $transaction['transactionID'];

        // Mark this payment as received and push it to database
        $paypalPayment->received();
        $paypalPayment->save();

        // Destory cart. Order has been made
        $this->itemFactory->destroy();

        $order = $paypalPayment->order;

        $contact = $order->userInfo->contacts()->where('type', 'number')->first();

        $this->notifyByEmail($paypalPayment, $paypalPayment->order);

        return $this->messageToUser(
            'Thanks '. ucfirst($order->userInfo->first_name) .'! Order has been placed successfully.',

            'We have received '.$paypalPayment->getGrossAmount()->format().' From your Paypal account <br /><br />

            We will contact you soon at <span style="color:#C20676">'.$contact->value.'</span>
                to confirm time of delivery and shipping address.<br /><br />

            Thank you for choosing QBrando <strong>online shop for luxury in Qatar</strong><br /><br/>

                <a href='.URL::route('home').'>Go back home</a>'
        );
    }

    /**
     * @param Paypal\PaypalPayment $paypalPayment
     * @param Order $order
     */
    protected function notifyByEmail(PaypalPayment $paypalPayment, Order $order)
    {
        Mail::send('emails.paypal_payment_notification', compact('paypalPayment', 'order'), function($message)
        {
            $message->to('kareem3d.a@gmail.com', 'Kareem Mohamed')->subject('Paypal payment received on QBRANDO');
            $message->to('leaguemen@hotmail.com', 'Ahmed Mohamed')->subject('Paypal payment received on QBRANDO');
        });
    }
}
<?php namespace Paypal;

use Config;
use ECommerce\Order;
use PayPal\CoreComponentTypes\BasicAmountType;
use PayPal\EBLBaseComponents\DoExpressCheckoutPaymentRequestDetailsType;
use PayPal\EBLBaseComponents\PaymentDetailsType;
use PayPal\EBLBaseComponents\SetExpressCheckoutRequestDetailsType;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentReq;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentRequestType;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsReq;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsRequestType;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsResponseType;
use PayPal\PayPalAPI\SetExpressCheckoutReq;
use PayPal\PayPalAPI\SetExpressCheckoutRequestType;
use PayPal\Service\PayPalAPIInterfaceServiceService;
use Units\Price;

class PaypalProcess {

    /**
     * Set express checkout
     *
     * @param \Units\Price $totalPrice
     * @param $succeedUrl
     * @param $canceledUrl
     * @throws PaypalException
     * @return array
     */
    public function setExpressCheckout(Price $totalPrice, $succeedUrl, $canceledUrl)
    {
        try{
            // details about payment
            $paymentDetails = new PaymentDetailsType();

            // Do something to show the order summery
            // total order amount
            $paymentDetails->OrderTotal = new BasicAmountType(Config::get('paypal.payment.currency'), $totalPrice->round(2)->value());

            $paymentDetails->PaymentAction = Config::get('paypal.payment.action');

            $setECReqDetails = new SetExpressCheckoutRequestDetailsType();
            $setECReqDetails->PaymentDetails[0] = $paymentDetails;
            $setECReqDetails->CancelURL = $canceledUrl;
            $setECReqDetails->ReturnURL = $succeedUrl;

            $setECReqType = new SetExpressCheckoutRequestType();
            $setECReqType->SetExpressCheckoutRequestDetails = $setECReqDetails;
            $setECReq = new SetExpressCheckoutReq();
            $setECReq->SetExpressCheckoutRequest = $setECReqType;

            $paypalService = new PayPalAPIInterfaceServiceService(Config::get('paypal.settings'));

            // If any exception thrown it will be caught by laravel exception handling system
            $setECResponse = $paypalService->SetExpressCheckout($setECReq);

        }catch(\Exception $e) {


            $exception = new PaypalException("In getExpressCheckoutDetails: {$e->getMessage()}");
            if(isset($setECReq)) $exception->setRequest($setECReq);
            if(isset($setECResponse)) $exception->setRequest($setECResponse);

            throw $exception;
        }

        if(isset($setECResponse) && strtoupper($setECResponse->Ack) == 'SUCCESS')
        {
            $token = $setECResponse->Token;

            $url = Config::get('paypal.url') . '?cmd=_express-checkout&token=' . $token . '&useraction=commit';

            return compact('token', 'url');
        }

        $exception = new PaypalException("In setExpressCheckout: Response is not success");
        $exception->setRequest($setECReq);
        $exception->setResponse($setECResponse);

        throw $exception;
    }


    /**
     * GetExpressCheckoutDetails
     *
     * @param $token
     * @throws PaypalException
     * @return array
     */
    public function getExpressCheckoutDetails($token)
    {
        try{
            $getExpressCheckoutDetailsRequest = new GetExpressCheckoutDetailsRequestType($token);

            $getExpressCheckoutReq = new GetExpressCheckoutDetailsReq();
            $getExpressCheckoutReq->GetExpressCheckoutDetailsRequest = $getExpressCheckoutDetailsRequest;

            $paypalService = new PayPalAPIInterfaceServiceService(Config::get('paypal.settings'));

            // If exception was thrown then laravel exception handling will handle it /:)
            $getECResponse = $paypalService->GetExpressCheckoutDetails($getExpressCheckoutReq);

        }catch(\Exception $e) {

            $exception = new PaypalException("In getExpressCheckoutDetails: {$e->getMessage()}");
            if(isset($getExpressCheckoutReq)) $exception->setRequest($getExpressCheckoutReq);
            if(isset($getECResponse)) $exception->setResponse($getECResponse);

            throw $exception;
        }

        if(isset($getECResponse) && strtoupper($getECResponse->Ack) == 'SUCCESS') {

            return $this->extractExpressCheckoutRequiredInfo($getECResponse);
        }


        $exception = new PaypalException("In getExpressCheckoutDetails: Response is not success");
        $exception->setRequest($getExpressCheckoutReq);
        $exception->setResponse($getECResponse);

        throw $exception;
    }


    /**
     * Do express checkout
     *
     * @param PaypalPayment $paypalPayment
     * @param $payerID
     * @throws PaypalException
     * @return array
     */
    public function doExpressCheckout(PaypalPayment $paypalPayment, $payerID)
    {
        try{
            /*
             * The total cost of the transaction to the buyer.
             *
             * If shipping cost (not applicable to digital goods) and tax
             * charges are known, include them in this value.
             *
             * If not, this value should be the current sub-total of the order.
             *
             * If the transaction includes one or more one-time purchases,
             * this field must be equal to the sum of the purchases.
             *
             * Set this field to 0 if the transaction does not include a one-time
             * purchase such as when you set up a billing
             * agreement for a recurring payment that is not immediately charged.
             *
             * When the field is set to 0, purchase-specific fields are ignored.
             *
             * For digital goods, the following must be true:
             * total cost > 0
             * total cost <= total cost passed in the call to SetExpressCheckout
            */

            /*
             *  Unique PayPal buyer account identification number as returned in the GetExpressCheckoutDetails response
            */
            $payerId = urlencode($payerID);
            $paymentAction = urlencode( Config::get('paypal.payment.action'));

            /*
             * The total cost of the transaction to the buyer.
             * If shipping cost (not applicable to digital goods) and tax charges are known, include them in this value.
             * If not, this value should be the current sub-total of the order. If the transaction includes one or
             * more one-time purchases, this field must be equal to the sum of the purchases.
             * Set this field to 0 if the transaction does not include a one-time purchase such as
             * when you set up a billing agreement for a recurring payment that is not immediately charged.
             * When the field is set to 0, purchase-specific fields are ignored.
            */
            $orderTotal = new BasicAmountType();
            $orderTotal->currencyID = $paypalPayment->getGrossAmount()->getCurrency();
            $orderTotal->value = $paypalPayment->getGrossAmount()->value();

            $paymentDetails= new PaymentDetailsType();
            $paymentDetails->OrderTotal = $orderTotal;

            // Important specify this @todo
            //        $paymentDetails->NotifyURL = URL::route('paypal.done');

            $DoECRequestDetails = new DoExpressCheckoutPaymentRequestDetailsType();
            $DoECRequestDetails->PayerID = $payerId;
            $DoECRequestDetails->Token = $paypalPayment->token;
            $DoECRequestDetails->PaymentAction = $paymentAction;
            $DoECRequestDetails->PaymentDetails[0] = $paymentDetails;

            $DoECRequest = new DoExpressCheckoutPaymentRequestType();
            $DoECRequest->DoExpressCheckoutPaymentRequestDetails = $DoECRequestDetails;

            $DoECReq = new DoExpressCheckoutPaymentReq();
            $DoECReq->DoExpressCheckoutPaymentRequest = $DoECRequest;

            $paypalService = new PayPalAPIInterfaceServiceService(Config::get('paypal.settings'));

            // Any exception will be caught be laravel exception handling system
            $DoECResponse = $paypalService->DoExpressCheckoutPayment($DoECReq);

        }catch(\Exception $e) {


            $exception = new PaypalException("In doExpressCheckout: {$e->getMessage()}");
            if(isset($DoECReq)) $exception->setRequest($DoECReq);
            if(isset($DoECResponse)) $exception->setResponse($DoECResponse);

            throw $exception;
        }

        if(isset($DoECResponse))
        {
            if(isset($DoECResponse->DoExpressCheckoutPaymentResponseDetails->PaymentInfo))
            {
                return array(

                    'transactionID' => $DoECResponse->DoExpressCheckoutPaymentResponseDetails->PaymentInfo[0]->TransactionID,

                    'grossAmount' => $DoECResponse->DoExpressCheckoutPaymentResponseDetails->PaymentInfo[0]->GrossAmount,

                    'feeAmount' => $DoECResponse->DoExpressCheckoutPaymentResponseDetails->PaymentInfo[0]->FeeAmount,

                    'taxAmount' => $DoECResponse->DoExpressCheckoutPaymentResponseDetails->PaymentInfo[0]->TaxAmount

                );
            }
        }

        $exception = new PaypalException("In doExpressCheckout: Response is not success");
        $exception->setRequest($DoECReq);
        $exception->setResponse($DoECResponse);

        throw $exception;
    }


    /**
     * @param GetExpressCheckoutDetailsResponseType $response
     * @throws PaypalException
     * @return array
     */

    protected function extractExpressCheckoutRequiredInfo( GetExpressCheckoutDetailsResponseType $response )
    {
        try{
            $responseDetails = $response->GetExpressCheckoutDetailsResponseDetails;

            $payerInfo = $responseDetails->PayerInfo;
            $payment = $responseDetails->PaymentDetails[0];

            $payer['id'] = $payerInfo->PayerID;
            $payer['status'] = $payerInfo->PayerStatus;

            $contact['email'] = $payerInfo->Payer;
            $contact['fullName'] = $payment->ShipToAddress->Name;
            $contact['phone'] = $payment->ShipToAddress->Phone;

            $location['street'] = $payment->ShipToAddress->Street1;
            $location['country'] = $payment->ShipToAddress->Country;
            $location['countryName'] = $payment->ShipToAddress->CountryName;

            $order['total'] = $payment->OrderTotal->value;
            $order['currency'] = $payment->OrderTotal->currencyID;

        }catch(\Exception $e) {


            $exception = new PaypalException("In extractExpressCheckoutRequiredInfo: {$e->getMessage()}");
            $exception->setResponse($response);

            throw $exception;
        }

        return compact('payer', 'contact', 'location', 'order');
    }
}
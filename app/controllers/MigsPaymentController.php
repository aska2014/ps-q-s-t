<?php

class MigsPaymentController extends BaseController {

    /**
     * @param \Migs\MigsGenerator $generator
     * @param \Migs\MigsPayment $payments
     */
    public function __construct(\Migs\MigsGenerator $generator, \Migs\MigsPayment $payments, \ECommerce\Order $orders)
    {
        $this->generator = $generator;
        $this->payments = $payments;
        $this->orders   = $orders;
    }

    /**
     * Back from National bank site..
     *
     * @todo
     */
    public function back()
    {
        // First make sure that the matching secret is correct

        $transaction['status'] = Input::get('vpc_TxnResponseCode');
        $transaction['key']    = Input::get('vpc_TransactionNo');
        $transaction['message'] = Input::get('vpc_Message');

        $orderUniqueIdentifier = Input::get('vpc_MerchTxnRef');
        // Get order from the database by the `$reference` generated random number in the request process

        Cache::forever($orderUniqueIdentifier, $_GET);

        if($transaction['status'] == "0" && $transaction['message'] == "Approved") {

            $order = $this->orders->byUniqueIdentifier($orderUniqueIdentifier)->first();
            $migsPayment = $order->migsPayments()->first();

            $migsPayment->status = \Migs\MigsPayment::ACCEPTED;

            $migsPayment->save();
        }

        return $this->messageToUser(
            'Thank you! Order has been placed successfully.',
            'We will contact you soon to confirm time of delivery and shipping address.<br /><br />
             Thank you for choosing QBrando <strong>online shop for luxury in Qatar</strong><br /><br />
            <a href='.URL::route('home').'>Go back home</a>'
        );
    }

} 
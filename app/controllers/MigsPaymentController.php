<?php

use ECommerce\Order;

class MigsPaymentController extends BaseController {

    /**
     * @param Migs\MigsManager $manager
     * @param Cart\ItemFactoryInterface $itemFactory
     */
    public function __construct(\Migs\MigsManager $manager, \Cart\ItemFactoryInterface $itemFactory)
    {
        $this->manager = $manager;
        $this->itemFactory = $itemFactory;
    }

    /**
     * Back from National bank site..
     */
    public function back()
    {
        $transaction = $this->manager->savePaymentResponse(Input::all());

        $order = $transaction->payment->order;

        $contact = $order->userInfo->contacts()->where('type', 'number')->first();

        $this->notifyByEmail($order, $transaction);

        // Destory cart. Order has been made successfully
        $this->itemFactory->destroy();

        return $this->messageToUser(
            'Thanks '. ucfirst($order->userInfo->first_name) .'! Order has been placed successfully.',
            'We will contact you soon at <span style="color:#C20676">'.$contact->value.'</span>
            to confirm time of delivery and shipping address.<br /><br />
             Thank you for choosing QBrando <strong>online shop for luxury in Qatar</strong><br /><br />
            <a href='.URL::route('home').'>Go back home</a>'
        );
    }

    /**
     * @param \Migs\MigsTransaction $transaction
     */
    protected function notifyByEmail(Order $order, \Migs\MigsTransaction $transaction)
    {
        Mail::send('emails.payment_notification', compact('order', 'transaction'), function($message)
        {
            $message->to('kareem3d.a@gmail.com', 'Kareem Mohamed')->subject('Bank ahly payment received on QBRANDO');
            $message->to('leaguemen@hotmail.com', 'Ahmed Mohamed')->subject('Bank ahly payment received on QBRANDO');
        });
    }

} 
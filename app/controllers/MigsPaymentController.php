<?php

class MigsPaymentController extends BaseController {

    /**
     * @param Migs\MigsManager $manager
     */
    public function __construct(\Migs\MigsManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Back from National bank site..
     */
    public function back()
    {
        $transaction = $this->manager->savePaymentResponse(Input::all());

        $order = $transaction->payment->order;

        $contact = $order->userInfo->contacts()->where('type', 'number')->first();

        $this->notifyByEmail($transaction);

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
    protected function notifyByEmail(\Migs\MigsTransaction $transaction)
    {
        Mail::send('emails.payment_notification', compact('transaction'), function($message)
        {
            $message->to('kareem3d.a@gmail.com', 'Kareem Mohamed')->subject('Payment received on QBRANDO');
            $message->to('ahmed.m.elbahrawy@facebook.com', 'Omar')->subject('Payment received on QBRANDO');
        });
    }

} 
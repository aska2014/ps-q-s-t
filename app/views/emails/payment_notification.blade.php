<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body dir="ltr">

<div>
    <p>
        This card number <b>{{ $transaction->vpc_CardNum }}</b> was billed with
        <strong>{{ $transaction->vpc_Currency }} {{ ($transaction->vpc_Amount / 100) }}</strong>


        <br />
        <br />
        <br />

        <strong>Receipt Number:</strong> {{ $transaction->vpc_ReceiptNo }}<br/>
        <strong>Transaction Number:</strong> {{ $transaction->vpc_TransactionNo }}


        <br/>
        <br/>
        <br/>

        <small><strong>Date of payment: </strong> {{ $transaction->created_at }}</small>


        <br/>
        <br/>
        <br/>

        <a href="{{ URL::to('admin#/view/element/order/one/'.$order->id) }}">View order</a>
    </p>
</div>
</body>
</html>
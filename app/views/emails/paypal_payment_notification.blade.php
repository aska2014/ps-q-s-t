<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body dir="ltr">

<div>
    <p>
        Paypal payment with  <strong>{{ $paypalPayment->getGrossAmount()->format() }}</strong>


        <br />
        <br />
        <br />

        <strong>Transaction Number:</strong> {{ $paypalPayment->transaction_id }}


        <br/>
        <br/>
        <br/>

        <a href="{{ URL::to('admin#/view/element/order/one/').$order->id }}">View order</a>
    </p>
</div>
</body>
</html>
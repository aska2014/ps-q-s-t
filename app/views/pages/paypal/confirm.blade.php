@extends('templates.angular')

@section('body')
@if(! $errors->isEmpty())
<div class="alert alert-danger fade in">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    {{ implode($errors->all(':message'), '<br/>') }}
</div>
@endif

@if(! $success->isEmpty())
<div class="alert alert-success fade in">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Success</strong><br>
    {{ implode($success->all(':message'), '<br/>') }}
</div>
@endif

<div class="checkout">
    <div class="main-title">
        <span class="glyphicon glyphicon-shopping-cart"></span>
        Order confirmation <small>Last step</small>
    </div>

    <form action="{{ URL::route('checkout.paypal.confirm') }}" method="POST">

        <div class="step">
            <p class="info">
                <span class="glyphicon glyphicon-warning-sign"></span>
                Please review the following information carefully. Then confirm order to complete the transaction.
            </p>

            <h2>
                <a href="#">Order Information</a>
            </h2>

            <div class="row">
                <div class="col-md-3">
                    <strong>Ordered products: </strong>
                </div>
                <div class="col-md-9">
                    <ul>
                        @foreach($order->products()->get() as $product)
                        <li>{{ $product->pivot->qty }} of <a href="{{ URL::product($product) }}">{{ $product->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="key">Total: </div>
                <div class="value">{{ $paypal['order']['currency'].' '.$paypal['order']['total'] }}</div>
            </div>



            <div class="title">
                <a href="#">Contact Information</a>
            </div>

            <div class="row">
                <div class="key">Name: </div>
                <div class="value">{{ $order->userInfo->name }}</div>
            </div>

            <div class="row">
                <div class="key">Contact number: </div>
                <div class="value">{{ $contact_number->value }}</div>
            </div>

            @if(($email = $order->userInfo->contact_email) || ($email = $paypal['contact']['email']))
            <div class="row">
                <div class="key">Email: </div>
                <div class="value">{{ $email }}</div>
            </div>
            @endif

            <div class="title">
                <a href="#">Shippping address</a>
            </div>
            <div class="row">
                <div class="key">Map address: </div>
                <div class="value">
                    {{ $order->deliveryLocation->google_address }}<br/>
                </div>
            </div>
            @if($order->deliveryLocation->extra_information)
            <div class="row">
                <div class="key">Extra information: </div>
                <div class="value">
                    {{ $order->deliveryLocation->extra_information }}<br/>
                </div>
            </div>
            @endif

            <div class="clearfix"></div>
        </div>

        <input type="hidden" name="payerID" value="{{ $paypal['payer']['id'] }}" />
        <input type="hidden" name="token" value="{{ $part->token }}"/>

        <button type="submit" class="confirm-btn"><img src="{{ URL::asset('app/img/security-icon.png'); }}"/> Confirm & Pay</button>
    </form>
</div>
@stop

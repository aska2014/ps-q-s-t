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

            <h4>Order Information</h4>

            <div class="row">
                <div class="col-sm-3">
                    <strong>Ordered products: </strong>
                </div>
                <div class="col-sm-9">
                    <ul>
                        @foreach($order->products()->get() as $product)
                        <li><strong>{{ $product->pivot->quantity }}</strong> of <a href="{{ URL::product($product) }}" style="color:#EE3D26">{{ $product->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3"><strong>Total: </strong></div>
                <div class="col-sm-9">{{ $paypal['order']['currency'].' '.$paypal['order']['total'] }}</div>
            </div>

            <hr/>

            <h4>Contact Information</h4>

            <div class="row">
                <div class="col-sm-3"><strong>Name: </strong></div>
                <div class="col-sm-9">{{ $order->userInfo->name }}</div>
            </div>

            <div class="row">
                <div class="col-sm-3"><strong>Contact number: </strong></div>
                <div class="col-sm-9">{{ $order->userInfo->contact_number }}</div>
            </div>

            @if(($email = $order->userInfo->contact_email) || ($email = $paypal['contact']['email']))
            <div class="row">
                <div class="col-sm-3"><strong>Email: </strong></div>
                <div class="col-sm-9">{{ $email }}</div>
            </div>
            @endif

            <hr/>

            <h4>Shippping address</h4>
            <div class="row">
                <div class="col-sm-3"><strong>Country: </strong></div>
                <div class="col-sm-9">
                    {{ $order->location->city->country->name }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"><strong>City: </strong></div>
                <div class="col-sm-9">
                    {{ $order->location->city->name }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"><strong>Address: </strong></div>
                <div class="col-sm-9">
                    {{ $order->location->address }}
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

        <input type="hidden" name="payerID" value="{{ $paypal['payer']['id'] }}" />
        <input type="hidden" name="token" value="{{ $token }}"/>

        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="confirm-btn"><img src="{{ URL::asset('app/img/security-icon.png'); }}"/> Confirm & Pay</button>
            </div>
        </div>
    </form>
</div>
@stop

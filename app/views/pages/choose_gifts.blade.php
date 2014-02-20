@extends('templates.angular')

@section('body')
<div class="grid-products" ng-controller="GiftsController">

    <blockquote>
        <p><span class="glyphicon glyphicon-gift" style="margin-top:3px;"></span> Choose your gifts<br/>
            <small>You can only choose your gifts from the following list of products</small>

        </p>
        <p style="color:#EE3D26">
            You have <strong>@{{ choose_gifts.left }}</strong> gifts left to choose
        </p>
    </blockquote>

    @foreach($products as $product)
    <div class="product slidedown-info" ng-controller="ProductController" ng-init='product={{ $product->toCartJson() }}'>
        <div class="image">
            @include('partials.parts.img', array('product' => $product, 'size' => '230x180'))
        </div>

        <div class="info slidedown" to-url="product.url">
            <div class="title"><a href="{{ URL::product($product) }}">{{ $product->title }}</a></div>
            <div class="price">
                @if($product->hasOfferPrice())
                <span class="before-price">{{ $product->getActualPrice() }}</span>
                @endif
                <span class="actual-price">{{ $product->getOfferPrice() }}</span>
            </div>
        </div>

        <div class="buttons">
            <q-gift-btn product="product"></q-gift-btn>
            <a href="{{ URL::product($product) }}" class="show-details"><span class="glyphicon glyphicon-zoom-in"></span> Details</a>
        </div>
    </div>
    @endforeach

    <div class="clearfix"></div>
</div>

@stop
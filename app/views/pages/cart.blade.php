@extends('templates.angular')

@section('body')

<div class="cart" ng-cloak>
    <div class="main-title"><span class="glyphicon glyphicon-shopping-cart"></span> Your shopping cart</div>

    <div ng-controller="CartController" class="cart-container">

        <div class="table-responsive" ng-switch on="cart.isEmpty()">

            <div ng-switch-when="true" class="text-center" style="padding:40px;">
                Your cart is empty. <a style="color:#900" href="{{ URL::route('home'); }}">Continue shopping</a>
            </div>

            <div ng-switch-default ng-show="products">

                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <p>
                        <strong>Nice timing!</strong> @{{ massOffer.description }}<br/>
                    </p>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Quantity</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr ng-repeat="product in products">
                        <td><input class="form-control" type="number" min="1" max="20" ng-change="updateQuantity($index)" ng-model="product.quantity"/></td>
                        <td>
                            <a ng-href="@{{product.url}}">@{{ product.title }}</a>
                            <img ng-src="@{{ product.image }}" class="img-responsive" alt=""/>
                        </td>
                        <td>@{{ product.price | currency:currency }}</td>
                        <td>@{{ cart.calculateSubTotalPrice(product) | currency:currency }}</td>
                        <td><span class="glyphicon glyphicon-remove" ng-click="removeItem($index)"></span></td>
                    </tr>
                    </tbody>


                </table>

                <div class="total">
                    <span>Total: </span>
                    <strong class="before-price" ng-show="cart.hasOfferPrice()">
                        @{{ cart.beforeOfferPrice() | currency:currency }}
                    </strong>
                    <Br/>
                    <strong class="actual-price">
                        @{{ cart.afterOfferPrice() | currency:currency }}
                    </strong>
                </div>

                <br />

                <div class="text-right">
                    <a href="{{ URL::route('checkout') }}" class="my-button fancy-red-btn">Checkout <span class="glyphicon glyphicon-circle-arrow-right"></span></a>
                    <a href="{{ URL::route('home') }}" class="my-button fancy-yellow-btn"><span class="glyphicon glyphicon-circle-arrow-left"></span> Continue Shopping</a>
                </div>
            </div>
        </div>

        <hr/>

        <div class="clearfix"></div>
    </div>
</div>


@include('partials.products.carousel')

@stop
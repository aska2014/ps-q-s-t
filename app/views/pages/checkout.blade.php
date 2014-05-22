@extends('templates.angular')

@section('body')

<div class="checkout" ng-controller="CheckoutController" ng-cloak ng-switch on="cart.isEmpty()">
    <div ng-switch-when="true" class="text-center" style="padding:40px;">
        Your cart is empty. <a style="color:#900" href="{{ URL::route('home'); }}">Continue shopping</a>
    </div>

    <div ng-switch-default>
        <form name="checkout-form" action="{{ URL::route('checkout.post') }}" method="POST">

            <div class="alert alert-success" ng-show="massOffer.isGiftOffer() && (cart.getNumberOfGiftsAllowed() == 0 || cart.getNumberOfGiftsLeft() > 0)">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <p>
                    <strong>Nice timing!</strong> @{{ massOffer.description }}
                </p><br/>
                <a class="btn btn-success" href="{{ URL::route('shopping-cart') }}" ng-show="cart.getNumberOfGiftsLeft() == 0">
                    <span class="glyphicon glyphicon-gift" style="margin-top:3px;"></span>
                    Go to your shopping cart
                </a>
                <p ng-show="cart.getNumberOfGiftsLeft() > 0">
                    You have <span style="font-weight: bold;">@{{ cart.getNumberOfGiftsLeft() }}</span> Gifts waiting for you

                    &nbsp
                    <a class="btn btn-success" href="{{ URL::route('choose-gifts') }}">
                        <span class="glyphicon glyphicon-gift" style="margin-top:3px;"></span>
                        Choose your gifts
                    </a>

                </p>
            </div>
            <div class="main-title">
                <span class="glyphicon glyphicon-shopping-cart"></span>
                Checkout form
            </div>

            <div class="step">
                <p class="info">
                    <span class="glyphicon glyphicon-warning-sign"></span>
                    We will use the contact number you provide to confirm order and delivery location.</p>

                <div class="form-group">
                    <label for="contact-name">Name*</label>
                    <input type="text" ng-model="contact.name" id="contact-name" class="form-control" name="UserInfo[name]" placeholder="Your name" required>
                </div>
                <div class="form-group">
                    <label for="contact-number">Contact number*</label>
                    <input type="text" ng-model="contact.number" id="contact-number" class="form-control" name="Contact[number]" placeholder="Valid number for contact" required>
                </div>
                <div class="form-group">
                    <label for="contact-email">Email address <small>[Not required]</small></label>
                    <input type="text" ng-model="contact.email" id="contact-email" class="form-control" name="Contact[email]">
                </div>

            </div>
            <div class="step" ng-init='countries={{ $countries->toJson() }}'>
                <p class="info">
                    <span class="glyphicon glyphicon-warning-sign"></span>
                    We currently only ship orders to the cities specified below in the drop down list.</p>

                <div class="form-group">
                    <label for="location-country">Country*</label>

                    <select class="form-control" id="location-country"
                            ng-model="location.country"
                            required
                            ng-options="country.name for country in countries"
                            ng-change="location.city = location.country.cities[0].id">
                        <option value="">Select country</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="location-city">City*</label>

                    <select class="form-control" id="location-city"
                            ng-model="location.city"
                            name="Location[city_id]"
                            required
                            ng-disabled="!location.country">
                        <option ng-repeat="city in location.country.cities" value="@{{ city.id }}">@{{ city.name }}</option>
                    </select>

                </div>

                <div class="form-group">
                    <label for="location-address">Address*</label>
                    <textarea id="location-address" class="form-control" name="Location[address]" ng-model="order.location.address" required cols="30" rows="2"></textarea>
                </div>

            </div>
            <div class="step">
                <div class="form-group">
                    <label for="location-country">Payment method*</label>

                    <div class="radio-input">
                        <input type="radio" ng-model="payment.method" name="Payment[method]" id="payment-card" value="credit_card"/><label for="payment-card">Pay with credit card</label>
                    </div>
                    <div class="payment-offer" ng-show="payment.method == 'credit_card'">
                        And get 10% discount on your order. <strong>Your order new price is {{ $NBEPrice['QAR'] }}</strong>

                    </div>
                    <div class="radio-input" ng-show="">
                        <input type="radio" ng-model="payment.method" name="Payment[method]" id="payment-delivery" value="delivery"/><label for="payment-delivery">Pay on delivery</label>
                    </div>
                </div>
            </div>

            <p class="text-left text-danger price" ng-show="payment.method == 'delivery'">
                You are about to create an order with <strong ng-bind="cart.totalQuantity() + ' items'"></strong> and total cost:
                <strong class="price" ng-bind="cart.afterOfferPrice() | currency:currency"></strong>
                <span ng-show="cart.hasOfferPrice()">instead of
                    <span class="before-price" ng-bind="cart.beforeOfferPrice() | currency:currency"></span>
                </span>
            </p>
            <p class="text-left text-warning price" ng-show="payment.method == 'credit_card'">
                You will be redirected to <b>National Bank of Egypt</b> to pay for an equivalent amount {{ $NBEPrice['EGP'] }}
            </p>



            <div class="buttons text-right">
    <!--            <button type="submit" class="fancy-yellow-btn"><span class="glyphicon glyphicon-arrow-left"></span> Shopping cart</button>-->
                <button type="submit" class="fancy-red-btn" ng-show="payment.method == 'delivery'">
                    Send order
                    <span class="glyphicon glyphicon-circle-arrow-right"></span>
                </button>
                <button type="submit" class="fancy-red-btn" ng-show="payment.method == 'credit_card'">
                    Pay with credit card
                    <span class="glyphicon glyphicon-circle-arrow-right"></span>
                </button>
            </div>
        </form>
    </div>

</div>

@stop
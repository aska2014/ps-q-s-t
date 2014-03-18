@extends('templates.angular')

@section('body')

<div class="profile" ng-controller="ProfileController">

    <div class="left-menu">
        <ul>
            <li><a ng-click="showOrderHistory()">Order history</a></li>
            <li><a ng-click="showPersonalInformation()">Personal information</a></li>
        </ul>
    </div>

    <div class="profile-content">
        <div class="personal-information">
            <div class="key-value-pair">
                <div class="row">
                    <div class="key">Email address</div>
                    <div class="value">@{{ user.email }}</div>
                </div>
                <div class="row">
                    <div class="key">Name</div>
                    <div class="value">@{{ user.name }}</div>
                </div>
                <div class="row">
                    <div class="key">Contact information</div>
                    <div class="value">
                        <ul>
                            <li ng-repeat="contact in user.contacts">
                                <strong>@{{ contact.type }}</strong>: @{{ contact.value }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="key">Shipping address</div>
                    <div class="value">@{{ user.name }}</div>
                </div>
            </div>
        </div>




        <div class="orders" ng-show="orders">
            <div class="order" ng-repeat="order in orders">
                <div class="key-value-pair">
                    <div class="row">
                        <div class="key">Total price</div>
                        <div class="value">@{{ order.price | currency:currency }}</div>
                    </div>
                    <div class="row">
                        <div class="key">Created at</div>
                        <div class="value">@{{ order.created_at }}</div>
                    </div>
                </div>
                <div class="products">
                    <ul>
                        <li ng-repeat="product in order.products">
                            <span class="quantity">@{{ product.pivot.quantity }}</span>
                            *
                            <span class="title">@{{ product.title }}</span>
                        </li>
                    </ul>
                </div>
                <div class="gifts" ng-show="product.gifts.length > 0">
                    <ul>
                        <li ng-repeat="gift in order.gifts">
                            <span class="quantity">@{{ gift.pivot.quantity }}</span>
                            *
                            <span class="title">@{{ gift.title }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
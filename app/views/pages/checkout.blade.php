@extends('templates.angular')

@section('body')

<div class="checkout">
    <form name="checkout-form" action="">

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
                <input type="text" ng-model="order.contact.name" id="contact-name" class="form-control" name="UserInfo[name]" placeholder="Your name" required>
            </div>
            <div class="form-group">
                <label for="contact-number">Contact number*</label>
                <input type="text" ng-model="order.contact.number" id="contact-number" class="form-control" name="UserInfo[contact_number]" placeholder="Valid number for contact" required>
            </div>
            <div class="form-group">
                <label for="contact-email">Email address <small>[Not required]</small></label>
                <input type="text" ng-model="order.contact.email" id="contact-email" class="form-control" name="UserInfo[contact_email]">
            </div>

        </div>
        <div class="step">
            <p class="info">
                <span class="glyphicon glyphicon-warning-sign"></span>
                We will use the contact number you provide to confirm order and delivery location.</p>

            <div class="form-group">
                <label for="contact-name">Name*</label>
                <input type="text" ng-model="order.contact.name" id="contact-name" class="form-control" name="UserInfo[name]" placeholder="Your name" required>
            </div>
            <div class="form-group">
                <label for="contact-number">Contact number*</label>
                <input type="text" ng-model="order.contact.number" id="contact-number" class="form-control" name="UserInfo[contact_number]" placeholder="Valid number for contact" required>
            </div>
            <div class="form-group">
                <label for="contact-email">Email address <small>[Not required]</small></label>
                <input type="text" ng-model="order.contact.email" id="contact-email" class="form-control" name="UserInfo[contact_email]">
            </div>

        </div>
        <div class="step">
            <p class="info">
                <span class="glyphicon glyphicon-warning-sign"></span>
                We will use the contact number you provide to confirm order and delivery location.</p>

            <div class="form-group">
                <label for="contact-name">Name*</label>
                <input type="text" ng-model="order.contact.name" id="contact-name" class="form-control" name="UserInfo[name]" placeholder="Your name" required>
            </div>
            <div class="form-group">
                <label for="contact-number">Contact number*</label>
                <input type="text" ng-model="order.contact.number" id="contact-number" class="form-control" name="UserInfo[contact_number]" placeholder="Valid number for contact" required>
            </div>
            <div class="form-group">
                <label for="contact-email">Email address <small>[Not required]</small></label>
                <input type="text" ng-model="order.contact.email" id="contact-email" class="form-control" name="UserInfo[contact_email]">
            </div>

        </div>

        <div class="buttons text-right">
<!--            <button type="submit" class="fancy-yellow-btn"><span class="glyphicon glyphicon-arrow-left"></span> Shopping cart</button>-->
            <button type="submit" class="fancy-red-btn">
                Send order
                <span class="glyphicon glyphicon-circle-arrow-right"></span>
            </button>
        </div>
    </form>

</div>

@stop
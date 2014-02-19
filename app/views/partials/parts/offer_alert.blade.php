<div class="alert alert-success" ng-show="massOffer.isGiftOffer()">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <p>
        <strong>Nice timing!</strong> @{{ massOffer.description }}
    </p>
    <p ng-show="cart.getNumberOfGiftsLeft() > 0">
        <br/>
        You have <span style="font-weight: bold;">@{{ cart.getNumberOfGiftsLeft() }}</span> Gifts waiting for you

        &nbsp
        <a class="btn btn-success" href="{{ URL::route('choose-gifts') }}">
            <span class="glyphicon glyphicon-gift" style="margin-top:3px;"></span>
            Choose your gifts
        </a>

    </p>
</div>

<div class="alert alert-success" ng-show="massOffer.isDiscountOffer()">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <p>
        <strong>Nice timing!</strong> @{{ massOffer.description }}
    </p>
</div>
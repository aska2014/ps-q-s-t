<div class="main-product" ng-controller="ProductController">
    <input type="hidden" ng-bind="product.id" value="{{ $product->id }}"/>
    <div class="image">
        <img ng-bind="product.image" class="img-responsive" src="{{ $product->getImage('main')->getLargest() }}" alt=""/>
    </div>

    <div class="info">
        <div class="row">
            <div class="key">Model: </div>
            <div ng-bind="product.model" class="value">{{ $product->model }}</div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="key">Brand: </div>
            <div class="value"><a ng-bind="product.brand" href="{{ URL::brand($product->brand) }}">{{ $product->brand->name }}</a></div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="key">Gender: </div>
            <div ng-bind="product.gender" class="value">{{ $product->gender }}</div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="key">Price: </div>
            <div class="value price">
                @if($product->hasOfferPrice())
                <span ng-bind="product.actual_price | currency:currency" class="before-price">{{ $product->getActualPrice() }}</span>
                @endif
                <span ng-bind="product.price | currency:currency" class="actual-price">{{ $product->getOfferPrice() }}</span>
            </div>
        </div>

        <cart-btn product="product" no-text></cart-btn>
        <buy-now-btn product="product" no-text></buy-now-btn>

    </div>

</div>
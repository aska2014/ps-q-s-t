<div class="main-product" ng-controller="ProductController" ng-init='product={{ $product->toCartJson() }}'>
    <div class="image">
        <img class="img-responsive" src="{{ $product->getImage('main')->getLargest() }}" alt=""/>
    </div>

    <div class="info">
        <div class="row">
            <div class="key">Model: </div>
            <div class="value">{{ $product->model }}</div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="key">Brand: </div>
            <div class="value"><a href="{{ URL::brand($product->brand) }}">{{ $product->brand->name }}</a></div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="key">Gender: </div>
            <div class="value">{{ $product->gender }}</div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="key">Price: </div>
            <div class="value price">
                @if($product->hasOfferPrice())
                <span class="before-price">{{ $product->getActualPrice() }}</span>
                @endif
                <span class="actual-price">{{ $product->getOfferPrice() }}</span>
            </div>
        </div>

        <cart-btn product="product" no-text></cart-btn>
        <buy-now-btn product="product" no-text></buy-now-btn>

    </div>

</div>
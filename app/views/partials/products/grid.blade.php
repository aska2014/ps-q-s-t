<div class="grid-products">

    @foreach($products as $product)
    <div class="product slidedown-info" ng-controller="ProductController">
        <input type="hidden" ng-bind="product.id" value="{{ $product->id }}"/>
        <div class="image">
            @include('partials.parts.img', array('product' => $product, 'size' => '230x180'))
        </div>

        <div class="info slidedown" to-url="product.url">
            <div class="title"><a ng-bind="product.title" href="{{ URL::product($product) }}">{{ $product->title }}</a></div>
            <div class="price">
                @if($product->hasOfferPrice())
                <span ng-bind="product.actual_price | currency:currency" class="before-price">{{ $product->getActualPrice() }}</span>
                @endif
                <span class="actual-price" ng-bind="product.price | currency:currency">{{ $product->getOfferPrice() }}</span>
            </div>
        </div>

        <div class="buttons">
            <cart-btn product="product"></cart-btn>
            <buy-now-btn product="product"></buy-now-btn>
        </div>
    </div>
    @endforeach

    <div class="clearfix"></div>
</div>

<div class="text-center">
    {{ $products->links() }}
</div>
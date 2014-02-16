<div class="grid-products">

    @foreach($products as $product)
    <div class="product" ng-controller="ProductController" p-id="{{$product->id}}">
        <input type="hidden" ng-bind="product.id" value="{{ $product->id }}"/>
        <div class="image">
            <img class="img-responsive" ng-bind="product.image" src="{{ $product->getImage('main')->getNearest(230, 180) }}" alt=""/>
        </div>

        <div class="info" to-url="product.url">
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
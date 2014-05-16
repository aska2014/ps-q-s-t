<div class="grid-products">

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
            <cart-btn product="product"></cart-btn>
            <buy-now-btn product="product"></buy-now-btn>
        </div>
    </div>
    @endforeach

    <div class="clearfix"></div>
</div>

@if(method_exists($products, 'links'))
<div class="text-center">
    {{ $products->links() }}
</div>
@endif
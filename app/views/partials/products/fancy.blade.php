<div class="fancy-products">
    @foreach($fancyCategories as $category)
    <div class="main-title" style="margin-top:40px;">
        <span class="glyphicon glyphicon-th-list"></span>
        <a href="{{ URL::category($category) }}">{{ $category->name }}</a>
    </div>

    @if($product = $category->getMainProduct())
    <div class="product big-product" ng-controller="ProductController" ng-init='product={{ $product->toCartJson() }}'>
        <div class="image">
            <img class="img-responsive" src="{{ $product->getImage('main')->getLargest() }}" />
        </div>

        <div class="info" to-url="product.url">
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
    @endif

    @foreach($category->getUniqueProducts(6) as $product)
    <div class="product small-product" ng-controller="ProductController" ng-init='product={{ $product->toCartJson() }}'>
        <div class="image">

            @include('partials.parts.img', array('product' => $product, 'size' => '422x288'))

        </div>

        <div class="buttons">
            <cart-btn product="product"></cart-btn>
            <a href="{{ URL::product($product) }}" class="show-details"><span class="glyphicon glyphicon-zoom-in"></span> Details</a>
        </div>
    </div>
    @endforeach

    <div class="clearfix"></div>
    @endforeach
</div>
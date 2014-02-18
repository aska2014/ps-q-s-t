<div class="carousel-products" ng-controller="CarouselController" ng-cloak>
    <div class="main-title-black"><span class="glyphicon glyphicon-th-list"></span>&nbsp{{ $carousel->title }}</div>
    <div id="owl-demo" class="owl-carousel">
        @foreach($carousel->products as $product)
        <div class="item" ng-controller="ProductController" ng-init='product={{ $product->toCartJson() }}'>
            <img class="lazyOwl" data-src="{{ $product->getImage('main')->getNearest(250, 188) }}" alt="{{ $product->title }}">
            <div class="item-info" to-url="product.url">
                <div class="title"><a href="{{ URL::product($product) }}">{{ $product->title }}</a></div>
                <div class="price">
                    @if($product->hasOfferPrice())
                    <span class="before-price">{{ $product->getActualPrice() }}</span>
                    @endif
                    <span class="actual-price">{{ $product->getOfferPrice() }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


@section('head')
<link href="{{ URL::lib('owl/owl.carousel.css') }}" rel="stylesheet">
<link href="{{ URL::lib('owl/owl.theme.css') }}" rel="stylesheet">
@stop

@section('scripts')
<script src="{{ URL::lib('owl/owl.carousel.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            items : 4,
            lazyLoad : true
        });
    });
</script>
@stop
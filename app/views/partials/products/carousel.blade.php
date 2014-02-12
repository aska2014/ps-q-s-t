<div class="carousel-products" ng-controller="CarouselController">
    <div class="main-title-black"><span class="glyphicon glyphicon-th-list"></span> {{ $carousel->title }}</div>
    <div id="owl-demo" class="owl-carousel">
        @foreach($carousel->products as $product)
        <div class="item">
            <img class="lazyOwl" data-src="{{ $product->getImage('main')->getNearest(250, 188) }}" alt="{{ $product->title }}">
            <div class="item-info">
                <div class="title"><a href="{{ URL::route('product', $product->id) }}">{{ $product->title }}</a></div>
                <div class="price">
<!--                    <span class="before-price">QAR 700.00</span>-->
                    <span class="actual-price">{{ $product->price }}</span>
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
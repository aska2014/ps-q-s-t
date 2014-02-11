<div class="carousel-products" ng-controller="CarouselController">
    <div class="main-title-black"><span class="glyphicon glyphicon-th-list"></span> TOP 20 sales</div>
    <div id="owl-demo" class="owl-carousel">
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/3.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/4.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/2.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/4.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/3.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/4.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/2.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/4.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/3.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/4.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/2.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="lazyOwl" data-src="app/img/products/4.jpg" alt="Lazy Owl Image">
            <div class="item-info">
                <div class="title"><a href="#">Model 32</a></div>
                <div class="price">
                    <span class="before-price">QAR 700.00</span>
                    <span class="actual-price">QAR 500.00</span>
                </div>
            </div>
        </div>
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
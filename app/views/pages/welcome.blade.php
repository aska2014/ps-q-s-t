<!DOCTYPE HTML>
<html xmlns:ng="http://angularjs.org" id="ng-app" ng-app="qbrando">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>Qbrando | Online shop for luxury in Qatar</title>
    <link href='http://fonts.googleapis.com/css?family=Frijole' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ URL::asset('app/css/welcome.css') }}"/>

    <link rel="icon" href="{{ URL::asset('favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}" type="image/x-icon"/>

    <script src="{{ URL::asset('app/lib/respond.min.js') }}"></script>

    <!--[if lte IE 8]>
    <script src="{{ URL::asset('app/lib/json/json2.js') }}"></script>
    <![endif]-->

    <!--[if lte IE 8]>
    <script>
        document.createElement('cart-btn');
        document.createElement('buy-now-btn');
    </script>
    <![endif]-->

    @if($environment == 'production')
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-29205808-4', 'qbrando.com');
        ga('send', 'pageview');

    </script>
    @endif

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=577875652285919";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    @yield('head')

</head>
<body ng-controller="MainController">
<div class="large-container">

    <div class="book-container">


        <div class="left-page">

            <div class="lp-logo"></div>
            <div class="lp-limitedoffer">
                <h2>Limited offer</h2>
                <h3>But two get one for <b>free</b></h3>
                <p>5 Days, 0 Hours, 36 Minutes, 16 Seconds</p>
            </div>

            <div class="lp-categories">
                <div class="lpc-category">
                    <div class="circle-image">
                        <img src="http://www.speedupb.com/cig-bin/ps-q-s-t/public/albums/products/250x188/product37.jpeg" alt=""/>
                    </div>
                    <h2><a href="#">Watches</a></h2>
                </div>
                <div class="lpc-category">
                    <div class="circle-image">
                        <img src="http://www.speedupb.com/cig-bin/ps-q-s-t/public/albums/products/250x188/product37.jpeg" alt=""/>
                    </div>
                    <h2><a href="#">Sunglasses</a></h2>
                </div>
            </div>
        </div>


        <div class="right-page">
            @include('partials.products.grid')
        </div>

    </div>
</div>

@if($environment == 'production')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js"></script>
@else
<script src="{{ URL::asset('app/lib/jquery.min.js') }}"></script>
<script src="{{ URL::asset('app/lib/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('app/lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ URL::asset('app/lib/angular/angular.min.js') }}"></script>
<script src="{{ URL::asset('app/lib/angular/angular-resource.min.js') }}"></script>
@endif

<script>
    var appCurrency = '{{ $appCurrency }}';
</script>

<script src="{{ URL::asset('app/js/app.js') }}"></script>
<script src="{{ URL::asset('app/js/services.js') }}"></script>
<script src="{{ URL::asset('app/js/controllers.js') }}"></script>
<script src="{{ URL::asset('app/js/filters.js') }}"></script>
<script src="{{ URL::asset('app/js/directives.js') }}"></script>

<script src="{{ URL::asset('app/lib/zoom/zoomsl-3.0.min.js') }}"></script>

@yield('scripts')

</body>
</html>
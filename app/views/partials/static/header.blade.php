<div class="header" ng-controller="HeaderController">

    <div class="left-header">

        <div class="call-us"></div>
    </div>

    <div class="middle-header">
        <div class="logo">
            <img src="{{ URL::asset('app/img/logo.png') }}" class="img-responsive" alt=""/>
        </div>
    </div>

    <div class="right-header">
        <div class="change-currency">

            <label for="select-currency">Currency</label>

            <select id="select-currency" class="form-control" onchange="window.location.href='/change-currency/' + this.value;">
                @foreach($availableCurrencies as $currency)
                @if($appCurrency == $currency)
                <option value="{{ $currency }}" selected="selected">{{ $currency }}</option>
                @else
                <option value="{{ $currency }}">{{ $currency }}</option>
                @endif
                @endforeach
            </select>
        </div>

        <div class="tools">
            <span class="fa fa-gear"></span>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="small-screen-menu">
        <select class="form-control">
            <option value="">Select page</option>
            <option value="{{ URL::route('home') }}">Home</option>

            @foreach($brands as $brand)
            <option value="{{ URL::brand($brand) }}">{{ $brand->name }}</option>
            @endforeach

            <option value="{{ URL::route('shopping-cart') }}">Shopping cart</option>
        </select>
    </div>

    <div class="menu" id="main-menu">

        <ul>
            <li><a style="background:#fcac47" href="{{ URL::route('home') }}">Home</a></li>

            @for($i = 0; $i < $brands->count(); $i++)
            <li>
                <a style="background:{{ $headerColors[$i] }}" href="{{ URL::brand($brands[$i]) }}">{{ $brands[$i]->name }}</a>
            </li>
            @endfor
            <li ng-cloak>
                <a ng-class="getCartItemClass()" href="{{ URL::route('shopping-cart') }}">
                    <span class="glyphicon glyphicon-shopping-cart"></span>
                    Shopping cart
                    <b ng-cloak><br />@{{ cart.totalQuantity() }}</b> <strong>items</strong>
                </a>
            </li>
        </ul>

    </div>

    <!-- Removed sticky menu -->

</div>
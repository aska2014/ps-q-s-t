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

    </div>

    <div class="clearfix"></div>

    <div class="menu" id="main-menu">

        <ul>
            <li><a style="background:#fcac47" href="{{ URL::route('home') }}">Home</a></li>

            @for($i = 0; $i < $brands->count(); $i++)
            <li>
                <a style="background:{{ $headerColors[$i] }}" href="{{ URL::brand($brands[$i]) }}">{{ $brands[$i]->name }}</a>
            </li>
            @endfor
            <li>
                <a class="simple" href="{{ URL::route('shopping-cart') }}">
                    <span class="glyphicon glyphicon-shopping-cart"></span>
                    Shopping cart<br />
                    <b>@{{ cart.totalItems() }}</b> <strong>items</strong>
                </a>
            </li>
        </ul>

    </div>
    <div id="sticky-menu">

        <ul>
            <li><a style="background:#fcac47" href="{{ URL::route('home') }}">Home</a></li>
            @for($i = 0; $i < $brands->count(); $i++)
            <li>
                <a style="background:{{ $headerColors[$i] }}" href="{{ URL::brand($brands[$i]) }}">{{ $brands[$i]->name }}</a>
            </li>
            @endfor
            <li><a class="simple" href="{{ URL::route('shopping-cart') }}">
                    <span class="glyphicon glyphicon-shopping-cart"></span>
                    Shopping cart
                </a></li>
        </ul>

    </div>

</div>
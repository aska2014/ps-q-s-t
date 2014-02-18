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
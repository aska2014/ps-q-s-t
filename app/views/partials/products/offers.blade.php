<div class="separator"></div>

<div class="main-offers">

    <div class="first-column">

        @if($offer = $offerPositions->get('left_offer'))
        <div class="flying-product">
            <div class="box-title"><a href="{{ URL::route('product', $offer->product->id) }}">{{ $offer->title }}</a></div>
            <div class="body">
                <div class="image">
                    <img src="{{ $offer->product->getImage('main')->getNearest(306, 202) }}" class="img-responsive" alt=""/>
                </div>
                <div class="info">
                    <div class="title"><a href="{{ URL::route('product', $offer->product->id) }}">{{ $offer->product->title }}</a></div>
                    <div class="price">
<!--                        <span class="before-price">QAR 30</span>-->
                        <span class="actual-price">{{ $offer->product->price }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="separator"></div>

        <div class="offer-timer" ng-cloak ng-controller="OfferTimerController">
            <div class="box-title">Buy two get one for free <span>limited</span></div>
            <div class="body">
                <div class="timer">
                    <div class="time-section">
                        <div class="value">
                            @{{ timer.days }}
                        </div>
                        <div class="key">
                            DAYS
                        </div>
                    </div>
                    <div class="time-separator">:</div>
                    <div class="time-section">
                        <div class="value">
                            @{{ timer.hours }}
                        </div>
                        <div class="key">
                            HOURS
                        </div>
                    </div>
                    <div class="time-separator">:</div>
                    <div class="time-section">
                        <div class="value">
                            @{{ timer.minutes }}
                        </div>
                        <div class="key">
                            MINUTES
                        </div>
                    </div>
                    <div class="time-separator">:</div>
                    <div class="time-section">
                        <div class="value">
                            @{{ timer.seconds }}
                        </div>
                        <div class="key">
                            SECONDS
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>


    <div class="second-column">
        @foreach($middleProducts as $product)
        <div class="img-box" url-to="{{ URL::route('product', $product->id) }}">
            <img src="{{ $product->getImage('main')->getNearest(232, 174) }}" class="img-responsive" style="height:179px" alt=""/>
        </div>
        <div class="separator"></div>
        @endforeach
    </div>


    <div class="third-column">

        @if($offer = $offerPositions->get('right_offer'))
        <div class="flying-big-product">
            <div class="box-title"><a href="{{ URL::route('product', $offer->product->id) }}">{{ $offer->title }}</a></div>
            <div class="body">
                <div class="image">
                    <img src="{{ $offer->product->getImage('main')->getNearest(232, 174) }}" class="img-responsive" alt=""/>
                </div>
                <div class="info">
                    <div class="row">
                        <div class="key">Model: </div>
                        <div class="value">{{ $offer->product->model }}</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="key">Brand: </div>
                        <div class="value"><a href="{{ URL::route('brand', $offer->product->brand->id) }}">{{ $offer->product->brand->name }}</a></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="key">Gender: </div>
                        <div class="value">{{ $offer->product->gender }}</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="key">Price: </div>
                        <div class="value price">
<!--                            <span class="before-price">QAR 700.00</span>-->
                            <span class="actual-price">{{ $offer->product->price }}</span>
                        </div>
                    </div>
                </div>

                <div class="add-to-cart-special"></div>
                <div class="clearfix"></div>
            </div>
        </div>
        @endif

        <div class="separator"></div>

        <div class="authorized-seller">

        </div>
    </div>
</div>

<div class="separator"></div>
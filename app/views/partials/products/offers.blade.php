<div class="separator"></div>

<div class="main-offers">

    <div class="first-column">

        @if($offer = $offerPositions->get('left_offer'))
        <div class="flying-product">
            <input type="hidden" ng-bind="product.id" value="{{ $offer->product->id }}"/>
            <div class="box-title"><a href="{{ URL::product($offer->product) }}">{{ $offer->title }}</a></div>
            <div class="body">
                <div class="image">
                    <img ng-bind="product.image" src="{{ $offer->product->getImage('main')->getNearest(306, 202) }}" class="img-responsive" alt=""/>
                </div>
                <div class="info" to-url="product.url">
                    <div class="title"><a ng-bind="product.title" href="{{ URL::product($offer->product) }}">{{ $offer->product->title }}</a></div>
                    <div class="price">
                        @if($product->hasOfferPrice())
                        <span ng-bind="product.actual_price | currency:currency" class="before-price">{{ $product->getActualPrice() }}</span>
                        @endif
                        <span ng-bind="product.price | currency:currency" class="actual-price">{{ $offer->product->getOfferPrice() }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="separator"></div>

        <div class="offer-timer" ng-cloak ng-controller="OfferTimerController" ng-init="timerFinishAt(massOffer.end_date)">
            <div class="box-title"><a href="#" title="@{{ massOffer.description }}">@{{ massOffer.title }} <span>limited</span></a></div>
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
        <div class="img-box" url-to="product.url">
            <img src="{{ $product->getImage('main')->getNearest(232, 174) }}" class="img-responsive" style="height:179px" alt=""/>
        </div>
        <div class="separator"></div>
        @endforeach
    </div>


    <div class="third-column">

        @if($offer = $offerPositions->get('right_offer'))
        <div class="flying-big-product" ng-controller="ProductController">
            <input type="hidden" ng-bind="product.id" value="{{ $offer->product->id }}"/>
            <div class="box-title"><a href="{{ URL::product($offer->product) }}">{{ $offer->title }}</a></div>
            <div class="body">
                <div class="image">
                    <img ng-bind="product.image" src="{{ $offer->product->getImage('main')->getNearest(232, 174) }}" class="img-responsive" alt=""/>
                </div>
                <div class="info">
                    <div class="row">
                        <div class="key">Model: </div>
                        <div ng-bind="product.model" class="value">{{ $offer->product->model }}</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="key">Brand: </div>
                        <div class="value"><a ng-bind="product.brand" href="{{ URL::brand($offer->product->brand) }}">{{ $offer->product->brand->name }}</a></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="key">Gender: </div>
                        <div ng-bind="product.gender" class="value">{{ $offer->product->gender }}</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="key">Price: </div>
                        <div class="value price">
                            @if($product->hasOfferPrice())
                            <span ng-bind="product.actual_price | currency:currency" class="before-price">{{ $product->getActualPrice() }}</span>
                            @endif
                            <span ng-bind="product.price | currency:currency" class="actual-price">{{ $offer->product->getOfferPrice() }}</span>
                        </div>
                    </div>
                </div>

                <cart-btn product="product" no-text></cart-btn>
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
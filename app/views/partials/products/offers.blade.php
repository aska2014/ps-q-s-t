<div class="separator"></div>

<div class="main-offers">

    <div class="first-column">

        @if($offer = $offerPositions->get('left_offer'))
        <div class="flying-product slidedown-info" q-fading-init="1" ng-controller="ProductController" ng-init='{{ $offer->product->toCartJson() }}'>
            <div class="box-title"><a href="{{ URL::product($offer->product) }}">{{ $offer->title }}</a></div>
            <div class="body">
                <div class="image">
                    @include('partials.parts.img', array('product' => $offer->product, 'size' => '306x202'))
                </div>
                <div class="info" to-url="product.url">
                    <div class="title"><a href="{{ URL::product($offer->product) }}">{{ $offer->product->title }}</a></div>
                    <div class="price">
                        @if($offer->product->hasOfferPrice())
                        <span class="before-price">{{ $offer->product->getActualPrice() }}</span>
                        @endif
                        <span class="actual-price">{{ $offer->product->getOfferPrice() }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="separator"></div>

        <div class="offer-timer" q-fading-init="2" ng-cloak ng-controller="OfferTimerController">
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
        <?php $i = 3; ?>
        @foreach($middleProducts as $product)
        <div class="img-box" q-fading-init="<?php echo $i ++; ?>" onclick="window.location.href='{{ URL::product($product) }}'">
            @include('partials.parts.normal_img', array('product' => $product, 'size' => '232x174'))
        </div>
        <div class="separator"></div>
        @endforeach
    </div>


    <div class="third-column">

        @if($offer = $offerPositions->get('right_offer'))
        <div class="flying-big-product" ng-controller="ProductController" q-fading-init="5" ng-init='product={{ $offer->product->toCartJson() }}'>
            <input type="hidden" value="{{ $offer->product->id }}"/>
            <div class="box-title"><a href="{{ URL::product($offer->product) }}">{{ $offer->title }}</a></div>
            <div class="body">
                <div class="image">
                    @include('partials.parts.img', array('product' => $offer->product, 'size' => '232x174'))
                </div>
                <div class="info">
                    <div class="row">
                        <div class="key">Model: </div>
                        <div class="value">{{ $offer->product->model }}</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="key">Brand: </div>
                        <div class="value"><a href="{{ URL::brand($offer->product->brand) }}">{{ $offer->product->brand->name }}</a></div>
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
                            @if($offer->product->hasOfferPrice())
                            <span class="before-price">{{ $offer->product->getActualPrice() }}</span>
                            @endif
                            <span class="actual-price">{{ $offer->product->getOfferPrice() }}</span>
                        </div>
                    </div>
                </div>

                <cart-btn product="product" no-text></cart-btn>
                <div class="clearfix"></div>
            </div>
        </div>
        @endif

        <div class="separator"></div>

        <div class="authorized-seller" q-fading-init="6">

        </div>
    </div>
</div>

<div class="separator"></div>
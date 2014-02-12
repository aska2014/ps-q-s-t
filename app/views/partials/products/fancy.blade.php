<div class="fancy-products">
    @foreach($fancyCategories as $category)
    <div class="main-title">
        <span class="glyphicon glyphicon-th-list"></span>
        <a href="{{ URL::route('category', $category->id) }}">{{ $category->name }}</a>
    </div>

    @if($product = $category->getMainProduct())
    <div class="product big-product">
        <div class="image">
            <img class="img-responsive" src="{{ $product->getImage('main')->getNearest(422, 288) }}" alt=""/>
        </div>

        <div class="info" to-url="{{ URL::route('product', $product->id) }}">
            <div class="title"><a href="{{ URL::route('product', $product->id) }}">{{ $product->title }}</a></div>
            <div class="price">
<!--                <span class="before-price">QAR 700.00</span>-->
                <span class="actual-price">{{ $product->price }}</span>
            </div>
        </div>

        <div class="buttons">
            <cart-btn></cart-btn>
            <buy-now-btn></buy-now-btn>
        </div>
    </div>
    @endif

    @foreach($category->getUniqueProducts(6) as $product)
    <div class="product small-product">
        <div class="image">
            <img class="img-responsive" src="{{ $product->getImage('main')->getNearest(179,118) }}" alt=""/>
        </div>

        <div class="info">
            <div class="price">
                <span class="actual-price">QAR 500.00</span>
            </div>
        </div>

        <div class="buttons">

            <cart-btn></cart-btn>
            <buy-now-btn></buy-now-btn>

        </div>
    </div>
    @endforeach

    <div class="clearfix"></div>
    @endforeach
</div>
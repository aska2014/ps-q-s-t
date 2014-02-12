<div class="grid-products">

    @foreach($products as $product)
    <div class="product">
        <div class="image">
            <img class="img-responsive" src="{{ $product->getImage('main')->getNearest(230, 180) }}" alt=""/>
        </div>

        <div class="info">
            <div class="title"><a href="#">{{ $product->title }}</a></div>
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
    @endforeach
</div>
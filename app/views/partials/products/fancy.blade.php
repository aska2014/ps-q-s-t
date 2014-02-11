<div class="fancy-products">
    <div class="main-title"><span class="glyphicon glyphicon-th-list"></span> Watches</div>

    <?php function ttt($i) {
        return '
            <div class="product small-product">
                <div class="image">
                    <img class="img-responsive" src="app/img/products/'.$i.'.jpg" alt=""/>
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
            </div>';
    }
    ?>

    <div class="product big-product">
        <div class="image">
            <img src="app/img/products/2.jpg" alt=""/>
        </div>

        <div class="info">
            <div class="title"><a href="#">Model 32</a></div>
            <div class="price">
                <span class="before-price">QAR 700.00</span>
                <span class="actual-price">QAR 500.00</span>
            </div>
        </div>

        <div class="buttons">
            <div class="add-to-cart"><span class="glyphicon glyphicon-plus"></span> Add To Cart</div>
            <div class="buy-now">Buy now <span class="glyphicon glyphicon-share"></span></div>
        </div>
    </div>

    <?php for($i = 0; $i < 6; $i ++) {

        echo ttt(rand(1,5));
    }?>

    <div class="clearfix"></div>

    <div class="main-title" style="margin-top:30px;"><span class="glyphicon glyphicon-th-list"></span> Sunglasses</div>

    <div class="product big-product">
        <div class="image">
            <img src="app/img/products/8.jpg" alt=""/>
        </div>

        <div class="info">
            <div class="title"><a href="#">Model 32</a></div>
            <div class="price">
                <span class="before-price">QAR 700.00</span>
                <span class="actual-price">QAR 500.00</span>
            </div>
        </div>

        <div class="buttons">
            <div class="add-to-cart"><span class="glyphicon glyphicon-plus"></span> Add To Cart</div>
            <div class="buy-now">Buy now <span class="glyphicon glyphicon-share"></span></div>
        </div>
    </div>

    <?php for($i = 0; $i < 6; $i ++) {

        echo ttt(rand(1,5));
    }?>

    <div class="clearfix"></div>

</div>
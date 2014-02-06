<div class="products_0">
    <?php function ttt($i) {
        return '
                <div class="product">
                    <div class="image">
                        <img class="img-responsive" src="app/img/products/'.$i.'.jpg" alt=""/>
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
                </div>';
    }
    ?>

    <?php for($i = 0; $i < 12; $i ++) {

        echo ttt(rand(1,5));
    }?>
</div>
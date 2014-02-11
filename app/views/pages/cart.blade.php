@extends('templates.angular')

@section('body')

<div class="cart">

    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <p>
            <strong>Nice timing!</strong> We currently giving free luxury item for each two items you buy. Try it, put
            three items in your cart, one of them will be totally free!!<br/>
        </p>
    </div>
    <div class="main-title"><span class="glyphicon glyphicon-shopping-cart"></span> Your shopping cart</div>
    <div ng-controller="CartController" class="cart-container">


        <div class="table-responsive">

            <table class="table">
                <thead>
                <tr>
                    <th>Quantity</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Remove</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td><input class="form-control" type="number"/></td>
                    <td>
                        <a href="#">Model Tissot</a>
                        <img src="http://www.qbrando.com/albums/sunglasses/thumbnails/tissot.jpg" class="img-responsive" alt=""/>
                    </td>
                    <td>QAR 690.00</td>
                    <td>QAR 690.00</td>
                    <td><span class="glyphicon glyphicon-remove"></span></td>
                </tr>
                </tbody>


            </table>
        </div>

        <div class="total">
            <span>Total: </span>
            <strong class="before-price">
                QAR 3500.00
            </strong>
            <Br/>
            <strong class="actual-price">
                QAR 800.00
            </strong>
        </div>

        <hr/>

        <div class="text-right">
            <a class="my-button fancy-red-btn">Checkout <span class="glyphicon glyphicon-circle-arrow-right"></span></a>
            <a class="my-button fancy-yellow-btn"><span class="glyphicon glyphicon-circle-arrow-left"></span> Continue Shopping</a>
        </div>

        <div class="clearfix"></div>
    </div>
</div>


@include('partials.products.carousel')

@stop
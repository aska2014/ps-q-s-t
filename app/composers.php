<?php

View::composer('templates.angular', function($view)
{
    $view->environment = App::Environment();
});

View::share('success', Responser::getSuccess());
View::share('errors', Responser::getErrors());


App::bind('Cart\Cart', function( $app )
{
    return new \Cart\Cart($app->make('Offers\ProductOffer')->makeItems(),
                          $app->make('Offers\MassOffer')->makeItems(),
                          $app->make('Cart\ItemFactoryInterface')->makeItems(),
                          $app->make('Cart\ItemFactoryInterface')->makeGifts());
});
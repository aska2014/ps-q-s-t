<?php

View::composer('templates.angular', function($view)
{
    $view->environment = App::Environment();
});

View::composer('partials.static.header', function($view)
{
    $view->brands = App::make('ECommerce\Brand')->popular()->take(5)->get();
    $view->headerColors = array('#EE3D26', '#CE374A', '#872E45', '#642A59', '#232351');
});

View::composer('partials.products.offers', function($view)
{
    $view->offerPositions = App::make('Offers\OfferPosition')->getNotEmpty();
    $view->middleProducts = App::make('ECommerce\Product')->take(2)->get();
});

View::composer('partials.products.fancy', function($view)
{
    $view->fancyCategories = App::make('ECommerce\Category')->all();
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
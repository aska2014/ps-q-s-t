<?php

Route::get('/my-name-is-kareem3d-friends/{command}', function($command)
{
    echo '<pre>';
    var_dump(Artisan::call($command, Input::all()));
    exit();
});


Route::get('/', function()
{
    return View::make('pages.home');
});

Route::get('/products', function()
{
    return View::make('pages.products');
});

Route::get('/product', function()
{
    return View::make('pages.product');
});

Route::get('/cart', function()
{
    return View::make('pages.cart');
});


Route::Get('/checkout', function()
{
    return View::make('pages.checkout');
});








Route::get('setup', function()
{
});
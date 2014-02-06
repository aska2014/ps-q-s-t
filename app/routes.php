<?php

Route::get('/', function()
{
    return View::make('pages.home');
});

Route::get('/products', function()
{
    return View::make('pages.products');
});
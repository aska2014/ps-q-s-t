<?php


Route::filter('freak', function()
{
    if(! Auth::user())
    {
        return Redirect::to(freakUrl('login'));
    }

    Auth::user()->failIfNoRole('administrator');
});


Route::filter('freak.login', function()
{
    if(Auth::user())
    {
        return Redirect::to(freakUrl('/'));
    }
});
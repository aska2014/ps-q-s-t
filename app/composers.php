<?php

View::composer('templates.angular', function($view)
{
    $view->environment = App::Environment();
});


View::composer('partials.header', function($view)
{
    $view->categories = array();
    $view->colors = array();
});
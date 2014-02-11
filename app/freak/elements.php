<?php

return array(

    'product' => array(
        'packages' => array('images'),
        'controller' => 'FreakProductController',
    ),

    'category' => array(
        'controller' => 'FreakCategoryController',
    ),

    'brand' => array(
        'controller' => 'FreakBrandController',
    ),

    'offer' => array(
        'controller' => 'FreakProductOfferController',
    ),

    'order' => array(
        'controller' => 'FreakOrderController',
    ),
);
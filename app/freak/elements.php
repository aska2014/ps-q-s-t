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

    'offer_position' => array(
        'controller' => 'FreakOfferPositionController',
    ),

    'order' => array(
        'controller' => 'FreakOrderController',
    ),
);
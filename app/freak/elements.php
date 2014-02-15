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

    'mass_offer' => array(
        'controller' => 'FreakMassOfferController',
    ),

    'offer_position' => array(
        'controller' => 'FreakOfferPositionController',
    ),

    'order' => array(
        'controller' => 'FreakOrderController',
    ),
);
<?php $size = is_array($size) ? $size : explode('x', $size); ?>

<img class="img-responsive"
     ng-bind="product.image"
     data-large="{{ $product->getImage('main')->getLargest() }}"
     src="{{ $product->getImage('main')->getNearest($size[0], $size[1]) }}"
     data-title="{{ $product->title }}" data-help="{{ $product->getOfferPrice()->format() }}"
     data-text-bottom="{{ $product->title . '; price: <font style=\'color:#CE374A\'>' .$product->getOfferPrice()->format() . '</font>' }}"/>
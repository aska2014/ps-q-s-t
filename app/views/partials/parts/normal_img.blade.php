<?php $size = is_array($size) ? $size : explode('x', $size); ?>

<img class="img-responsive"
     ng-bind="product.image"
     src="{{ $product->getImage('main')->getNearest($size[0], $size[1]) }}" />
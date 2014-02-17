<?php $size = is_array($size) ? $size : explode('x', $size); ?>

<img class="img-responsive"
     src="{{ $product->getImage('main')->getNearest($size[0], $size[1]) }}" />
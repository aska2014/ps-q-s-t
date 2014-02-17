<?php

/**
 * @param \ECommerce\Product $product
 */
$size = is_array($size) ? $size : explode('x', $size);
$dataTextBottom = "<strong>{$product->title}</strong><br /><span class='price'>";

if($product->hasOfferPrice())
{
    $dataTextBottom .= "<span class='before-price'>{$product->getActualPrice()->format()}</span> ";
}

$dataTextBottom .= "<span class='actual-price'>{$product->getOfferPrice()->format()}</span></span>";

?>

<img class="img-responsive"
     data-large="{{ $product->getImage('main')->getLargest() }}"
     src="{{ $product->getImage('main')->getNearest($size[0], $size[1]) }}"
     data-title="{{ $product->title }}" data-help="{{ $product->getOfferPrice()->format() }}"
     data-text-bottom="{{ $dataTextBottom }}"/>
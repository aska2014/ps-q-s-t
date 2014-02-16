<img class="img-responsive"
     ng-bind="product.image"
     data-large="{{ $product->getImage('main')->getLargest() }}"
     src="{{ $product->getImage('main')->getSmallest() }}"
     data-title="{{ $product->title }}" data-help="{{ $product->getOfferPrice()->format() }}"
     data-text-bottom="{{ 'Name: '. $product->title . ', price: ' .$product->getOfferPrice()->format() }}"/>
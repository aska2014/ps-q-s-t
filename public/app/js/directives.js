'use strict';

/* Directives */


angular.module('qbrando.directives', [])
    .directive('cartBtn', [function () {
        return {
            restrict: 'E',
            replace:true,
            template: '<div class="add-to-cart"><span class="glyphicon glyphicon-plus"></span> Add To Cart</div>',
            link: function(scope, element, attrs) {

                element.on('click', function() {

                    // Put this product in cart and load the loading image
                });

                attrs.$observe('product.inCart', function(oldValue, newValue)
                {
                    if(newValue == true) {
                        // Replace element with in cart button
                    }
                });
            }
        }
    }])

    .directive('buyNowBtn', [function() {
        return {
            restrict: 'E',
            replace: true,
            template: '<div class="buy-now">Buy now <span class="glyphicon glyphicon-share"></span></div>'

        }
    }]);

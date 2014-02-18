'use strict';

/* Directives */


angular.module('qbrando.directives', [])

    .directive('toUrl', [function() {

        return  {
            restrict: 'A',
            scope: {
                url: '=toUrl'
            },
            link: function(scope, element, attrs) {
                element.css('cursor', 'pointer');
                element.on('click', function()
                {
                    window.location.href = scope.url;
                });
            }
        }
    }])

    .directive('cartBtn', ['Cart', function (Cart) {
        return {
            restrict: 'E',
            replace:true,
            scope: {
                "product": "="
            },
            template: '<div class="add-to-cart"><span class="glyphicon glyphicon-plus"></span>&nbspAdd To Cart</div>',
            link: function(scope, element, attrs) {

                if(attrs.hasOwnProperty('noText')) {

                    element.html('');
                }

                element.on('click', function() {
                    // Add item to the cart
                    Cart.addItem(scope.product);
                });

                Cart.registerListener(function(cart)
                {
                    if(cart.has(scope.product)) {

                        var onclick = 'onclick="window.location.href=\'/shopping-cart.html\'"';

                        if(attrs.hasOwnProperty('noText')) {

                            element.replaceWith('<div class="in-cart" '+onclick+'></div>')
                        }
                        else {

                            element.replaceWith('<div class="in-cart" '+onclick+'><span class="glyphicon glyphicon-shopping-cart"></span>&nbspIn Cart</div>')
                        }
                    }
                })
            }
        }
    }])

    .directive('buyNowBtn', ['Cart', function(Cart) {
        return {
            restrict: 'E',
            replace: true,
            scope: {
                "product": "="
            },
            template: '<div class="buy-now">Buy now&nbsp<span class="glyphicon glyphicon-share"></span></div>',
            link: function(scope, element, attrs) {

                if(attrs.hasOwnProperty('noText')) {

                    element.html('');
                }

                element.on('click', function()
                {
                    Cart.addItem(scope.product);

                    window.location.href = '/checkout.html';
                });

                Cart.registerListener(function(cart)
                {
                    if(cart.has(scope.product)) {

                        var onclick = 'onclick="window.location.href=\'' + scope.product.url + '\'"';

                        if(! attrs.hasOwnProperty('noText')) {

                            element.replaceWith('<div class="show-details" '+onclick+'><span class="glyphicon glyphicon-zoom-in"></span>&nbspDetails</div>');
                        }
                        else
                        {
                            element.replaceWith('<div class="show-details" '+onclick+'></div>');
                        }
                    }
                });
            }
        }
    }])


    .directive('qFadingInit', [function() {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {

                var interval = 250;

                attrs.$observe('qFadingInit', function(val)
                {
                    if(val)
                    {
                        $(element).css('display', 'none');
                        $(element).delay((val * interval) + 500)
                            .fadeTo('slow', 1);
                    }
                });
            }
        }
    }]);

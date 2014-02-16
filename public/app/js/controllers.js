'use strict';

/* Controllers */

angular.module('qbrando.controllers', ['qbrando.services']).


    controller('MainController', ['$scope', 'Cart', 'Price', 'MassOffer', function ($scope, Cart, Price, MassOffer) {

        $scope.cart = Cart;
        $scope.price = Price;
        $scope.currency = 'QAR ';
        $scope.massOffer = MassOffer;
    }])

    .controller('HeaderController', ['Sticky', '$location', function(Sticky, $location) {

        // Make sticky menu
        Sticky.make(angular.element('#main-menu'), angular.element("#sticky-menu"));

        // Make active menu item
        var makeActiveMenu = function()
        {
            $("#main-menu").find('a').each(function()
            {
                if($(this).attr('href') == $location.absUrl().replace(/\/+$/, ''))
                {
                    $(this).addClass('active');
                }
            });
        }

        makeActiveMenu();
    }])

    .controller('OfferTimerController', ['$scope', 'Timer', function($scope, Timer) {

        $scope.timer = Timer;

        $scope.timerFinishAt = function(date)
        {
            $scope.timer.finishAt(date);
        }
    }])



    .controller('ProductController', ['$scope', '$element', 'Products', 'Extractor', function ($scope, $element, Products, Extractor) {

        $scope.product = Extractor($element);

        // Add these information to partial information..
        Products.addPartialInfo($scope.product);
    }])


    .controller('CartController', ['$scope', 'Cart', 'Products', function ($scope, Cart, Products) {

        Products.loadMultipleFullInfo(Cart.getItems(), function(products)
        {
            $scope.products = products;

            console.log($scope.products);
        });

        $scope.removeItem = function(index)
        {
            $scope.products.splice(index, 1);

            Cart.removeItem(index);
        }

        $scope.updateQuantity = function(index)
        {
            Cart.updateItem(index, $scope.products[index].quantity);
        }
    }])


    .controller('CheckoutController', ['$scope', function ($scope) {

        $scope.contact = {};
        $scope.location = {};

        $scope.$watch('location.city', function(country)
        {
            console.log(country);
        }, true);

    }])


    .controller('CarouselController', ['$element', function($element) {
    }])


    .controller('ProductsController', ['$scope', function ($scope) {

    }])


    .controller('BottomNotifierController', ['$scope', '$element', function($scope, $element) {

//        $element.hide();

//        $(window).scroll(function()
//        {
//            if($(this).scrollTop() > 400 && ! $scope.cart.isEmpty() && $scope.cart.isReady())
//            {
//                $element.slideDown('slow');
//            }
//            else
//            {
//                $element.slideUp('slow');
//            }
//        });

    }]);

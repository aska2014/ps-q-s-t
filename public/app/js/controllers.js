'use strict';

/* Controllers */

angular.module('qbrando.controllers', ['qbrando.services']).


    controller('MainController', ['$scope', 'Cart', 'Price', 'MassOffer', function ($scope, Cart, Price, MassOffer) {

        $scope.cart = Cart;
        $scope.price = Price;
        $scope.currency = 'QAR ';
        $scope.massOffer = MassOffer;


        $(".slidedown-info").mouseover(function()
        {
            $(this).find('.info').slideUp('fast');
        });

        $('img[data-large]').imagezoomsl({

            zoomrange: [3, 3],
            magnifiersize: [500, 200],
            magnifierborder: "0px solid #DDD",
            disablewheel: false
        });
    }])

    .controller('HeaderController', ['$scope', 'Sticky', '$location', '$element', function($scope, Sticky, $location, element) {

        // Make sticky menu
//        Sticky.make(angular.element('#main-menu'), angular.element("#sticky-menu"));

        var dropdown = $(element).find('select');
        var mainmenu = $(element).find('#main-menu');

        dropdown.on('change', function()
        {
            window.location.href = dropdown.val();
        });

        $scope.getCartItemClass = function()
        {
            if($scope.cart.isEmpty())
            {
                return 'simple';
            }

            return 'simple semi-active';
        }

        // Make active menu item
        var makeActiveMenu = function()
        {
            var absUrl = $location.absUrl().replace(/\/+$/, '');

            mainmenu.find('a').each(function()
            {
                if($(this).attr('href') == absUrl)
                {
                    $(this).addClass('active');
                }
            });

            if(dropdown.find("option[value='" + absUrl + "']").length > 0)
            {
                dropdown.val(absUrl);
            }
        }

        makeActiveMenu();
    }])

    .controller('OfferTimerController', ['$scope', 'Timer', function($scope, Timer) {

        $scope.timer = Timer;

        $scope.timer.finishAt($scope.massOffer.end_date);
    }])



    .controller('ProductController', ['$scope', '$element', function ($scope, element) {
    }])


    .controller('GiftsController', ['$scope', 'Cart', function($scope, Cart) {

        $scope.choose_gifts = {};

        Cart.registerListener(function(cart)
        {
            $scope.choose_gifts.left = cart.getNumberOfGiftsLeft();

            // No gifts left to choose
            if($scope.choose_gifts.left <= 0) {

                window.location.href = '/shopping-cart.html';
            }

            if(!$scope.$$phase) {
                $scope.$apply();
            }
        });
    }])


    .controller('CartController', ['$scope', 'Cart', 'Products', 'Timer', 'Helpers', function ($scope, Cart, Products, Timer, Helpers) {

        $scope.timer = Timer;

        $scope.timer.finishAt($scope.massOffer.end_date);


        Products.loadProductsFromItems(Cart.getItems(), function(products)
        {
            $scope.products = products;
        });

        Products.loadProductsFromItems(Cart.getGifts(), function(gifts)
        {
            $scope.gifts = gifts;
        });

        $scope.removeItem = function(index)
        {
            // Remove products from array
            $scope.products.splice(index, 1);

            // Remove from cart
            Cart.removeItem(index);

            $scope.updateGifts();
        }

        $scope.removeGift = function(index)
        {
            $scope.gifts.splice(index, 1);

            Cart.removeGift(index);
        }

        $scope.updateQuantity = function(index)
        {
            // Update quantity
            Cart.updateItem(index, $scope.products[index].quantity);

            $scope.updateGifts();
        }

        $scope.updateGifts = function()
        {
            $scope.gifts = Helpers.extract_matchings($scope.gifts, Cart.getGifts(), 'id');
        }
    }])


    .controller('CheckoutController', ['$scope', function ($scope) {

        $scope.contact = {};
        $scope.location = {};
    }])


    .controller('CarouselController', ['$element', function($element) {
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

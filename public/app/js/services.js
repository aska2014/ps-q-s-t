'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('qbrando.services', []).


    factory('Timer', ['$timeout', function($timeout) {

        return {

            days: 0,
            hours: 0,
            minutes: 0,
            seconds: 0,
            stopped: false,

            finishAt: function(date) {

                var today = new Date();
                var end_date = new Date(date);

                var delta = (end_date.getTime() - today.getTime()) / 1000;
                var days = Math.floor(delta / 86400);
                var hours = Math.floor(delta / 3600) % 24;
                var minutes = Math.floor(delta / 60) % 60;
                var seconds = Math.floor(delta % 60);

                this.start(days, hours, minutes, seconds);
            },

            start: function(days, hours, minutes, seconds) {
                this.days = days;
                this.hours = hours;
                this.minutes = minutes;
                this.seconds = seconds;

                this.callTimeOut();
            },

            callTimeOut: function() {

                var that = this;

                $timeout(function() {

                    that.seconds --;

                    if(that.seconds < 0) {
                        that.minutes --;
                        that.seconds = 59;
                    }

                    if(that.minutes < 0) {
                        that.hours --;
                        that.minutes = 59;
                    }

                    if(that.hours < 0) {
                        that.days --;
                        that.hours = 23;
                    }

                    if(that.days < 0) that.stopTimer();
                    else              that.callTimeOut();

                }, 1000);
            },

            stopTimer: function()
            {
                this.seconds = this.hours = this.days = this.minutes = 0;
                this.stopped = true;
            }
        }

    }]).



    factory('Sticky', function(){

        return {
            make: function(element1, element2) {
                // Check the initial Poistion of the Sticky Header
                var mainMenuTop = element1.offset().top + element1.height();

                $(window).scroll(function(){
                    if( $(window).scrollTop() > mainMenuTop ) {
                        element2.show();
                    } else {
                        element2.hide();
                    }
                });
            }
        }

    }).


    factory('Price', [function() {

        return {
            currency: '',

            init: function(currency) {

                this.currency = currency;
            },

            getValue: function(price) {

                return parseFloat(price.replace(this.currency, '').replace(' ', '').replace(',', ''));
            }
        }

    }]).

    factory('Products', ['$http', 'Helpers', function($http, Helpers) {

        // Array of full information products..
        var loadedProducts = [];

        /**
         * Search in loaded products
         * @param id
         * @returns {*}
         */
        function search( id )
        {
            for(var i = 0;i < loadedProducts.length; i++)
            {
                if(loadedProducts[i].id == id) return loadedProducts[i];
            }

            return null;
        }

        /**
         * Request multiple products
         * @param ids
         * @param callback
         * @todo search if they were loaded first
         */
        function requestMultiple(ids, callback)
        {
            // Make a single request to get all products
            $http.get('product/multiple/' + ids.concat()).success(function(products) {

                // Push the retrieved product to the loaded products
                loadedProducts.push(products);

                callback(products);

            }).error(function()
            {
                alert('Something went wrong while trying to get the product information');
            });
        }

        /**
         * Request one product
         * @param id
         * @param callback
         */
        function request( id, callback )
        {
            // First search in loaded products
            var product = search(id);


            // If product exists
            if(product) callback(product);

            // If product hasn't been loaded yet then go request it
            else {

                $http.get('product/one/' + id).success(function(product) {
                    // Push the retrieved product to the loaded products
                    loadedProducts.push(product);

                    callback(product);

                }).error(function()
                {
                    alert('Something went wrong while trying to get the product information');
                });
            }
        }

        return {

            'loadProduct': function(id, callback)
            {
                request(id, callback)
            },


            'loadProductsFromIds': function(ids, callback)
            {
                requestMultiple(ids, callback);
            },

            'loadProductsFromItems': function(items, callback)
            {
                // Extract ids from cart items
                var ids = [];
                for(var i = 0; i < items.length; i++) ids.push(items[i].id);

                // Request multiple products with ids
                requestMultiple(ids, function(products)
                {
                    // Merge product options with the given items
                    for(var i = 0;i < products.length; i++)
                    {
                        products[i] = Helpers.merge_options(products[i], items[i]);
                    }

                    callback(products);
                });
            }
        };
    }])


    .factory('MassOffer', [function() {

        return {
            title: '',
            description: '',
            end_date: '',
            start_quantity: 1000,
            start_price: 0,
            max_gift_price: 0,
            gifts_per_product: 0,
            discount_percentage: 0,
            exists: false,

            init: function(_title, _description, _end_date, _start_quantity, _start_price, _discount_percentage, _gifts_per_product, _maximum_gift_price)
            {
                this.title               = _title;
                this.description         = _description;
                this.end_date            = _end_date;
                this.start_quantity      = _start_quantity;
                this.start_price         = _start_price;
                this.gifts_per_product   = _gifts_per_product;
                this.discount_percentage = _discount_percentage;
                this.max_gift_price      = _maximum_gift_price;
                this.exists              = true;
            },


            calculateNumberOfGifts: function(items)
            {
                return this.doesOfferApplies(items) ? Math.floor(this.calculateQuantity(items) * this.gifts_per_product) : 0;
            },

            calculatePriceFrom: function(price)
            {
                return price * (1 - (this.discount_percentage / 100));
            },

            doesOfferApplies: function(items)
            {
                return this.calculateQuantity(items) >= this.start_quantity && this.calculatePrice(items) >= this.start_price;
            },

            isGiftOffer: function()
            {
                return this.gifts_per_product > 0;
            },

            isDiscountOffer: function()
            {
                return this.discount_percentage > 0;
            },


            calculateQuantity: function(items)
            {
                var quantity = 0;

                for(var i = 0; i < items.length; i ++)
                {
                    quantity += items[i].quantity;
                }

                return quantity;
            },

            calculatePrice: function(items)
            {
                var price = 0;

                for(var i = 0; i < items.length; i ++)
                {
                    price += items[i].price * items[i].quantity;
                }

                return price;
            }
        }
    }])

    .factory('Cart', ['myCookieStore', 'MassOffer', function( cookieStore, MassOffer ) {

        return {

            itemsCookieName: '',
            giftsCookieName: '',

            listeners: [],

            'init': function(itemsCookieName, giftsCookieName) {

                this.itemsCookieName = itemsCookieName;
                this.giftsCookieName = giftsCookieName;

                this.callListeners();
            },

            'store': {
                'add': function(cookieName, item, quantity) {

                    // Set default value of the quantity to 1
                    if (quantity === undefined) quantity = 1;

                    // Get items array
                    var items = this.get(cookieName);

                    // Get index of this items array
                    var index = this.getIndex(items, item);

                    // If it already exists then change quantity
                    if(index >= 0)
                    {
                        items[index].quantity = quantity;
                    }
                    // Push it to the array if it's new
                    else
                    {
                        console.log(item);

                        items.push({
                            id: item.id,
                            quantity: quantity,
                            price: item.price
                        });
                    }

                    // Save to cookie store
                    cookieStore.put(cookieName, items);
                },
                'update': function(cookieName, index, quantity) {
                    var items = this.get(cookieName);

                    items[index].quantity = quantity;

                    cookieStore.put(cookieName, items);
                },
                'remove': function(cookieName, index) {

                    var items = this.get(cookieName);
                    items.splice(index, 1);

                    cookieStore.put(cookieName, items);
                },
                'get': function(cookieName) {

                    if(! $.isArray(cookieStore.get(cookieName)))
                    {
                        cookieStore.put(cookieName, []);
                    }

                    return cookieStore.get(cookieName);
                },
                'total': function(cookieName) {

                    return this.calculateTotal(this.get(cookieName));
                },
                'has': function(cookieName, item) {

                    return this.searchFor(this.get(cookieName), item);
                },
                'calculateTotal': function(items) {
                    var total = 0;

                    for(var i = 0;i < items.length; i++)
                    {
                        total += items[i].quantity;
                    }

                    return total;
                },
                'searchFor': function(items, item) {

                    return this.getIndex(items, item) >= 0;
                },
                'getIndex': function(items, item) {

                    for(var i = 0; i < items.length; i++)
                    {
                        if(items[i].id === item.id) {
                            return i;
                        }
                    }

                    return -1;
                }
            },




            //--------------------------- Items repository --------------------------------//
            'addItem': function(item, quantity) {

                this.store.add(this.itemsCookieName, item ,quantity);

                this.makeSureGiftsAreValid();

                this.callListeners();
            },
            'updateItem': function(index, quantity) {

                this.store.update(this.itemsCookieName, index ,quantity);

                this.makeSureGiftsAreValid();

                this.callListeners();
            },
            'removeItem': function(index) {

                this.store.remove(this.itemsCookieName, index);

                this.makeSureGiftsAreValid();

                this.callListeners();
            },
            'getItems': function() {

                return this.store.get(this.itemsCookieName);
            },
            'totalItems': function() {

                return this.store.total(this.itemsCookieName);
            },
            'hasItem': function(item) {

                return this.store.has(this.itemsCookieName, item);
            },
            //////////////////////////////////////////////////////////////////////////////////


            //--------------------------- gifts repository --------------------------------//
            'addGift': function(gift, quantity) {

                this.store.add(this.giftsCookieName, gift ,quantity);

                this.callListeners();
            },
            'updateGift': function(index, quantity) {

                this.store.update(this.giftsCookieName, index ,quantity);

                this.makeSureGiftsAreValid();

                this.callListeners();
            },
            'removeGift': function(index) {

                this.store.remove(this.giftsCookieName, index);

                this.makeSureGiftsAreValid();

                this.callListeners();
            },
            'getGifts': function() {

                return this.store.get(this.giftsCookieName);
            },
            'totalGifts': function() {

                return this.store.total(this.giftsCookieName);
            },
            'hasGift': function(item) {

                return this.store.has(this.giftsCookieName, item);
            },
            'getNumberOfGiftsLeft': function() {

                return MassOffer.calculateNumberOfGifts(this.getItems()) - this.store.total(this.giftsCookieName);
            },
            'makeSureGiftsAreValid': function() {

                console.log(this.getNumberOfGiftsLeft());

                // Remove gifts as long as number of gifts is < 0
                while(this.getNumberOfGiftsLeft() < 0)
                {
                    this.removeGift(0);
                }
            },
            //////////////////////////////////////////////////////////////////////////////////


            //--------------------------- Common methods --------------------------------//
            'isEmpty': function() {
                return this.getItems().length == 0;
            },
            'has': function(item) {

                return this.hasItem(item) || this.hasGift(item);
            },
            'callListeners': function() {

                for(var i = 0;i < this.listeners.length; i ++) {

                    // Make sure gifts are valid first
                    this.callListener(this.listeners[i]);
                }
            },
            'callListener': function(listener) {

                return listener(this);
            },
            'registerListener': function(listener) {

                this.callListener(listener);
                this.listeners.push(listener);
            },
            //////////////////////////////////////////////////////////////////////////////////







            //--------------------------- Price calculations --------------------------------//

            'hasOfferPrice': function() {

                return MassOffer.doesOfferApplies(this.getItems()) && MassOffer.isDiscountOffer();
            },
            'afterOfferPrice': function() {

                var total = this.beforeOfferPrice();

                // If mass offer applies then calculate price from the total
                if(MassOffer.doesOfferApplies(this.getItems())) total = MassOffer.calculatePriceFrom(total);

                return total;
            },

            'beforeOfferPrice': function() {

                return this.calculateTotalPrice(this.getItems());
            },

            'calculateTotalPrice': function(items) {
                var total = 0;

                for(var i = 0;i < items.length; i++)
                {
                    if(items[i]) total += this.calculateSubTotalPrice(items[i]);
                }

                return total;
            },

            'calculateSubTotalPrice': function(item) {

                return item.price ? parseFloat(item.quantity * item.price) : 0;
            }
            //////////////////////////////////////////////////////////////////////////////////
        }
    }])

    .factory('myCookieStore', function() {
        return {

            remove: function(name, path, domain) {
                // If the cookie exists
                if (getCookie(name))
                    createCookie(name, "", -1, path, domain);
            },

            put: function(name,value,days) {
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime()+(days*24*60*60*1000));
                    var expires = "; expires="+date.toGMTString();
                }
                else var expires = "";
                document.cookie = name+"="+JSON.stringify(value)+expires+"; path=/";
            },

            get: function (name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i=0;i < ca.length;i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') c = c.substring(1,c.length);
                    if (c.indexOf(nameEQ) == 0) return $.parseJSON(c.substring(nameEQ.length,c.length));
                }
                return null;
            }
        }
    })


    .factory('Helpers', function()
    {
        /**
         * Overwrites obj1's values with obj2's and adds obj2's if non existent in obj1
         * @param obj1
         * @param obj2
         * @returns obj3 a new object based on obj1 and obj2
         */
        return {
            merge_options: function(obj1,obj2){
                var obj3 = {};
                for (var attrname in obj1) { obj3[attrname] = obj1[attrname]; }
                for (var attrname in obj2) { obj3[attrname] = obj2[attrname]; }
                return obj3;
            },

            extract_matchings: function(arr1,arr2, attr) {
                var arr3 = [];
                for(var i = 0; i < arr1.length; i ++) {
                    for(var j = 0; j < arr2.length; j ++) {
                        if(arr1[i][attr] == arr2[j][attr]) {
                            arr3.push(arr1[i]);
                            break;
                        }
                    }
                }
                return arr3;
            }
        }
    });
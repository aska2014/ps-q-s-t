'use strict';

/* Directives */


angular.module('freak.directives', [])

    .directive('frDataTable', function() {
        return {
            restrict: 'A',
            replace: true,
            link: function(scope, element, attrs, controller) {

                attrs.$observe('frDataTable', function(isReady) {
                    if(isReady == 'true' && $.fn.dataTable) {

                        setTimeout(function()
                        {
                            $(element).dataTable().columnFilter();
                        }, 500);
                    }
                });
            }
        }
    })

    .directive('frDatetimePicker', function() {
        return {
            restrict: 'A',
            replace: true,
            link: function(scope, element, attrs, controller) {

                element.datetimepicker({ ampm: true });
            }
        }
    });

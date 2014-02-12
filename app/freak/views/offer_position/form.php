<div class="row-fluid" ng-controller="FEOPCtrl">
    <div class="span4" ng-repeat="offer_position in offer_positions">
        <div class="widget">
            <div class="widget-header">
                <span class="title">Offer position {{ offer_position.position }}</span>
            </div>
            <div class="widget-content form-container">
                <form class="form-vertical" ng-submit="processMe(offer_position)">
                    <div class="control-group">
                        <label class="control-label" for="input00">Product</label>
                        <div class="controls">
                            <select class="span12" ng-model="offer_position.product_id" ng-required ng-options="product.id as product.title for product in products">
                                <option value="">Choose product</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Title</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="offer_position.title">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="reset" class="btn" type="reset">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function FEOPCtrl(url, $http, $scope)
    {
        $http.get(url.element('offer_position/current', '', true)).success(function(data)
        {
            $scope.offer_positions = data;
        });

        $http.get(url.element('product', '', true)).success(function(data)
        {
            $scope.products = data;
        });

        $scope.processMe = function(offer_position)
        {
            if ( offer_position.hasOwnProperty('id') ) {

                var myUrl = url.element('offer_position', offer_position.id, true);
            }
            else {
                var myUrl = url.element('offer_position', '', true);
            }

            $http.post(myUrl, offer_position).success(function(data)
            {
                offer_position.id = data.id;
                $scope.alert.success('Offer position saved', '');
            });
        }
    }
</script>
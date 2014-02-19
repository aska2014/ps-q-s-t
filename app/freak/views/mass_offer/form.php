<div class="row-fluid" ng-controller="FEMOCtrl">
    <div class="btn-toolbar">
    </div>
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <span class="title">Add new mass offer</span>
            </div>
            <div class="widget-content form-container">
                <form class="form-horizontal" ng-submit="processMyForm()">
                    <div class="control-group">
                        <label class="control-label" for="input00">Title</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.title">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Description</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.description">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Start quantity</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.start_quantity">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Start price</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.start_price">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Choose offer type</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" ng-model="mass_offer.offer" value="gift">
                                Gift offer
                            </label>
                            <label class="radio">
                                <input type="radio" ng-model="mass_offer.offer" value="discount">
                                Discount offer
                            </label>
                        </div>
                    </div>
                    <div class="control-group" ng-show="mass_offer.offer == 'gift'">
                        <label class="control-label" for="input00">Gifts per one product</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.gifts_per_product">
                            <small>For each <strong>{{ 1/model.gifts_per_product }}</strong> products you get one gift</small>
                        </div>
                    </div>
                    <div class="control-group" ng-show="mass_offer.offer == 'gift'">
                        <label class="control-label" for="input00">Max gift price</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.max_gift_price">
                        </div>
                    </div>
                    <div class="control-group" ng-show="mass_offer.offer == 'discount'">
                        <label class="control-label" for="input00">Discount percentage</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.discount_percentage">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Date range</label>
                        <div class="controls">
                            <input fr-datetime-picker type="text" class="span3" ng-model="model.from_date" placeholder="from date">
                            <input fr-datetime-picker type="text" class="span3" ng-model="model.to_date" placeholder="to date">
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
    function FEMOCtrl($scope)
    {
        $scope.$watch('model.discount_percentage', function(discount) {

            if(discount !== undefined)
            {
                if(discount > 0) $scope.mass_offer = {offer : 'discount'};
                else $scope.mass_offer = {offer : 'gift'};
            }
        });

        $scope.processMyForm = function()
        {
            if($scope.mass_offer.offer == 'discount')
            {
                $scope.model.max_gift_price = 0;
                $scope.model.gifts_per_product = 0;
            }
            else
            {
                $scope.model.discount_percentage = 0;
            }

            $scope.processForm();
        }
    }

</script>

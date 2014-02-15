<div class="row-fluid" ng-controller="FEOfferCtrl">
    <div class="span12" ng-repeat="offer in offers">
        <div class="widget">
            <div class="widget-header">
                <span class="title">Add new mass offer</span>
            </div>
            <div class="widget-content form-container">
                <form class="form-horizontal" ng-submit="processForm()">
                    <div class="control-group">
                        <label class="control-label" for="input00">Title</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.name">
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
    function FEOfferCtrl($http, url, $scope)
    {
        $scope.offers = [];
        $http.get(url.element('mass_offer', '', true)).success(function(offers) {
            $scope.offers = offers;
        });
    }
</script>
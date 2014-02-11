<div class="row-fluid" ng-controller="FEProductController">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <span class="title">Add new product</span>
            </div>
            <div class="widget-content form-container">
                <form class="form-vertical" ng-submit="processForm()">
                    <div class="control-group">
                        <label class="control-label" for="input00">Model</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.model">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Title</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.title">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input02">More information</label>
                        <div class="controls">
                            <textarea id="input02" class="span12" ng-model="model.description"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">Gender</label>
                        <div class="controls">
                            <select class="span12" ng-model="model.gender" ng-options="value for value in ['male', 'female', 'unisex']">
                                <option value="">Choose gender</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Category</label>
                        <select class="span12" ng-model="model.category_id" ng-options="category.id as category.name for category in categories">
                            <option value="">Choose category</option>
                        </select>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Brand</label>
                        <select class="span12" ng-model="model.brand_id" ng-options="brand.id as brand.name for brand in brands">
                            <option value="">Choose brand</option>
                        </select>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Price</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span2" ng-model="model.price.value">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="reset" class="btn" type="reset">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="widget" ng-show="show.offer">
            <div class="widget-header">
                <span class="title">Add offer</span>
            </div>
            <div class="widget-content form-container">
                <form class="form-vertical" ng-submit="addOffer()" name="offer_form">
                    <div class="control-group">
                        <label class="control-label" for="input00">Offer</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span2" ng-model="offer.price"> ,
                            Discount percentage = <strong>{{ offer.discount_percentage }}%</strong><br />
                            <input fr-datetime-picker type="text" class="span3" ng-model="offer.from_date" placeholder="from date">
                            <input fr-datetime-picker type="text" class="span3" ng-model="offer.to_date" placeholder="to date">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save offer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function FEProductController($scope, $http, url, Packages)
    {
        Packages.setModelType('ECommerce\\Product');

        Packages.setOptions('images', {
            maximum: 10,
            types: [ 'main' ],
            group: 'Product.Main',
            image_name: 'product'
        });

        $http.get(url.element('category', '', true)).success(function(data)
        {
            $scope.categories = data;
        });

        $http.get(url.element('brand', '', true)).success(function(data)
        {
            $scope.brands = data;
        });

        $scope.show = {};

        $scope.$watch('offer.price', function(value)
        {
            $scope.offer.discount_percentage = (100 - ((value / $scope.model.price.value) * 100)).toFixed(2);
        });

        $scope.$watch('offer.discount_percentage', function(value)
        {
            value = value / 100;
            $scope.offer.price = Math.round($scope.model.price.value - (value * $scope.model.price.value));
        });

        $scope.$watch('model.id', function(id)
        {
            if(id !== undefined)
            {
                $scope.show.offer = true;

                $http.get(url.element('offer', 'product-current/' + id, true)).success(function(data)
                {
                    $scope.offer = data;
                });

                $scope.addOffer = function()
                {
                    $http.post(url.element('offer', 'product/' + id, true), $scope.offer).success(function(data)
                    {
                        $scope.offer = data;
                    });
                }
            }
        });
    }

</script>
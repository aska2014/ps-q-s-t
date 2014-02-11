<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">Showing brand</span>
        </div>
        <div class="widget-content table-container">
            <table class="table table-striped table-detail-view" ng-controller="FECategoryCtrl">
                <tbody>
                <tr>
                    <th>Title</th>
                    <td>{{ model.name }}</td>
                </tr>
                <tr>
                    <th>Products</th>
                    <td>
                        <ul>
                            <li ng-repeat="product in products">
                                <a href="#{{ url.elementView('product', 'one/' + product.id) }}">{{ product.title }}</a>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script type="text/javascript">
    function FECategoryCtrl($scope, $http, url)
    {
        $scope.$watch('model.id', function(id) {
            $http.get(url.element('product', 'brand/' + id, true)).success(function(data) {
                $scope.products = data;
            });
        });
    }
</script>
<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">Showing category</span>
        </div>
        <div class="widget-content table-container">
            <table class="table table-striped table-detail-view" ng-controller="FECategoryCtrl">
                <tbody>
                <tr>
                    <th>Title</th>
                    <td>{{ model.title }}</td>
                </tr>
                <tr>
                    <th>Model</th>
                    <td>{{ model.model }}</td>
                </tr>
                <tr ng-show="model.description != ''">
                    <th>Description</th>
                    <td>{{ model.description }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ model.gender }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ model.category.name }}</td>
                </tr>
                <tr>
                    <th>Brand</th>
                    <td>{{ model.brand.name }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>{{ model.price }}</td>
                </tr>
                <tr>
                    <th>Offers</th>
                    <td>
                        <ul>
                            <li ng-repeat="offer in model.product_offers">
                                ({{ offer.from_date }} , {{ offer.to_date }}) : <strong>{{ offer.discount_percentage }}% Discount</strong>
                            </li>
                        </ul>
                        {{ model.offers }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script type="text/javascript">
    function FECategoryCtrl($scope, $http, url, Packages)
    {
        Packages.setModelType('ECommerce\\Product');
    }
</script>
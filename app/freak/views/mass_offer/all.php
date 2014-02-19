<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">All products</span>
        </div>
        <div class="widget-content table-container">
            <table fr-data-table="{{ isReady }}" class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Start quantity</th>
                    <th>Start price</th>
                    <th>Discount percentage</th>
                    <th>Gifts per product</th>
                    <th>Max gift price</th>
                    <th>Date range</th>
                    <th>Tools</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="offer in models">
                    <td>{{ offer.id }}</td>
                    <td>{{ offer.title }}</td>
                    <td>{{ offer.start_quantity }}</td>
                    <td>{{ offer.start_price }}</td>
                    <td>{{ offer.discount_percentage }}</td>
                    <td>{{ offer.gifts_per_product }}</td>
                    <td>{{ offer.max_gift_price }}</td>
                    <td>From: {{ offer.from_date }}<br /> To: {{ offer.to_date }}</td>
                    <td class="action-col" width="10%">
                    <span class="btn-group">
                        <a href="#{{ url.elementView('mass_offer', 'one/' + offer.id) }}" class="btn btn-small"><i class="icon-search"></i></a>
                        <a href="#{{ url.elementView('mass_offer', 'form/' + offer.id) }}" class="btn btn-small"><i class="icon-pencil"></i></a>
                        <a ng-click="delete($index)" class="btn btn-small"><i class="icon-trash"></i></a>
                    </span>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Start quantity</th>
                    <th>Start price</th>
                    <th>Discount percentage</th>
                    <th>Gifts per product</th>
                    <th>Max gift price</th>
                    <th>Date range</th>
                    <th>Tools</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
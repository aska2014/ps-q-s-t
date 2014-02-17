<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">All orders</span>
        </div>
        <div class="widget-content table-container">
            <table fr-data-table="{{ isReady }}" class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Products</th>
                    <th>Total</th>
                    <th>Tools</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="order in models">
                    <td>{{ order.id }}</td>
                    <td>{{ order.user_info.name }}</td>
                    <td>
                        <ul>
                            <li ng-repeat="contact in order.user_info.contacts">
                                <strong>{{ contact.type }}</strong> ({{ contact.value }})
                            </li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li ng-repeat="product in order.products">
                                {{ product.pivot.quantity }} *
                                <a href="#{{ url.elementView('product', 'one/' + product.id) }}">{{ product.title }}</a>
                            </li>
                        </ul>
                    </td>
                    <td>
                        {{ order.price | currency:'QAR ' }}
                    </td>
                    <td class="action-col" width="10%">
                    <span class="btn-group">
                        <a href="#{{ url.elementView('order', 'one/' + order.id) }}" class="btn btn-small"><i class="icon-search"></i></a>
                        <a ng-click="delete($index)" class="btn btn-small"><i class="icon-trash"></i></a>
                    </span>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Products</th>
                    <th>Total</th>
                    <th>Tools</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">Showing category</span>
        </div>
        <div class="widget-content table-container">
            <table class="table table-striped table-detail-view">
                <tbody>
                <tr>
                    <th>Title</th>
                    <td>{{ model.name }}</td>
                </tr>
                <tr>
                    <th>Products</th>
                    <td>
                        <ul>
                            <li ng-repeat="product in model.products">
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
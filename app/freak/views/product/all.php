<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">All products</span>
        </div>
        <div class="widget-content table-container">
            <table fr-data-table="{{ viewOptions.ready }}" class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Model</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Tools</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="product in models">
                    <td>{{ product.id }}</td>
                    <td>{{ product.title }}</td>
                    <td>{{ product.model }}</td>
                    <td>
                        <a href="#{{ url.elementView('category', 'one/' + product.category.id) }}">{{ product.category.name }}</a>
                    </td>
                    <td>
                        <a href="#{{ url.elementView('brand', 'one/' + product.brand.id) }}">{{ product.brand.name }}</a>
                    </td>
                    <td>{{ product.price }}</td>
                    <td class="action-col" width="10%">
                        <fr-data-tools></fr-data-tools>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Model</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Tools</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
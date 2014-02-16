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
                    <td>{{ model.title }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ model.description }}</td>
                </tr>
                <tr>
                    <th>Start quantity</th>
                    <td>{{ model.start_quantity }}</td>
                </tr>
                <tr>
                    <th>Start price</th>
                    <td>{{ model.start_price }}</td>
                </tr>
                <tr>
                    <th>Discount percentage</th>
                    <td>{{ model.discount_percentage }}</td>
                </tr>
                <tr>
                    <th>Date range</th>
                    <td>( {{ model.from_date }} ) &nbsp&nbsp&nbsp -> &nbsp&nbsp&nbsp ( {{ model.to_date }} )</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
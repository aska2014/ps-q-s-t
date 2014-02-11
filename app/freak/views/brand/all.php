<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">All brands</span>
        </div>
        <div class="widget-content table-container">
            <table fr-data-table="{{ isReady }}" class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="brand in models">
                    <td>{{ brand.name }}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th>Name</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
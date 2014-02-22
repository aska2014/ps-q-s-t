<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">All brands</span>
            <div class="toolbar">
                <div class="btn-group">
                    <span class="btn" ng-click="refresh()"><i class="icos-refresh-2"></i></span>
                </div>
            </div>
        </div>
        <div class="widget-content table-container">
            <table fr-data-table="{{ viewOptions.ready }}" class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Tools</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="brand in models">
                    <td>{{ brand.name }}</td>
                    <td class="action-col" width="10%">
                        <fr-data-tools></fr-data-tools>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Tools</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
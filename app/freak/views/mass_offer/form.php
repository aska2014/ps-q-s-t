<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <span class="title">Add new mass offer</span>
            </div>
            <div class="widget-content form-container">
                <form class="form-horizontal" ng-submit="processForm()">
                    <div class="control-group">
                        <label class="control-label" for="input00">Title</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.title">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Description</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.description">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Start quantity</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.start_quantity">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Start price</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.start_price">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Discount percentage</label>
                        <div class="controls">
                            <input type="text" id="input00" class="span12" ng-model="model.discount_percentage">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input00">Date range</label>
                        <div class="controls">
                            <input fr-datetime-picker type="text" class="span3" ng-model="model.from_date" placeholder="from date">
                            <input fr-datetime-picker type="text" class="span3" ng-model="model.to_date" placeholder="to date">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="reset" class="btn" type="reset">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

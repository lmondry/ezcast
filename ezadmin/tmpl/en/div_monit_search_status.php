<div class="page_title">Track Recording</div>

<form method="GET" class="search_asset pagination" style="width: 100%;">
    
    <input type="hidden" name="action" value="<?php echo $input['action']; ?>" >
    <input type="hidden" name="post" value="">
    
    
    <!-- Date and status -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <label for="startDate">From</label>
                <div class='input-group date' id='startDate'>
                    <input type='text' name='startDate' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <label for="endDate">To</label>
                <div class='input-group date' id='endDate'>
                    <input type='text' name='endDate' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-md-3">
                <label for="status">Status</label>
                <select name="status[]" class="form-control selectpicker" multiple data-actions-box="true" 
                        title="Select Status">
                    <?php
                    foreach (EventStatus::getAllEventStatus() as $status) {
                        echo '<option value="'.$status.'"';
                        if(isset($input) && array_key_exists('status', $input) && 
                                is_array($input['status']) && in_array($status, $input['status'])) {
                            echo ' selected';
                        }
                        echo ' data-content="<span class=\'label label-'.EventStatus::getColorStatus($status).'\'>'.$status.'</span>"';
                        echo '>'.$status.
                            '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-1">
                <label for=""></label><br />
                <button type="button" class="btn btn-primary" 
                        data-toggle="modal" data-target="#help_modal">
                    <span class="glyphicon glyphicon-info-sign icon-white"></span> 
                </button>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        $(function () {
            
            $('#startDate').datetimepicker({
                showTodayButton: true, 
                showClose: true,
                sideBySide: true,
                format: 'YYYY-MM-DD HH:mm',
                <?php
                if(isset($input) && array_key_exists('startDate', $input) && $input['startDate'] != 0) {
                    echo "defaultDate: new Date('".$input['startDate']."')";
                } else {
                    echo 'defaultDate: moment().subtract(4, \'month\')';
                }
                ?>
            });
            
            $('#endDate').datetimepicker({
                showTodayButton: true,
                showClose: true,
                sideBySide: true,
                format: 'YYYY-MM-DD HH:mm',
                <?php
                if(isset($input) && array_key_exists('endDate', $input) && $input['endDate'] != 0) {
                    echo "defaultDate: new Date('".$input['endDate']."')";
                } else {
                    echo 'defaultDate: moment().add(1, \'days\')';
                }
                ?>
            });
            
            $("#startDate").on("dp.change", function (e) {
                $('#endDate').data("DateTimePicker").minDate(e.date);
            });
            $("#endDate").on("dp.change", function (e) {
                $('#startDate').data("DateTimePicker").maxDate(e.date);
            });
            
        });
        
    </script>
        
    <div class="form-group">
        <div class="row">
            <div class="col-md-5">
                <label class="sr-only" for="asset">Asset</label>
                <input type="text" class="form-control" name="asset" id="asset" placeholder="Asset"
                    value="<?php if(isset($input) && array_key_exists('asset', $input)) { echo $input['asset']; } ?>">
            </div>
            <div class="col-md-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="view_all" 
                            <?php if(isset($input) && array_key_exists('view_all', $input)) { echo 'checked'; } ?>> 
                        View all results
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-block btn-success">
                    <span class="glyphicon glyphicon-search icon-white"></span> 
                    Search
                </button>
            </div>
        </div>
    </div>
    
</form>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="help_modal" tabindex="-1" role="dialog" aria-labelledby="Help_Modal_Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="Help_Modal_Label">Informations</h4>
                </div>
                <div class="modal-body">
                    <br />
                    <h3>Automaic</h3>
                    <h4>AUTO_SUCCESS</h4>
                    <p>
            Status set automatically when all is ok
        </p>
                    <h4>AUTO_SUCCESS_ERRORS</h4>
                    <p>
            Status set automatically when we have the result that there are critical errors
        </p>
                    <h4>AUTO_SUCCESS_WARNINGS</h4>
                    <p>
            Status set automatically when we have the result that there are warnings/errors
        </p>
                    <h4>AUTO_FAILURE</h4>
                    <p>
            Status set automatically when there is a problem
        </p>
                    <br />
                    <h3>Manual</h3>
                    <h4>MANUAL_OK</h4>
                    <p>
            Status set (manually) when all is ok
        </p>
                    <h4>MANUAL_PARTIAL_OK</h4>
                    <p>
            Status set (manually) when the problem was fixed but with partial loss
        </p>
                    <h4>MANUAL_FAILURE</h4>
                    <p>
            Status set (manually) when the problem was seen but there was a total loss
        </p>
                    <h4>MANUAL_IGNORE</h4>
                    <p>
            Status set (manually) when the asset is not important (and could be link with an other asset)
        </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>

<div class="page_title">Logs</div>

<!-- Search form -->
<form method="POST" action="index.php?action=view_logs" class="search_logs">
    <input type="hidden" name="post" value="1">
    
    <!-- Date -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-2 col-sm-6">
                <label for="startDate">From</label>
                <div class='input-group date' id='startDate'>
                    <input type='text' name='date_start' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <label for="endDate">To</label>
                <div class='input-group date' id='endDate'>
                    <input type='text' name='date_end' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <label for="table">Category</label>
                <select name="table" class="form-control" title="Category">
                    <option value="users" <?php if($selectTable == 'users') { echo 'selected'; }?>>
                        Users
                    </option>
                    <option value="courses" <?php if($selectTable == 'courses') { echo 'selected'; }?>>
                        Courses
                    </option>
                    <option value="users_courses" <?php if($selectTable == 'users_courses') { echo 'selected'; }?>>
                        Links between courses and users
                    </option>
                    <option value="classrooms" <?php if($selectTable == 'classrooms') { echo 'selected'; }?>>
                        Classrooms
                    </option>
                    <option value="all" <?php if($selectTable == '' || $selectTable == 'all') { echo 'selected'; }?> >
                        All operations
                    </option>
                </select>
            </div>
            <div class="col-md-3 col-sm-6">
                <label for="author">Author</label>
                <input class="form-control input input-medium auto-clear placeholder" type="text" placeholder="Author" 
                       title="Author" name="author" 
                       value="<?php if(isset($input) && array_key_exists('author', $input)) { echo $input['author']; } ?>" />
            </div>
            <div class="col-md-2">
                <label></label>
                <button type="submit" name="search" value="on" class="btn btn-success btn-block">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    Search
                </button>
            </div>
        </div>
    </div>
        
<br /><br />


<?php if (!empty($logs)) {
    if(isset($pagination)) {
        $pagination->insert('POST');
    }
} ?>
</form>



<script type="text/javascript">
    $(function () {

        $('#startDate').datetimepicker({
            showTodayButton: true, 
            showClose: true,
            sideBySide: true,
            format: 'YYYY-MM-DD',
            <?php
            if(isset($input) && array_key_exists('date_start', $input)) {
                echo "defaultDate: '".$input['date_start']."'";
            } else {
                echo 'defaultDate: 0';
            }
            ?>
        });

        $('#endDate').datetimepicker({
            showTodayButton: true,
            showClose: true,
            sideBySide: true,
            format: 'YYYY-MM-DD',
            <?php
            if(isset($input) && array_key_exists('date_end', $input)) {
                echo "defaultDate: '".$input['date_end']."'";
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
<div class="page_title">Change EZadmin configuration</div>


<form class="form-horizontal" method="post" action="index.php?action=edit_config">
    
    <!-- Displays alert, if any -->
    <?php if(isset($alert)) {
        echo $alert;
    } ?>
    
    
    <!-- Enable/disable classrooms -->
    <div class="form-group">
        <div class="col-sm-5 col-sm-offset-1">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="recording_enabled" id="recording_enable" 
                        <?php if(array_key_exists('recorders_option', $params) && $params['recorders_option']) { 
                            echo 'checked="checked"';} ?> />
                        Enable classroom management
                </label>
            </div>
        </div>
    </div>
    
    <!-- Enable/disable adding users -->
    <div class="form-group">
        <div class="col-sm-5 col-sm-offset-1">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="add_users_enabled" id="add_users_enable" 
                        <?php if(array_key_exists('add_users_option', $params) && $params['add_users_option']) {
                            echo 'checked="checked"'; } ?> />
                    Allow adding users
                </label>
            </div>
        </div>
    </div>
    
    <!-- Enable/disable classroom password storage -->
    <div class="form-group">
        <div class="col-sm-5 col-sm-offset-1">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="password_storage_enabled" id="password_storage_enable" 
                        <?php if(array_key_exists('recorder_password_storage_option', $params) && $params['recorder_password_storage_option']) { 
                            echo 'checked="checked"'; } ?> />
                    Unique password
                </label>
            </div>
        </div>
    </div>
    
    <!-- Display courses by name or by code -->
    <div class="form-group">
        <div class="col-sm-5 col-sm-offset-1">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="courses_by_name" id="courses_by_name" 
                        <?php if(array_key_exists('course_name_option', $params) && $params['course_name_option']) { echo 'checked="checked"'; } ?> />
                    Show course name
                </label>
            </div>
        </div>
    </div>
    
    <!-- Display users by name or by code -->
    <div class="form-group">
        <div class="col-sm-5 col-sm-offset-1">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="users_by_name" id="users_by_name" 
                        <?php if(array_key_exists('user_name_option', $params) && $params['user_name_option']) { echo 'checked="checked"'; } ?> />
                    Show users name
                </label>
            </div>
        </div>
    </div>
    
    <!-- Confirm -->
    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-5">
            <input type="submit" name="confirm" value="Save changes" class="btn btn-success">
        </div>
    </div>
</form>

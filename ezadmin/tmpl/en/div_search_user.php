
<div class="page_title">User list</div>

<!-- Search form -->
<form method="POST" action="index.php" class="form-inline search_user">
    <input type="hidden" name="action" value="view_users" />
    
    <input type="hidden" name="post"/>
    <input type="hidden" name="page" value="1" />
    <input type="hidden" name="col" value="<?php if(isset($input) && isset($input['col'])) echo $input['col'] ?>" />
    <input type="hidden" name="order" value="<?php if(isset($input) && isset($input['order'])) echo $input['order'] ?>" />
    
    <input class="form-control input-large auto-clear placeholder" type="text" placeholder="User ID" title="User ID" name="user_ID" value="<?php if(isset($input) && isset($input['user_ID'])) echo $input['user_ID']; ?>" />
    <input class="form-control input-large auto-clear placeholder" type="text" placeholder="Forename" title="Forename" name="forename" value="<?php if(isset($input) && isset($input['forename'])) echo $input['forename']; ?>" />
    <input class="form-control input-large auto-clear placeholder" type="text" placeholder="Surname" title="Surname" name="surname" value="<?php if(isset($input) && isset($input['surname'])) echo $input['surname']; ?>" />
    
    <input type="submit" name="search" value="Search" class="btn btn-primary">
    <input type="reset" name="reset" value="Reset" class="btn"> <br />
    <div><a href="#" onclick="javascript:toggleVisibility('options_block');"><span class="glyphicon glyphicon-plus"></span> Options</a></div>
    <div class="row" style="display: none;" id="options_block">
        
        <div class="col-md-2 col-md-offset-1">
            <label class="control-label" style="display: inline-block;">
                Origin: 
            </label>
            <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" title="Internal" name="intern" <?php echo isset($input['intern']) ? 'checked' : ''; ?> />
                    Internal
                </label>
            </div>
            <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" title="External" name="extern" <?php echo isset($input['extern']) ? 'checked' : ''; ?> />
                    External
                </label>  
            </div>
        </div>
        
        <div class="col-md-2">
            <label class="control-label" style="display: inline-block;">
                Admin: 
            </label>
            <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" title="Yes" name="is_admin" <?php echo isset($input['is_admin']) ? 'checked' : ''; ?> />
                    Yes
                </label>
            </div>
            <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" title="No" name="is_not_admin" <?php echo isset($input['is_not_admin']) ? 'checked' : ''; ?> />
                    No
                </label>
            </div>
        </div>
    </div>
</form>

<hr>

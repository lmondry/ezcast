
<div class="page_title">Course list</div>

<!-- Search form -->
<form method="POST" action="index.php?action=view_courses" style="width: 100%" class="search_course">  
    <input type="hidden" name="post"/>
    <input type="hidden" name="page" value="1" />
    <input type="hidden" name="col" value="<?php echo $input['col'] ?>" />
    <input type="hidden" name="order" value="<?php echo $input['order'] ?>" />
    
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-md-offset-1">
                <label class="sr-only" for="course_code">Course code</label>
                <input class="form-control" type="text" placeholder="Course code" 
                   title="Course code" name="course_code" id="course_code"
                   value="<?php if(isset($input) && isset($input['course_code'])) { echo $input['course_code']; } ?>" />
            </div>
            <div class="col-md-4">
                <label class="sr-only" for="teacher">Teacher</label>
                <input class="form-control" type="text" placeholder="Teacher" 
                   title="Teacher" name="teacher"  id="teacher"
                   value="<?php if(isset($input) && isset($input['teacher'])) { echo $input['teacher']; } ?>" />
            </div>
            <div class="col-md-2">
                <input type="submit" name="search" value="Search" class="btn btn-block btn-primary">
            </div>
        </div>
    </div>
    
    <div class="col-md-offset-1">
        <div>
            <a href="#" onclick="javascript:toggleVisibility('options_block');">
                <span class="glyphicon glyphicon-plus"></span> 
                Options
            </a>
        </div>

        <div class="row" style="display: none;" id="options_block">
            <div class="col-md-2 col-md-offset-1">
                <label class="control-label" style="display: inline-block;">
                    Origin: 
                </label>
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Internal" name="intern" 
                            <?php echo isset($input['intern']) ? 'checked' : ''; ?> /> 
                        Internal
                    </label>
                </div>
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="External" name="extern" 
                            <?php echo isset($input['extern']) ? 'checked' : ''; ?> /> 
                        External
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                Has albums: 
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="With" name="has_albums" 
                            <?php echo isset($input['has_albums']) ? 'checked' : ''; ?> />
                            With
                    </label>
                </div>

                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Without" name="no_albums" 
                            <?php echo isset($input['no_albums']) ? 'checked' : ''; ?> />
                        Without
                    </label>
                </div>
            </div>

            <div class="col-md-2">
                In classroom: 
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Yes" name="in_recorders" 
                            <?php echo isset($input['in_recorders']) ? 'checked' : ''; ?> />
                        Yes
                    </label>
                </div>

                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="No" name="out_recorders" 
                            <?php echo isset($input['out_recorders']) ? 'checked' : ''; ?> />
                        No
                    </label>
                </div>
            </div>

            <div class="col-md-2">
                With prof: 
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Yes" name="with_teacher" 
                            <?php echo isset($input['with_teacher']) ? 'checked' : ''; ?> />
                        Yes
                    </label>
                </div>

                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="No" name="without_teacher" 
                            <?php echo isset($input['without_teacher']) ? 'checked' : ''; ?> />
                        No
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>
<br />
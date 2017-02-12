
<div class="page_title">Liste des cours</div>

<!-- Search form -->
<form method="POST" action="index.php?action=view_courses" style="width: 100%" class="search_course">  
    <input type="hidden" name="post"/>
    <input type="hidden" name="page" value="1" />
    <input type="hidden" name="col" value="<?php echo $input['col'] ?>" />
    <input type="hidden" name="order" value="<?php echo $input['order'] ?>" />
    
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-md-offset-1">
                <label class="sr-only" for="course_code">Mnémonique</label>
                <input class="form-control" type="text" placeholder="Mnémonique" 
                   title="Mnémonique" name="course_code" id="course_code"
                   value="<?php if(isset($input) && isset($input['course_code'])) { echo $input['course_code']; } ?>" />
            </div>
            <div class="col-md-4">
                <label class="sr-only" for="teacher">Enseignant</label>
                <input class="form-control" type="text" placeholder="Enseignant" 
                   title="Enseignant" name="teacher"  id="teacher"
                   value="<?php if(isset($input) && isset($input['teacher'])) { echo $input['teacher']; } ?>" />
            </div>
            <div class="col-md-2">
                <input type="submit" name="search" value="Rechercher" class="btn btn-block btn-primary">
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
                    Origine: 
                </label>
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Interne" name="intern" 
                            <?php echo isset($input['intern']) ? 'checked' : ''; ?> /> 
                        Interne
                    </label>
                </div>
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Externe" name="extern" 
                            <?php echo isset($input['extern']) ? 'checked' : ''; ?> /> 
                        Externe
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                A des albums: 
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Avec" name="has_albums" 
                            <?php echo isset($input['has_albums']) ? 'checked' : ''; ?> />
                            Avec
                    </label>
                </div>

                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Sans" name="no_albums" 
                            <?php echo isset($input['no_albums']) ? 'checked' : ''; ?> />
                        Sans
                    </label>
                </div>
            </div>

            <div class="col-md-2">
                En auditoire: 
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Oui" name="in_recorders" 
                            <?php echo isset($input['in_recorders']) ? 'checked' : ''; ?> />
                        Oui
                    </label>
                </div>

                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Non" name="out_recorders" 
                            <?php echo isset($input['out_recorders']) ? 'checked' : ''; ?> />
                        Non
                    </label>
                </div>
            </div>

            <div class="col-md-2">
                Avec prof: 
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Oui" name="with_teacher" 
                            <?php echo isset($input['with_teacher']) ? 'checked' : ''; ?> />
                        Oui
                    </label>
                </div>

                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" title="Non" name="without_teacher" 
                            <?php echo isset($input['without_teacher']) ? 'checked' : ''; ?> />
                        Non
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>
<br />
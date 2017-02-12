<div class="page_title">Liste des events</div>

<form method="GET" class="search_event pagination" style="width: 100%;">
    
    <input type="hidden" name="action" value="<?php echo $input['action']; ?>" >
    <input type="hidden" name="post" value="">
    
    
    <!-- Date -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <label for="startDate">De</label>
                <div class='input-group date' id='startDate'>
                    <input type='text' name='startDate' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <label for="endDate">A</label>
                <div class='input-group date' id='endDate'>
                    <input type='text' name='endDate' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
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
                if(isset($input) && array_key_exists('startDate', $input) && $input['startDate'] != "") {
                    echo "defaultDate: new Date('".$input['startDate']."')";
                } else {
                    echo 'defaultDate: moment().subtract(7, \'days\')';
                }
                ?>
            });
            
            $('#endDate').datetimepicker({
                showTodayButton: true,
                showClose: true,
                sideBySide: true,
                format: 'YYYY-MM-DD HH:mm',
                <?php
                if(isset($input) && array_key_exists('endDate', $input)) {
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
    
    <!-- Classroom, teacher, courses -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <label class="sr-only" for="classroom">Auditoire</label>
                <input type="text" class="form-control classroomSuggest" name="classroom" id="classroom" placeholder="Auditoire"
                    value="<?php if(isset($input) && array_key_exists('classroom', $input)) { echo $input['classroom']; } ?>">
            </div>
            <div class="col-md-4">
                <label class="sr-only" for="teacher">Auteur</label>
                <input type="text" class="form-control" name="teacher" id="teacher" placeholder="Auteur"
                    value="<?php if(isset($input) && array_key_exists('teacher', $input)) { echo $input['teacher']; } ?>">
            </div>
            <div class="col-md-4">
                <label class="sr-only" for="courses">Cours</label>
                <input type="text" class="form-control" name="courses" id="courses" placeholder="Cours"
                    value="<?php if(isset($input) && array_key_exists('courses', $input)) { echo $input['courses']; } ?>">
            </div>
        </div>
    </div>
    
    <!-- asset, origin, type_id, error level -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">
                <label class="sr-only" for="asset">Asset</label>
                <input type="text" class="form-control" name="asset" id="asset" placeholder="Asset"
                    value="<?php if(isset($input) && array_key_exists('asset', $input)) { echo $input['asset']; } ?>">
            </div>
            <div class="col-md-3">
                <label class="sr-only" for="origin"">Origine</label>
                <input type="text" class="form-control" name="origin" id="origin" placeholder="Origine"
                    value="<?php if(isset($input) && array_key_exists('origin', $input)) { echo $input['origin']; } ?>">
            </div>
            <div class="col-md-3">
                <label class="sr-only" for="type_id">Type</label>
                <select name="type_id" class="form-control">
                    <option value="" selected></option>
                    <?php
                    foreach (EventType::$event_type_id as $nameEventType => $num) {
                        echo '<option value="'.$num.'"';
                        if(isset($input) && array_key_exists('type_id', $input) && 
                                $input['type_id'] != "" && $input['type_id'] == $num) {
                            echo ' selected';
                        }
                        echo '>'.$nameEventType.
                            '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="col-md-3">
                <select name="log_level[]" class="form-control selectpicker" multiple data-actions-box="true"
                        title="Selectionner le LogLevel">
                    <?php foreach(LogLevel::$log_levels as $nameLog => $lvlLog) {
                        $nameLevel = $lvlLog . " - " . ucfirst($nameLog);
                        echo '<option value="'.$lvlLog.'" ';
                        echo 'data-content="<span class=\'label label-'.$nameLog.'\'>'.$nameLevel.'</span>"';
                        if(isset($input) && 
                            (isset($logLevel_default_max_selected) && $lvlLog <= $logLevel_default_max_selected) 
                                || 
                            (is_array($input['log_level']) && 
                            in_array($lvlLog, $input['log_level']) && $input['log_level'][0] != NULL)) {
                            
                            echo 'selected';
                        }
                        echo '> '.$nameLevel. '</option>';
                    
                    } ?>
                </select>
            </div>
        </div>
    </div>
    
    
    <!-- Context, message and submit -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <label class="sr-only" for="context">Contexte</label>
                <input type="text" class="form-control" name="context" id="context" placeholder="Contexte"
                    value="<?php if(isset($input) && array_key_exists('context', $input)) { echo $input['context']; } ?>">
            </div>
            <div class="col-md-4">
                <label class="sr-only" for="message">Message</label>
                <input type="text" class="form-control" name="message" id="message" placeholder="Message"
                    value="<?php if(isset($input) && array_key_exists('message', $input)) { echo $input['message']; } ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-block btn-success">
                    <span class="glyphicon glyphicon-search icon-white"></span> 
                    Rechercher
                </button>
            </div>
        </div>
    </div>
    
</form>


<script>
$('.classroomSuggest').typeahead({
  hint: true,
  highlight: true,
  minLength: 0
},
{
  name: 'classroom',
  source: substringMatcher(<?php echo $js_classroom; ?>)
});
</script>
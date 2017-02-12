<div class="page_title">Record calendar</div>

<form method="GET" class="pagination" style="width: 100%">
    
    <input type="hidden" name="action" value="<?php echo $input['action']; ?>" >
    <input type="hidden" name="post" value="">
    
    
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">
                <label class="sr-only" for="classroom">Classroom</label>
                <input type="text" class="form-control classroomSuggest" name="classroom" id="classroom" placeholder="Classroom"
                    value="<?php if(isset($input) && array_key_exists('classroom', $input)) { echo $input['classroom']; } ?>">
            </div>
            <div class="col-md-3">
                <label class="sr-only" for="courses">Courses</label>
                <input type="text" class="form-control" name="courses" id="courses" placeholder="Courses"
                    value="<?php if(isset($input) && array_key_exists('courses', $input)) { echo $input['courses']; } ?>">
            </div>
            <div class="col-md-3">
                <label class="sr-only" for="teacher">Author</label>
                <input type="text" class="form-control" name="teacher" id="teacher" placeholder="Author"
                    value="<?php if(isset($input) && array_key_exists('teacher', $input)) { echo $input['teacher']; } ?>">
            </div>
            <div class="col-md-2">
                <label class="sr-only" for="nweek">Number of weeks</label>
                <input type="number" min="0" class="form-control" name="nweek" id="nweek" placeholder="Number of weeks"
                    value="<?php if(isset($input) && array_key_exists('nweek', $input)) { echo $input['nweek']; } ?>"
                    required>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-block btn-success">
                    <span class="glyphicon glyphicon-search icon-white"></span> 
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
<?php ?>

<label>Selectionnez le cours&nbsp;:</label>
<select id="selectCourses" name="courseId">
    <?php foreach ($all['courses'] as $i => $course) { ?>
        <option value="<?php echo $course['id']; ?>"><?php echo $course['fullname']; ?></option>
    <?php } ?>
</select>

<label>Selectionnez le quiz&nbsp;:</label>

<?php if (count($all['courses'][0]['quizzes']) > 0){ ?>
    <select id="selectQuizzes" name="quizId">
        <?php foreach ($all['courses'][0]['quizzes'] as $j => $quiz) { ?>
            <option value="<?php echo $quiz['id']; ?>"><?php echo $quiz['name']; ?></option>
        <?php } ?>
    </select>
    <br/>
    <?php if (count($all['courses'][0]['quizzes'][0]['questions']) > 0){ ?>
        <div id="divQuizQuestion" style="width:100%;height:200px;overflow:auto;">
        <?php foreach ($all['courses'][0]['quizzes'][0]['questions'] as $k => $question) { ?>
            <div class="quizQuestion" id="<?php echo $k; ?>">
                <label style="width:60px;">Question <?php echo ($k+1); ?></label>
                <br>
                <p style="padding-left:10pt;"><?php echo $question['text']; ?></p>
                <input type="hidden" id="quiz_asset" name="quiz_questionId_Q<?php echo ($k+1); ?>" value="<?php echo $question['slot']; ?>"/>
                <input class="quiz_timecode" id="quiz_timecode_Q<?php echo ($k+1); ?>" name="quiz_timecode_Q<?php echo ($k+1); ?>" type="number" value="1" min="1" required/>
                <a class="button" href="javascript:getTimecode(<?php echo ($k+1); ?>);">Current Time</a>
            </div>
        <?php } ?>
        </div>
    <?php } else { ?>
        <div id="divQuizQuestion" style="width:100%;height:200px;overflow:auto;"></div>
    <?php } ?>

<?php } else { ?>
    <select id="selectQuizzes" disabled>
        <option value="-1">No quiz</option>
    </select>
    <br/>
    <div id="divQuizQuestion" style="width:100%;height:200px;overflow:auto;"></div>
<?php } ?>

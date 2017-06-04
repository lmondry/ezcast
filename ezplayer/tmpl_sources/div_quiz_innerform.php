<?php ?>

<label>®Quiz_select_course®&nbsp;:</label>
<select id="selectCourses" name="courseId">
    <?php foreach ($all['courses'] as $i => $course) { ?>
        <option value="<?php echo $course['id']; ?>"><?php echo $course['fullname']; ?></option>
    <?php } ?>
</select>

<label>®Quiz_select_quiz®&nbsp;:</label>

<?php if (count($all['courses'][0]['quizzes']) > 0){ ?>
    <select id="selectQuizzes" name="quizId">
        <?php foreach ($all['courses'][0]['quizzes'] as $j => $quiz) { ?>
            <option value="<?php echo $quiz['id']; ?>"><?php echo $quiz['name']; ?></option>
        <?php } ?>
    </select>
    <br/>
    <?php if (count($all['courses'][0]['quizzes'][0]['questions']) > 0){ ?>
        <div id="divQuizQuestion" style="width:100%;height:200px;overflow:auto;">
        <?php foreach ($all['courses'][0]['quizzes'][0]['questions'] as $k => $question) {

            switch ($question['type']) {
                case 'multichoice':
                    $type =  'Choix Multiple';
                    break;
                case 'truefalse':
                    $type =  'Vrai ou Faux';
                    break;
                case 'shortanswer':
                    $type =  'Réponse Courte';
                    break;
                default:
                    $type =  'Type inconnu';
                    break;
            }
            ?>
            <div class="quizQuestion" id="<?php echo $k; ?>">
                <label style="width:100px;text-align:left;">®Quiz_question® <?php echo ($k+1); ?></label>
                <br>
                <label style="width:150px;text-align:left;">®Quiz_question_type® : <?php echo $type; ?></label>
                <br>
                <p style="padding-left:10pt;"><?php echo $question['text']; ?></p>
                <input type="hidden" id="quiz_asset" name="quiz_questionId_Q<?php echo ($k+1); ?>" value="<?php echo $question['slot']; ?>"/>
                <input class="quiz_timecode" id="quiz_timecode_Q<?php echo ($k+1); ?>" name="quiz_timecode_Q<?php echo ($k+1); ?>" type="number" value="1" min="1" required/>
                <a class="button" href="javascript:getTimecode(<?php echo ($k+1); ?>);">®Quiz_current_time®</a>
            </div>
            <br>
        <?php } ?>
        </div>
    <?php } else { ?>
        <div id="divQuizQuestion" style="width:100%;height:200px;overflow:auto;"></div>
    <?php } ?>

<?php } else { ?>
    <select id="selectQuizzes" disabled>
        <option value="-1">®Quiz_no_quiz®</option>
    </select>
    <br/>
    <div id="divQuizQuestion" style="width:100%;height:200px;overflow:auto;"></div>
<?php } ?>

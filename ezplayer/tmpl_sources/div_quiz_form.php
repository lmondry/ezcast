<?php
/*
 * EZCAST EZplayer
 *
 * Copyright (C) 2016 Université libre de Bruxelles
 *
 * Written by Laurent Mondry <laurent.mondry@student.uclouvain.be>
 * UI Design by Julien Di Pietrantonio
 *
 * This software is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this software; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

    $t = $_SESSION['moodle_token'];
    $all = get_quiz_datastructure($t);

    $album = $_SESSION['album'];
    $asset = $_SESSION['asset'];

?>
    <div id="quiz_form_header" class="quiz-color">
        <span id="quiz_form_header_logo" class="quiz-logo"></span>
        <span class="form_header_label_quiz">®Add_quiz®</span>
    </div>
    <div id='quiz_form_wrapper'>
        <form action="index.php" method="post" id="submit_quiz_form" onsubmit="return false">
            <input type="hidden" name="album" id="quiz_album" value="<?php echo $album; ?>"/>
            <input type="hidden" name="asset" id="quiz_asset" value="<?php echo $asset; ?>"/>

            <br/>

            <!-- Title field-->
            <label>®Quiz_title®&nbsp;:
                <span class="small">®Title_info®</span>
            </label>
            <input name="title" tabindex='11' id="quiz_title" type="text" maxlength="70" value="" required/>

            <!-- Description field-->
            <label>®Description®&nbsp;:
                <span class="small">®optional®</span>
            </label>
            <textarea name="description" tabindex='12' id="quiz_description" rows="4" ></textarea>

            <br/>

            <?php echo generate_form($all); ?>

            <br/>

            <label>®Quiz_feedback® &nbsp;:
                <span class="small">®Quiz_feedback_info®</span>
            </label>
            <input type="checkbox" name="feedback" id="quiz_feedback" value="1">


            <br/><br/>
            <!-- Submit button -->
            <div class="cancelButton">
                <a class="button" tabindex='16' href="javascript: player_quiz_form_hide(true);">®Cancel®</a>
            </div>
            <div class="submitButton">
                <a id="subBtn" class="button" tabindex='17' href="javascript: if(quiz_form_check('quiz_timecode','quiz_title')){quiz_form_submit();}">®Quiz_add_form_button®</a>
            </div>
            <br />
        </form>
    </div>



<script>

  $('#quiz_form input').keydown(function (e) {
      if (e.keyCode == 13) {
          if (quiz_form_check('quiz_timecode','quiz_title')){
            quiz_form_submit();
          }
      }
  });

var all = <?php echo json_encode($all); ?>;

function getTimecode(id){
  document.getElementById('quiz_timecode_Q'+(id)).value = time;
}

if(all.courses[0].quizzes[0].name){
  document.getElementById('quiz_title').value = all.courses[0].quizzes[0].name;
}

if(all.courses[0].quizzes[0].intro){
  document.getElementById('quiz_description').value = all.courses[0].quizzes[0].intro.replace(/<(?:.|\n)*?>/gm, '');
}

function populateDivQuestions(courseId,quizId) {
    var fragment = document.createDocumentFragment();
    var sel = document.getElementById('divQuizQuestion');

    if (sel) {
        $('#divQuizQuestion').find('.quizQuestion').remove().end();
        $('#divQuizQuestion').find('br').remove().end();
    }

    var list = all.courses[courseId].quizzes[quizId].questions;
    if (list.length > 0) {
        list.forEach(function (obj, index) {
            var qtype = '';

            switch (obj.type) {
                case 'multichoice':
                    qtype =  '®Quiz_multichoice®';
                    break;
                case 'truefalse':
                    qtype =  '®Quiz_truefalse®';
                    break;
                case 'shortanswer':
                    qtype =  '®Quiz_shortanswer®';
                    break;
                default:
                    qtype =  '®Quiz_unknown type®';
                    break;
            }

            var opt = document.createElement('div');
            opt.className = 'quizQuestion';
            opt.id = index;
            opt.innerHTML = '<label style="width:100px;align=left;">®Quiz_question® ' + (index + 1) + '</label>';
            opt.innerHTML += '<br>';
            opt.innerHTML += '<label style="width:150px;text-align:left;">®Quiz_question_type® : '+qtype+'</label>';
            opt.innerHTML += '<br>';
            opt.innerHTML += '<p style="padding-left:10pt;">' + obj.text + '</p>';
            opt.innerHTML += '<input type="hidden" id="quiz_asset" name="quiz_questionId_Q' + (index + 1) + '" value="' + obj.slot + '"/>';
            opt.innerHTML += '<input class="quiz_timecode" id="quiz_timecode_Q' + (index + 1) + '" name="quiz_timecode_Q' + (index + 1) + '" type="number" value="1" min="1" max="' + (duration - 1) + '" required/>';
            opt.innerHTML += '<a class="button" href="javascript:getTimecode(' + (index + 1) + ');">®Quiz_current_time®</a>';
            fragment.appendChild(opt);
            var br = document.createElement('br');
            fragment.appendChild(br);
        });
    }
    sel.appendChild(fragment);
}

if(document.getElementById('selectCourses')) {
    document.getElementById('selectCourses').onchange = function () {

        if ($('#divQuizQuestion.quizQuestion')) {
            $('#divQuizQuestion').find('.quizQuestion').remove().end();
        }
        for (var i = 0; i < all.courses.length; i++) {
            if (all.courses[i].id == document.getElementById('selectCourses').value) {
                populateSelect('selectQuizzes', 'quizId', all.courses[i].quizzes, "name", "id", {
                    id: -1,
                    name: "®Quiz_no_quiz®"
                });
                for (var j = 0; j < all.courses[i].quizzes.length; j++) {
                    if (all.courses[i].quizzes[j].id == document.getElementById('selectQuizzes').value) {
                        populateDivQuestions(i, j);
                        document.getElementById('quiz_title').value = all.courses[i].quizzes[j].name;
                        document.getElementById('quiz_description').value = all.courses[i].quizzes[j].intro.replace(/<(?:.|\n)*?>/gm, '');
                        return;
                    }
                }
                return;
            }
        }
    }
}


if(document.getElementById('selectQuizzes')) {
    document.getElementById('selectQuizzes').onchange = function () {
        for (var i = 0; i < all.courses.length; i++) {
            for (var j = 0; j < all.courses[i].quizzes.length; j++) {
                if (all.courses[i].quizzes[j].id == document.getElementById('selectQuizzes').value) {
                    populateDivQuestions(i, j);
                    document.getElementById('quiz_title').value = all.courses[i].quizzes[j].name;
                    document.getElementById('quiz_description').value = all.courses[i].quizzes[j].intro.replace(/<(?:.|\n)*?>/gm, '');
                    return;
                }
            }
        }
    }
}
</script>

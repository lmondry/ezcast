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
?>

<div class="form" id="quiz_form">
    <div id="quiz_form_header" class="quiz-color">
        <span id="quiz_form_header_logo" class="quiz-logo"></span>
        <span class="form_header_label_quiz">Ajouter un quiz</span>
    </div>
    <div id='quiz_form_wrapper'>
        <form action="index.php" method="post" id="submit_quiz_form" onsubmit="return false">
            <input type="hidden" name="album" id="quiz_album" value="<?php echo $album; ?>"/>
            <input type="hidden" name="asset" id="quiz_asset" value="<?php echo $asset; ?>"/>

            <br/>

            <!-- Title field-->
            <label>Titre&nbsp;:
                <span class="small">Max. 70 caractères</span>
            </label>
            <input name="title" tabindex='11' id="quiz_title" type="text" maxlength="70" value="test"/>

            <!-- Description field-->
            <label>Description&nbsp;:
                <span class="small">Facultatif</span>
            </label>
            <textarea name="description" tabindex='12' id="bookmark_description" rows="4" ></textarea>

            <br/>

            <label>Selectionnez le cours&nbsp;:</label>
            <select id="selectCourses" name="courseId"></select>

            <label>Selectionnez le quiz&nbsp;:</label>
            <select id="selectQuizzes" name="quizId"></select>

            <br/>

            <div id="divQuizQuestion" style="width:800px;height:200px;overflow:auto;">
            </div>

            <br/><br/>
            <!-- Submit button -->
            <div class="cancelButton">
                <a class="button" tabindex='16' href="javascript: player_quiz_form_hide(true);">Annuler</a>
            </div>
            <div class="submitButton">
                <a id="subBtn" class="button" tabindex='17' href="javascript: if(quiz_form_check()) quiz_form_submit();">Ajouter le quiz</a>
            </div>
            <br />
        </form>
    </div>
</div>

<script>

$(document).ready(function() {
  $.getScript('js/lib_quiz.js');

  $('#quiz_form input').keydown(function (e) {
      if (e.keyCode == 13) {
          if (quiz_form_check()){
            quiz_form_submit();
          }
      }
  });
});

/*
function quiz_form_submit() {
  console.log($('#submit_quiz_form').serialize());
    var tab = document.getElementById('bookmark_source').value;
    (tab == 'personal') ? current_tab = 'main' : current_tab = 'toc';
    $.ajax({
        type: 'POST',
        url: 'index.php?action=bookmark_add&click=true',
        data: $('#submit_quiz_form').serialize(),
        success: function (response) {
            console.log(response);
            $('#div_right').html(response);
        }
    });
    // doesn't work in IE < 10
    //   ajaxSubmitForm('submit_bookmark_form', 'index.php', '?action=bookmark_add', 'div_right');
    player_bookmark_form_hide(true);

}
*/
</script>

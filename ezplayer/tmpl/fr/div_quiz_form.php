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

  $t = '5f553956068392ae27280ad3dcb2403e';
  $all = get_quiz_datastructure($t);
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
            <input name="title" tabindex='11' id="quiz_title" type="text" maxlength="70" value=""/>

            <!-- Description field-->
            <label>Description&nbsp;:
                <span class="small">Facultatif</span>
            </label>
            <textarea name="description" tabindex='12' id="quiz_description" rows="4" ></textarea>

            <br/>

            <!--
            <label>Selectionnez le cours&nbsp;:</label>
            <select id="selectCourses" name="courseId"></select>

            <label>Selectionnez le quiz&nbsp;:</label>
            <select id="selectQuizzes" name="quizId"></select>

            <br/>

            <div id="divQuizQuestion" style="width:800px;height:200px;overflow:auto;">
            </div>
            -->
            <?php echo generate_form($t,$all); ?>

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

//$(document).ready(function() {
  //$.getScript('js/lib_quiz.js');

  $('#quiz_form input').keydown(function (e) {
      if (e.keyCode == 13) {
          if (quiz_form_check()){
            quiz_form_submit();
          }
      }
  });
//});

var all = <?php echo json_encode($all); ?>;

function populateDivQuestions(courseId,quizId){
    var fragment = document.createDocumentFragment();
    var sel = document.getElementById('divQuizQuestion');

    if (sel){
      $('#divQuizQuestion').find('.quizQuestion').remove().end();
    }

    var list = all.courses[courseId].quizzes[quizId].questions;
    if(list.length > 0){
      list.forEach(function(obj, index) {
          var opt = document.createElement('div');
          opt.className = 'quizQuestion';
          opt.id = index;
          opt.innerHTML = '<label style="width:20px;">Q'+(index+1)+':</label>';
          opt.innerHTML += '<br>';
          opt.innerHTML += '<p style="padding-left:10pt;">'+obj.text+'</p>';
          opt.innerHTML += '<input type="hidden" id="quiz_asset" name="quiz_questionId_Q'+(index+1)+'" value="'+obj.slot+'"/>';
          opt.innerHTML += '<input class="quiz_timecode" id="quiz_timecode_Q'+(index+1)+'" name="quiz_timecode_Q'+(index+1)+'" type="number" value="0" required/>';
          opt.innerHTML += '<a class="button" href="javascript:document.getElementById(\x27quiz_timecode_Q'+(index+1)+'\x27).value = time;">Current Time</a>';
          opt.innerHTML += '<br><br>';
          fragment.appendChild(opt);
      });
    }
    //fragment.appendChild(document.createElement('br'));
    sel.appendChild(fragment);
  }

  if(document.getElementById('selectCourses')){
    document.getElementById('selectCourses').onchange = function(){

      if ($('#divQuizQuestion.quizQuestion')){
        $('#divQuizQuestion').find('.quizQuestion').remove().end();
      }
      for(var i = 0;i<all.courses.length;i++){
        if(all.courses[i].id == document.getElementById('selectCourses').value){
          populateSelect('selectQuizzes','quizId',all.courses[i].quizzes,"name","id",{id:-1,name:"No quiz"});
          for (var j = 0; j < all.courses[i].quizzes.length; j++) {
            if(all.courses[i].quizzes[j].id == document.getElementById('selectQuizzes').value){
              populateDivQuestions(i,j);
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


  if(document.getElementById('selectQuizzes')){

    document.getElementById('selectQuizzes').onchange = function(){
      for(var i = 0;i<all.courses.length;i++){
        for (var j = 0; j < all.courses[i].quizzes.length; j++) {
          if(all.courses[i].quizzes[j].id == document.getElementById('selectQuizzes').value){
            populateDivQuestions(i,j);
            document.getElementById('quiz_title').value = all.courses[i].quizzes[j].name;
            document.getElementById('quiz_description').value = all.courses[i].quizzes[j].intro.replace(/<(?:.|\n)*?>/gm, '');
            return;
          }
        }
      }
    }
  }
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

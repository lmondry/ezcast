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

            <div>
              <select id="selectCourses"></select>
              <select id="selectQuizzes"></select>
            </div>

            <br/>


            <!-- Timecode field-->
            <label>Temps Questions &nbsp;:
                <span class="small">Q1 &nbsp;:</span>
            </label>
            <input name="timecode" tabindex='15' id="quiz_timecode_Q1" type="number" value="0" required/>


            <div id="divQuizQuestion"> <!-- AJOUTER LES AUTRES QUESTIONS--></div>

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
  $.getScript('js/lib_quiz.js');
    /*$('#quiz_form input').keydown(function (e) {
        if (e.keyCode == 13) {
            if (quiz_form_check())
                quiz_form_submit();
        }
    });*/
</script>

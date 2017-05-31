<?php

/**
 * Return a specific layout to display in the pop-up after clicking the button to add a new quiz
 * Two layouts :
 * - One to confirm the loading of datas
 * - One to say that it needs a course to add a new quiz
 *
 * @global type $input
 */
function index($param = array()) {
    global $input;

    if(!empty($_SESSION['moodle_courses']))
        include_once template_getpath('popup_quiz_new.php');
    else
        include_once template_getpath('popup_quiz_new_nocourse.php');
}
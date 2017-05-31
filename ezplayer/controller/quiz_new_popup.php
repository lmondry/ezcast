<?php

/**
 * Return a specific bookmark to display in a popup (delete_bookmark / copy_bookmark)
 * @global type $input
 * @global type $repository_path
 * @global type $user_files_path
 */
function index($param = array()) {
    global $input;

    if(!empty($_SESSION['moodle_courses']))
        include_once template_getpath('popup_quiz_new.php');
    else
        include_once template_getpath('popup_quiz_new_nocourse.php');
}
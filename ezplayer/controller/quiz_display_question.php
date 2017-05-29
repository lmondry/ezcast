<?php

/**
 * Return a specific bookmark to display in a popup (delete_bookmark / copy_bookmark)
 * @global type $input
 * @global type $repository_path
 * @global type $user_files_path
 */
function index($param = array()) {
    global $input;

    $question_id = $input['questionId'];
    $question_html = $input['questionHtml'];

    include_once template_getpath('popup_quiz_display_question.php');
}
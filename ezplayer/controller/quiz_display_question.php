<?php

/**
 * Return a specific Moodle question to display in a popup to answer it
 * @global type $input
 */
function index($param = array()) {
    global $input;

    // Variables tha will be used in the template
    $question_id = $input['questionId'];
    $question_html = $input['questionHtml'];

    include_once template_getpath('popup_quiz_display_question.php');
}
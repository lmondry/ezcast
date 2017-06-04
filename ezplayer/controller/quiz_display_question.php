<?php

/**
 * Return a specific Moodle question to display in a popup to answer it
 * @global type $input
 */
function index($param = array()) {
    global $input;


    $option = $input['option'];

    switch ($option){
        case 'question':
            $question_id = $input['questionId'];
            $question_html = $input['questionHtml'];
            include_once template_getpath('popup_quiz_display_question.php');
            break;
        case 'confirmation':
            include_once template_getpath('popup_quiz_display_confirm.php');
            break;
        case 'feedback':
            $correction_html = $input['correctionHtml'];
            $generalFeedbackHTML = $input['feedbackHtml'];
            include_once template_getpath('popup_quiz_display_feedback.php');
            break;
        case 'noFeedback':
            include_once template_getpath('popup_quiz_display_noFeedback.php');
            break;

    }

}
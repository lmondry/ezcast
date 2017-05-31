<?php

/**
 * Return a specific quiz to delete to display in a popup
 * @global type $input
 * @global type $repository_path
 */
function index($param = array()) {
    global $input;
    global $repository_path;

    // Variables tha will be used in the template
    $quiz_album = $input['album'];
    $quiz_asset = $input['asset'];
    $quiz_title = $input['title'];

    ezmam_repository_path($repository_path);

    include_once template_getpath('popup_quiz_delete.php');
}
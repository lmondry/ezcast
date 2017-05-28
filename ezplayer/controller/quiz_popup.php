<?php

/**
 * Return a specific bookmark to display in a popup (delete_bookmark / copy_bookmark)
 * @global type $input
 * @global type $repository_path
 * @global type $user_files_path
 */
function index($param = array()) {
    global $input;
    global $repository_path;

    $quiz_album = $input['album'];
    $quiz_asset = $input['asset'];
    $quiz_title = $input['title'];

    ezmam_repository_path($repository_path);

    include_once template_getpath('popup_quiz_delete.php');
}
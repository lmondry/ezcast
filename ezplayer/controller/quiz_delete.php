<?php

/**
 * Removes an asset bookmark from the user's bookmarks list
 * @global type $input
 * @global type $repository_path
 * @global type $user_files_path
 */
function index($param = array()) {
    global $input;
    global $repository_path;

    $quiz_album = $input['album'];
    $quiz_asset = $input['asset'];

    // init paths
    ezmam_repository_path($repository_path);

    quiz_delete($quiz_album, $quiz_asset);

    $quiz = array();

    bookmarks_list_update();
}
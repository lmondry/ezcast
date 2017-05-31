<?php

/**
 * Removes an asset quiz from the user's quiz list
 * @global type $input
 * @global type $repository_path
 * @global type $user_files_path
 */
function index($param = array()) {
    global $input;
    global $repository_path;

    // Variables sent with ajax tha will be used in the by the quiz delete functions
    $quiz_album = $input['album'];
    $quiz_asset = $input['asset'];

    // init paths
    ezmam_repository_path($repository_path);

    // Call to quiz delete function
    quiz_delete($quiz_album, $quiz_asset);

    // Reinitialize the quiz array after deleting
    $quiz = array();

    // Refresh the quiz list in the div_right_details.php
    bookmarks_list_update();
}
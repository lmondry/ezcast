<?php

/**
 * Adds a bookmark in the bookmarks file (table of contents)
 * @param type $album the album the bookmark is intended to
 * @param type $asset the asset the bookmark is intended to
 * @param type $timecode the specific time code of the bookmark
 * @param type $title the title of the bookmark
 * @param type $description the description of the bookmark
 * @param type $keywords the keywords of the bookmark
 * @param type $level the level of the bookmark
 * @return boolean true if the bookmark has been added to the table of contents;
 * false otherwise
 */
function quiz_asset_add($album, $asset, $question_timecode, $title = '', $description = '', $courseId, $quizId, $questionId) {
    // Sanity check
    ChromePhp::log("inside 'lib_quiz.php'");


    if (!ezmam_album_exists($album))
        return false;

    if (!ezmam_asset_exists($album, $asset))
        return false;


    if (!isset($question_timecode) || $question_timecode == '' || $question_timecode < 0){
      return false;
    }

    // 1) set the repository path
    $quiz_path = ezmam_repository_path();


    if ($quiz_path === false) {
        return false;
    }

    // set user's file path
    $quiz_path = $quiz_path . '/' . $album;


    // remove the previous same bookmark if it existed yet
    //toc_asset_bookmark_delete($album, $asset, $timecode);
    // TODO

    /*
    // Get the bookmarks list
    $bookmarks_list = toc_album_bookmarks_list_get($album);
    $count = count($bookmarks_list);
    $index = 0;

    if ($count > 0) {
        $index = -1;

        // loop while the asset is older than the reference asset
        do {
            ++$index;
            $asset_ref = $bookmarks_list[$index]['asset'];
            $timecode_ref = $bookmarks_list[$index]['timecode'];
        } while($index < ($count-1) && $asset > $asset_ref);

        // if the asset already contains bookmarks, loop while
        // timecode is bigger than reference timecode
        while ($index < ($count-1) && $asset == $asset_ref && $timecode > $timecode_ref) {
            ++$index;
            $timecode_ref = $bookmarks_list[$index]['timecode'];
            $asset_ref = $bookmarks_list[$index]['asset'];
        }

        if ($index < 0) // no bookmarks yet
            $index = 0;
        if ($index > $count) // bookmark is in last position in the table of contents
            --$index;
    }

        // extract keywords from the description
    $keywords_array = get_keywords($description);
    // and save them as keywords
    foreach ($keywords_array as $keyword){
        if (strlen($keywords) > 0) $keywords .= ', ';
        $keywords .= $keyword;
    }

    // surround every url by '*' for url recognition in EZplayer
    $description = surround_url($description);
    // add a bookmark at the specified index in the albums list
    array_splice($bookmarks_list, $index, 0, array(null));*/

    $question = array('album' => $album, 'asset' => $asset, 'timecode' => $question_timecode,
        'title' => $title, 'description' => $description, 'courseId' => $courseId, 'quizId' => $quizId, 'questionId' => $questionId);

    return simple_assoc_array2xml_file($question, $quiz_path . "/_quiz.xml", "quiz", "question");
}

?>

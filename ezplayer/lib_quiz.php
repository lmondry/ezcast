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
function quiz_asset_add($album, $asset, $quiz) {
    // Sanity check
    ChromePhp::log("inside 'lib_quiz.php'");


    if (!ezmam_album_exists($album))
        return false;

    if (!ezmam_asset_exists($album, $asset))
        return false;
    // TODO : make verifications

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



    return assoc_array2xml_file($quiz, $quiz_path . "/_quiz.xml", "quiz", "question");
}

/**
 * Returns the list of (official) bookmarks for a given album
 * @param type $album the name of the album
 * @return the list of bookmarks for a given album; false if an error occurs
 */
function quiz_album_quiz_list_get($album) {
    // Sanity check

    if (!ezmam_album_exists($album))
        return false;

    // 1) set repository path
    $quiz_path = ezmam_repository_path();
    if ($quiz_path === false) {
        return false;
    }
    // 2) set user's file path
    $quiz_path = $quiz_path . "/" . $album;

    $assoc_album_quiz = array();
    // 3) if the xml file exists, it is converted in associative array
    if (file_exists($quiz_path . "/_quiz.xml")) {
        $xml = simplexml_load_file($quiz_path . "/_quiz.xml");
        if (!$xml)
            return false;
        $assoc_album_quiz = xml_file2assoc_array($xml, 'question');
    }

    return $assoc_album_quiz;
}

/**
 * Returns the list of (official) bookmarks for a specific asset in a given album
 * @param type $album the name of the album
 * @param type $asset the name of the asset
 * @return boolean|array the list of bookmarks related to the given asset,
 * false if an error occurs
 */
function quiz_asset_question_list_get($album, $asset) {
    $assoc_album_quiz = quiz_album_quiz_list_get($album);
    if (!isset($assoc_album_quiz) || $assoc_album_quiz === false || empty($assoc_album_quiz)) {
        return false;
    }

    $assoc_asset_quiz = array();
    $index = 0;
    $ref_asset = $assoc_album_quiz[$index]['asset'];
    $count = count($assoc_album_quiz);
    while ($index < $count && $asset >= $ref_asset) {
        if ($asset == $ref_asset) {
            array_push($assoc_asset_quiz, $assoc_album_quiz[$index]);
        }
        ++$index;
        if($index < $count) {
            $ref_asset = $assoc_album_quiz[$index]['asset'];
        }
    }

    return $assoc_asset_quiz;
}

// ---------------

?>
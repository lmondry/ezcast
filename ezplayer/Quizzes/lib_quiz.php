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
    ChromePhp::log("inside quiz_asset_add");


    if (!ezmam_album_exists($album))
        return false;

    if (!ezmam_asset_exists($album, $asset))
        return false;

    // 1) set the repository path
    $quiz_path = ezmam_repository_path();


    if ($quiz_path === false) {
        return false;
    }

    // set user's file path
    $quiz_path = $quiz_path . '/' . $album . '/' . $asset;


    // remove the previous same bookmark if it existed yet
    //toc_asset_bookmark_delete($album, $asset, $timecode);
    // TODO


    return assoc_array2xml_file($quiz, $quiz_path . "/_quiz.xml", "quiz", "question");
}

/**
 * Returns the list of (official) bookmarks for a given album
 * @param type $album the name of the album
 * @return the list of bookmarks for a given album; false if an error occurs
 */
function quiz_question_list_get($album,$asset) {
    //ChromePhp::log("inside quiz_album_quiz_list_get");
    // Sanity check

    if (!ezmam_album_exists($album)){
        return false;
    }

    // 1) set repository path
    $quiz_path = ezmam_repository_path();
    if ($quiz_path === false) {
        return false;
    }

    // 2) set user's file path
    $quiz_path = $quiz_path . "/" . $album . "/" . $asset;

    $assoc_album_quiz = array();
    // 3) if the xml file exists, it is converted in associative array
    if (file_exists($quiz_path . "/_quiz.xml")) {
        $xml = simplexml_load_file($quiz_path . "/_quiz.xml");
        if (!$xml)
            return false;
        $assoc_album_quiz = xml_file2assoc_array($xml, 'question');
    }

    ChromePhp::log("here test");
    ChromePhp::log($assoc_album_quiz);

    return $assoc_album_quiz;
}


// TODO : not userful ?
/**
 * Returns the list of (official) bookmarks for a specific asset in a given album
 * @param type $album the name of the album
 * @param type $asset the name of the asset
 * @return boolean|array the list of bookmarks related to the given asset,
 * false if an error occurs
 */
function quiz_asset_question_list_get($album, $asset) {
    //ChromePhp::log("inside quiz_asset_question_list_get");
    $assoc_album_quiz = quiz_album_quiz_list_get($album,$asset);

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


/**
 * Removes a specific bookmark from the bookmarks file (table of contents).
 * If it is the last bookmark contained in the file, the file is deleted.
 * @param type $album the album of the bookmark
 * @param type $asset the asset of the bookmark
 * @param type $timecode the timecode of the bookmark
 * @return an array of bookmarks if the bookmark has been deleted; false otherwise
 */
function quiz_delete($album, $asset, $title) {
    // Sanity check
    if (!ezmam_album_exists($album))
        return false;


    // 1) set the repository path
    $quiz_path = ezmam_repository_path();
    if ($quiz_path === false) {
        return false;
    }

    // set user's file path
    $quiz_path = $quiz_path . "/" . $album . "/" . $asset;

    return assoc_array2xml_file("", $quiz_path . "/_quiz.xml", "quiz", "question");

}


// ---------------

function generate_form($token, $all){

  $html = '<label>Selectionnez le cours&nbsp;:</label>';
  $html .= '<select id="selectCourses" name="courseId">';
  foreach ($all['courses'] as $i => $course) {
    $html .= '<option value="'.$course['id'].'"">'.$course['fullname'].'</option>';
  }
  $html .= '</select>';

  if (count($all['courses'][0]['quizzes']) > 0){
    error_log("here",0);
    $html .= '<label>Selectionnez le quiz&nbsp;:</label>';
    $html .= '<select id="selectQuizzes" name="quizId">';
    foreach ($all['courses'][0]['quizzes'] as $j => $quiz) {
      $html .= '<option value="'.$quiz['id'].'">'.$quiz['name'].'</option>';
      $html .= '</select>';

      $html .+ '<br/>';

      $html .= '<div id="divQuizQuestion" style="width:100%;height:200px;overflow:auto;">';
      if (count($all['courses'][0]['quizzes'][$j]['questions']) > 0){
        foreach ($all['courses'][0]['quizzes'][$j]['questions'] as $k => $question) {
          $html .= '<div class="quizQuestion" id="'.$k.'">';
          $html .= '<label style="width:20px;">Q'.($k+1).':</label>';
          $html .= '<br>';
          $html .= '<p style="padding-left:10pt;">'.$question['text'].'</p>';
          $html .= '<input type="hidden" id="quiz_asset" name="quiz_questionId_Q'.($k+1).'" value="'.$question['slot'].'"/>';
          $html .= '<input class="quiz_timecode" id="quiz_timecode_Q'.($k+1).'" name="quiz_timecode_Q'.($k+1).'" type="number" value="0" required/>';
          $html .= '<a class="button" href="javascript:getTimecode('.($k+1).');">Current Time</a>';
          $html .= '</div>';
        }
      }
      $html .= '</div>';
    }

  }else {
    $html .= '<select id="selectQuizzes" disabled>';
    $html .= '<option value="-1">No quiz</option>';
    $html .= '</select>';
    $html .= '<div id="divQuizQuestion" style="width:100%;height:200px;overflow:auto;"></div>';
  }

  //ChromePhp::log($html);
  return $html;
}

?>

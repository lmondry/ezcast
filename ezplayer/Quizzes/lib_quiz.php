<?php

/**
 * Adds a quiz in the quiz file of an asset
 * @param type $album the album the quiz is intended to
 * @param type $asset the asset the quiz is intended to
 * @param type $quiz an array containing the the questions, each question is a object of courseId,quizId,questionId,description,timecodecode,feedback,album and asset
 * @return boolean true if the quiz has been added to the quiz list;
 * false otherwise
 */
function quiz_asset_add($album, $asset, $quiz) {
    // Sanity check

    if (!ezmam_album_exists($album))
        return false;

    if (!ezmam_asset_exists($album, $asset))
        return false;

    // 1) set the repository path
    $quiz_path = ezmam_repository_path();


    if ($quiz_path === false) {
        return false;
    }

    // set quiz file path in the asset of the album
    $quiz_path = $quiz_path . '/' . $album . '/' . $asset;


    return assoc_array2xml_file($quiz, $quiz_path . "/_quiz.xml", "quiz", "question");
}

/**
 * Returns the list of questions of a quiz
 * @param type $album the name of the album
 * @param type $asset the name of the asset
 * @return the list of questions' quiz for a given album; false if an error occurs
 */
function quiz_question_list_get($album,$asset) {
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

    return $assoc_album_quiz;
}

/**
 * Remove a quiz by deleting the file from the asset folder.
 * @param type $album the album of the bookmark
 * @param type $asset the asset of the bookmark
 * @param type $timecode the timecode of the bookmark
 * @return an array of bookmarks if the bookmark has been deleted; false otherwise
 */
function quiz_delete($album, $asset) {
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

function generate_form($all){

  $html = '<label>Selectionnez le cours&nbsp;:</label>';
  $html .= '<select id="selectCourses" name="courseId">';
  foreach ($all['courses'] as $i => $course) {
    $html .= '<option value="'.$course['id'].'"">'.$course['fullname'].'</option>';
  }
  $html .= '</select>';

  if (count($all['courses'][0]['quizzes']) > 0){
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
          $html .= '<input class="quiz_timecode" id="quiz_timecode_Q'.($k+1).'" name="quiz_timecode_Q'.($k+1).'" type="number" value="1" min="1" required/>';
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

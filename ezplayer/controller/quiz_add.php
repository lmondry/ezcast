<?php

/**
 * Adds or edits a quiz to the user's quiz list
 * @global type $input
 * @global type $repository_path
 */
function index($param = array()) {
    global $input;
    global $repository_path;

    // Variables sent with ajax tha will be used in the by the quiz add functions
    $quiz_album = $input['album'];
    $quiz_asset = $input['asset'];
    $quiz_title = $input['title'];
    $quiz_description = $input['description'];
    $quiz_courseId = $input['courseId'];
    $quiz_quizId = $input['quizId'];

    // get all the timecodes of the questions
    $quiz_timecode = array();
    $index = 0;
    foreach ($input as $key => $value) {
        if (strpos($key, 'quiz_timecode') === 0) {
            $quiz_timecode[$index] = $value;
            $index++;
        }
    }

    // also get the id of the questions, in the same order than the timecode
    $quiz_questionId = array();
    $index = 0;
    foreach ($input as $key => $value) {
        if (strpos($key, 'quiz_questionId') === 0) {
            $quiz_questionId[$index] = $value;
            $index++;
        }
    }

    // Check if there is a feedback to give
    if($input["feedback"]){
      $quiz_feedback = 1;
    }else{
      $quiz_feedback = 0;
    }

    // If user not logged, don't add the quiz
    if (!acl_user_is_logged()) {
        return false;
    }

    foreach($quiz_timecode as $key => $value) {
        if (is_nan($quiz_timecode[$key])){
            bookmarks_list_update();
        }
    }

    // init paths
    ezmam_repository_path($repository_path);

    // Create a $quiz variable then push all data about the quiz in it and then call the function to add it
    if (acl_user_is_logged()) {
      $quiz = array();

      for ($i=0; $i < count($quiz_timecode); $i++) {
            $question = array('album' => $quiz_album, 'asset' => $quiz_asset, 'timecode' =>  $quiz_timecode[$i],
                'title' => $quiz_title, 'description' => $quiz_description, 'courseId' => $quiz_courseId, 'quizId' => $quiz_quizId, 'questionId' => $quiz_questionId[$i], 'feedback' => $quiz_feedback);
            array_push($quiz,$question);
      }

      quiz_asset_add($quiz_album, $quiz_asset, $quiz);
    }

    // Refresh the quiz list in the div_right_details.php
    bookmarks_list_update();
}

?>

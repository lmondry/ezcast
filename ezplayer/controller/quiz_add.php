<?php

/**
 * Adds or edits a bookmark to the user's bookmarks list
 * @global type $input
 * @global type $repository_path
 * @global type $user_files_path
 */
function index($param = array()) {
    ChromePhp::log("inside index - quiz_add.php");

    global $input;
    global $repository_path;


    $quiz_album = $input['album'];
    $quiz_asset = $input['asset'];
    $quiz_title = $input['title'];
    $quiz_description = $input['description'];
    $quiz_courseId = $input['courseId'];
    $quiz_quizId = $input['quizId'];

    //ChromePhp::log($input);

    $quiz_timecode = array();
    $index = 0;
    foreach ($input as $key => $value) {
        if (strpos($key, 'quiz_timecode') === 0) {
            //ChromePhp::log("quiz_timecode add");
            $quiz_timecode[$index] = $value;
            $index++;
        }
    }

    $quiz_questionId = array();
    $index = 0;
    foreach ($input as $key => $value) {
        if (strpos($key, 'quiz_questionId') === 0) {
            $quiz_questionId[$index] = $value;
            $index++;
        }
    }

    if($input["feedback"]){
      $quiz_feedback = 1;
    }else{
      $quiz_feedback = 0;

    }

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

    //ChromePhp::log("after adding quiz, after quiz_list_update");

    if (acl_user_is_logged()) {
      $quiz = array();

      //ChromePhp::log($quiz_timecode);
      for ($i=0; $i < count($quiz_timecode); $i++) {

            //ChromePhp::log($quiz_timecode[$i]);
            //quiz_asset_add($quiz_album, $quiz_asset, $quiz_timecode[$i], $quiz_title, $quiz_description, $quiz_courseId, $quiz_quizId, $quiz_questionId[$i]);
            $question = array('album' => $quiz_album, 'asset' => $quiz_asset, 'timecode' =>  $quiz_timecode[$i],
                'title' => $quiz_title, 'description' => $quiz_description, 'courseId' => $quiz_courseId, 'quizId' => $quiz_quizId, 'questionId' => $quiz_questionId[$i], 'feedback' => $quiz_feedback);
            array_push($quiz,$question);
      }

      //ChromePhp::log($quiz);
      quiz_asset_add($quiz_album, $quiz_asset, $quiz);
    }

    bookmarks_list_update();
}

?>

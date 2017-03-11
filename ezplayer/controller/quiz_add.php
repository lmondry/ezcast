<?php

/**
 * Adds or edits a bookmark to the user's bookmarks list
 * @global type $input
 * @global type $repository_path
 * @global type $user_files_path
 */
function index($param = array()) {
    ChromePhp::log("inside 'quiz_add.php'");

    global $input;
    global $repository_path;
    global $user_files_path;

    $quiz_album = $input['album'];
    $quiz_asset = $input['asset'];
    $quiz_title = $input['title'];
    $quiz_description = $input['description'];
    $quiz_courseId = $input['courseId'];
    $quiz_quizId = $input['quizId'];


    $quiz_timecode = array();
    $index = 0;
    foreach ($input as $key => $value) {
        if (strpos($key, 'quiz_timecode') === 0) {
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

    if (!acl_user_is_logged()) {
        return false;
    }

    /*
    foreach($timecode as $key => $value) {
        if (is_nan($quiz_timecode[$key]){
            //quizzes_list_update();
            //TODO
        }
    }

    if (!isset($bookmark_type) || ($bookmark_type != 'cam' && $bookmark_type != 'slide')) {
        $bookmark_type = '';
    }

    $str_bookmark_keywords = "";
    foreach(explode(",", $bookmark_keywords) as $keyword) {
        if($str_bookmark_keywords != "") {
            $str_bookmark_keywords .= ",";
        }
        $str_bookmark_keywords .= trim($keyword);
    }
    $bookmark_keywords = $str_bookmark_keywords;*/

    // init paths
    ezmam_repository_path($repository_path);
    //user_prefs_repository_path($user_files_path);

    /*if ($bookmark_source == 'personal') { // personal bookmarks
        user_prefs_asset_bookmark_add($_SESSION['user_login'], $bookmark_album, $bookmark_asset,
                $bookmark_timecode, $bookmark_title, $bookmark_description, $bookmark_keywords,
                $bookmark_level, $bookmark_type);

    // table of contents
    } else if (acl_user_is_logged() && acl_has_album_moderation($bookmark_album)) {
        toc_asset_bookmark_add($bookmark_album, $bookmark_asset, $bookmark_timecode, $bookmark_title,
                $bookmark_description, $bookmark_keywords, $bookmark_level, $bookmark_type);

    }

    log_append('add_asset_bookmark', 'bookmark added : album -' . $bookmark_album . PHP_EOL .
            'asset - ' . $bookmark_asset . PHP_EOL .
            'timecode - ' . $bookmark_timecode);

    // lvl, action, album, asset, timecode, target (personal|official), type (cam|slide), title, descr, keywords, bookmark_lvl
    trace_append(array('3', (array_key_exists('edit', $input) && $input['edit']) ? 'asset_bookmark_edit' : 'asset_bookmark_add',
        $bookmark_album, $bookmark_asset, $bookmark_timecode, $bookmark_source, $bookmark_type,
        $bookmark_title, $bookmark_description, $bookmark_keywords, $bookmark_level));

    bookmarks_list_update();*/
    if (acl_user_is_logged()) {
      $quiz = array();

      for ($i=0; $i < count($quiz_timecode); $i++) {
            //ChromePhp::log($quiz_timecode[$i]);
            //quiz_asset_add($quiz_album, $quiz_asset, $quiz_timecode[$i], $quiz_title, $quiz_description, $quiz_courseId, $quiz_quizId, $quiz_questionId[$i]);
            $question = array('album' => $quiz_album, 'asset' => $quiz_asset, 'timecode' =>  $quiz_timecode[$i],
                'title' => $quiz_title, 'description' => $quiz_description, 'courseId' => $quiz_courseId, 'quizId' => $quiz_quizId, 'questionId' => $quiz_questionId[$i]);
            array_push($quiz,$question);
      }
      ChromePhp::log($quiz);

      $quiz_path = ezmam_repository_path();


      if ($quiz_path === false) {
          return false;
      }

      // set user's file path
      $quiz_path = $quiz_path . '/' . $album;

      return assoc_array2xml_file($quiz, $quiz_path . "/_quiz.xml", "quiz", "question");
    }
    //TODO test that
}
?>

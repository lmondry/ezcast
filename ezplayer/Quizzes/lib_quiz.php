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
 * @param type $album the album of the quiz
 * @param type $asset the asset of the quiz
 * @return an array of questions if the quiz has been deleted; false otherwise
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

/**
 * This function generates the html form for the quiz add form
 * @param  $all : multidimentional array with every courses, quizzes and questions
 * @return string : the HTML code
 */
function generate_form($all){
    include_once template_getpath('div_quiz_innerform.php');
}

?>
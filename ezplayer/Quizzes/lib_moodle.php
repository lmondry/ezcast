<?php
// Some function are inspired by :
// https://github.com/moodlehq/sample-ws-clients/blob/master/PHP-REST/client.php


/**
 * This function retrieve the Moodle token thanks to the Moodle login server.
 * @global $moodle_webservice : Moodle external service to use
 * @global $moodle_basedir : Moodle root url
 * @param $username : moodle and ezcast username
 * @param $password : moodle and ezcast password
 * @return the token
 */
function get_moodle_token($username, $password){
    global $moodle_webservice;
    global $moodle_basedir;

    $moodle_location = $moodle_basedir;
    $loginserver_location = "/login/token.php";
    $serverurl = $moodle_location . $loginserver_location;
    $curl = new curl;
    $datas = array('username' => $username, 'password' => $password, 'service' => $moodle_webservice);
    $response = json_decode($curl->post($serverurl, $datas));
    return $response->token;
}

/**
 * This function retrieve the Moodle token and then save it in the $_SESSION variable
 * @param $username : moodle and ezcast username
 * @param $password : moodle and ezcast password
 * @return true
 */
function save_moodle_token_session($username, $password){
    $token = get_moodle_token($username,$password);
    $_SESSION['moodle_token'] = $token;
    return true;
}

/**
 * This function can request any Moodle web service and retrieve the response
 * @global $moodle_basedir : Moodle root url
 * @param $functionname : the web service to request
 * @param $token : the Moodle token
 * @param $datas : the datas to send with the request
 * @return an object containing the response of the request
 */
function moodle_request($functionname, $token, $datas)
{
    global $moodle_basedir;
    $restformat = 'json';
    $moodle_location = $moodle_basedir;
    $restserver_location = "/webservice/rest/server.php";
    $serverurl = $moodle_location . $restserver_location;

    $curl = new curl;

    $serverurl = $serverurl . '?wstoken=' . $token . '&wsfunction=' . $functionname;

    $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
    $response = json_decode($curl->post($serverurl . $restformat, $datas));
    //if(isset($response->exception)){TODO : do something if necessary}
    return $response;
}

/**
 * Get the site_info that contains the user id (use of Using get_site_info)
 * @param $token
 * @return an object containing the response of the request (containing user id)
 */
function get_site_info($token){
    $functionname = 'core_webservice_get_site_info';
    $datas = '';
    $response = moodle_request($functionname, $token, $datas);
    return $response;
}

/**
 * Get all the courses of a user (use of Using core_enrol_get_users_courses)
 * @param $token : the Moodle token
 * @param $userId : id of the moodle user logged
 * @return an object containing the response of the request (containing courses ids)
 */
function get_user_courses($token, $userId){
    $functionname = 'core_enrol_get_users_courses';
    $datas = array('userid' => $userId);
    $response = moodle_request($functionname, $token, $datas);
    return $response;
}

/**
 * Get all the quizzes of a course (Using mod_quiz_get_quizzes_by_courses)
 * @param $token : the Moodle token
 * @param $courseId : the id of the Moodle course
 * @return an object containing the response of the request (contain quizzes ids)
 */
function get_course_quizzes($token, $courseId){
    $functionname = 'mod_quiz_get_quizzes_by_courses';
    $datas = array('courseids' => array($courseId));
    $response = moodle_request($functionname, $token, $datas);
    return $response;
}

/**
 * Start a quiz (Using mod_quiz_start_attempt)
 * @param $token : the Moodle token
 * @param $quizId : the id of the quiz to start
 * @return an object containing the response of the request (contain attempt id)
 */
function start_quiz($token, $quizId){
    $functionname = 'mod_quiz_start_attempt';
    $datas = array('quizid' => $quizId, 'forcenew' => 1);
    $response = moodle_request($functionname, $token, $datas);
    return $response;
}

/**
 * Get the question of a page of a quiz for an attempt (Using mod_quiz_get_attempt_data)
 * @param $token : the Moodle token
 * @param $attemptId : id of the quiz attempt
 * @param $currentPage : the page number of the quiz
 * @return an object containing the response of the request (containing the questions of that page)
 */
function get_questions($token, $attemptId, $currentPage){
    $functionname = 'mod_quiz_get_attempt_data';
    $datas = array('attemptid' => $attemptId, 'page' => $currentPage);
    $response = moodle_request($functionname, $token, $datas);
    return $response;
}

/**
 * Finish the quiz (Using mod_quiz_process_attempt)
 * @param $attemptId : id of the quiz attempt
 * @return an object containing the response of the request (not really important here, just confirm the quiz is finished)
 */
function stop_quiz($attemptId){
    $functionname = 'mod_quiz_process_attempt';
    $datas = array('attemptid' => $attemptId, 'finishattempt' => 1);
    $response = moodle_request($functionname, '', $datas);
    return $response;
}

/**
 * Makes an multidimentional array with every courses, quizzes and questions
 * @param $token : the Moodle token
 * @return $all : multidimentional array with every courses, quizzes and questions
 */
function get_quiz_datastructure($token)
{
    $all = array();

    // Retrieve the infos to get the user id
    $user_info = get_site_info($token);

    // Retrieve all the courses and push them
    $courses = get_user_courses($token, $user_info->userid);
    $all['courses'] = array();
    foreach ($courses as $i => $course) {
        $all['courses'][$i] = array('id' => $course->id, 'fullname' => $course->fullname, 'shortname' => $course->shortname, 'quizzes' => array());
        // For each course get the quizzes and push them
        $quizzes = get_course_quizzes($token, $course->id);
        foreach ($quizzes->quizzes as $j => $quiz) {
            $all['courses'][$i]['quizzes'][$j] = array('id' => $quiz->id, 'name' => $quiz->name, 'intro' => $quiz->intro, 'questions' => array());
            // Starting the quizzes to get the questions
            $quiz_info = start_quiz($token, $quiz->id);
            $currentPage = 0;
            do {
                // For each quiz get the questions and push them
                $attempt = get_questions($token, $quiz_info->attempt->id, $currentPage);
                foreach ($attempt->questions as $k => $question) {
                    // Generate the question HTML code
                    $text = '';
                    $html = str_get_html($question->html, true, true, DEFAULT_TARGET_CHARSET, false, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
                    $qtext = $html->find('div.qtext');
                    $text = $qtext[0]->plaintext . "<br/>";
                    $atext = $html->find('div.answer');
                    $text .= str_replace("\n", "<br/>", $atext[0]->plaintext);

                    $all['courses'][$i]['quizzes'][$j]['questions'][$k] = array('page' => $question->page, 'type' => $question->type, 'slot' => $question->slot, 'number' => $question->number, 'text' => $text);
                }
                // Get the next page
                $currentPage = $attempt->nextpage;
            } while ($currentPage > 0);
            // Finish each quiz
            stop_quiz($quiz_info->attempt->id);
        }

    }
    return $all;
}

?>

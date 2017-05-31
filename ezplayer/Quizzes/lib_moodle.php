<?php
// https://github.com/moodlehq/sample-ws-clients/blob/master/PHP-REST/client.php



    function get_moodle_token($username,$password,$service){
        $moodle_location = "http://localhost/~laurent/moodle/";
        $loginserver_location = "/login/token.php";
        $serverurl = $moodle_location . $loginserver_location;
        $curl = new curl;
        $datas = array('username' => $username, 'password' => $password, 'service' => $service);
        $response = json_decode($curl->post($serverurl, $datas));
        return $response->token;
    }

    function save_moodle_token_session($login,$password,$service){
        $token = get_moodle_token($login,$password,$service);
        $_SESSION['moodle_token'] = $token;
        return true;
    }

  function moodle_request($functionname,$token,$datas){
    $restformat ='json';
    $moodle_location = "http://localhost/~laurent/moodle/";
    $restserver_location = "webservice/rest/server.php";
    $serverurl = $moodle_location . $restserver_location;

    $curl = new curl;

    $serverurl = $serverurl . '?wstoken=' . $token . '&wsfunction='.$functionname;

    $restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';
    $response = json_decode($curl->post($serverurl . $restformat, $datas));
    //if(isset($response->exception)){ TODO : do something}
    return $response;
  }

  // Using get_site_info
  function get_site_info($token){
    $functionname = 'core_webservice_get_site_info';
    $datas = '';
    $response = moodle_request($functionname,$token,$datas);
    return $response;
  }

  // Using core_enrol_get_users_courses
  function get_user_courses($token,$userId){
    $functionname = 'core_enrol_get_users_courses';
    $datas = array('userid' => $userId);
    $response = moodle_request($functionname,$token,$datas);
    return $response;
  }

  // Using mod_quiz_get_quizzes_by_courses
  function get_course_quizzes($token,$courseId){
    $functionname = 'mod_quiz_get_quizzes_by_courses';
    $arr = [];
    $datas = array('courseids' => array($courseId));
    $response = moodle_request($functionname,$token,$datas);
    return $response;
  }

  // Using mod_quiz_start_attempt
  function start_quiz($token,$quizId){
    $functionname = 'mod_quiz_start_attempt';
    $datas = array('quizid' => $quizId, 'forcenew' => 1);
    $response = moodle_request($functionname,$token,$datas);
    return $response;
  }

  // Using mod_quiz_get_attempt_data
  function get_questions($token,$attemptId,$currentPage){
    $functionname = 'mod_quiz_get_attempt_data';
    $datas = array('attemptid' => $attemptId, 'page' => $currentPage);
    $response = moodle_request($functionname,$token,$datas);
    return $response;
  }

  // Using mod_quiz_process_attempt
  function stop_quiz($attemptId){
    $functionname = 'mod_quiz_process_attempt';
    $datas = array('attemptid' => $attemptId,'finishattempt' => 1);
    $response = moodle_request($functionname,$token,$datas);
    return $response;
  }

  function get_data_login($login,$passwd,$service){
      save_moodle_token_session(strtolower($login),$passwd);//"MoodleQuizTest");

      if (!empty($_SESSION['moodle_token'])) {
          $user_info = get_site_info($_SESSION['moodle_token']);
          $_SESSION['moodle_uid'] = $user_info->userid;
          $courses_assoc = get_user_courses($_SESSION['moodle_token'],$user_info->userid);

          $courses = array();
          foreach ($courses_assoc as $i => $course) {
              //error_log(print_r($course,true));
              $courses[$i] = $course->id;
          }

          $_SESSION['moodle_courses'] = $courses;
      }
  }
  function get_quiz_datastructure($token){
    $all = array();
    $user_info = get_site_info($token);
    $courses = get_user_courses($token,$user_info->userid);
    $all['courses'] = array();
    foreach ($courses as $i => $course) {
      $all['courses'][$i] = array('id' => $course->id, 'fullname' => $course->fullname, 'shortname' => $course->shortname, 'quizzes' => array());
      $quizzes = get_course_quizzes($token,$course->id);
      foreach ($quizzes->quizzes as $j => $quiz) {
        $all['courses'][$i]['quizzes'][$j] = array('id' => $quiz->id, 'name' => $quiz->name, 'intro' => $quiz->intro, 'questions' => array());
        $quiz_info = start_quiz($token,$quiz->id);
        $currentPage = 0;

        do {
          $attempt = get_questions($token,$quiz_info->attempt->id,$currentPage);
          foreach ($attempt->questions as $k => $question) {
            //$html = str_get_html($question->html);
            $text = '';
            $html = str_get_html($question->html,true, true, DEFAULT_TARGET_CHARSET, false, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
            $qtext = $html->find('div.qtext');
            $text = $qtext[0]->plaintext . "<br/>";
            $atext = $html->find('div.answer');
            $text .= str_replace("\n", "<br/>",$atext[0]->plaintext);

            $all['courses'][$i]['quizzes'][$j]['questions'][$k] = array('page' => $question->page, 'type' => $question->type, 'slot' => $question->slot, 'number' => $question->number, 'text' => $text);
          }
          $currentPage = $attempt->nextpage;
        } while ($currentPage > 0);
        // TODO : stop quiz
      }

    }
    return $all;
  }

?>

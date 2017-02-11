$(document).ready(function() {
  var token = "80b84bac60ba7beba427b0468ed490c9"; // TODO : it is hardcoded, do the login thing
  var serverurl = 'http://localhost/~laurent/moodle/webservice/rest/server.php' ;
  var userid;
  var debug = true;
  var all = {};

  function ajaxRequest(moodleFunction,dataAdded){
    var dataMerged = {};
    var dataBase = {
      wstoken: token,
      wsfunction: moodleFunction,
      moodlewsrestformat: 'json'
    }

    for (var attrname in dataBase) { dataMerged[attrname] = dataBase[attrname]; }
    if (dataAdded != false){
      for (var attrname in dataAdded) { dataMerged[attrname] = dataAdded[attrname]; }
    }

    if(debug){
      console.log(moodleFunction+" : \n"+JSON.stringify(dataMerged, null, 4));
    }

    return $.ajax(
      {
        type: 'POST',
        data: dataMerged,
        url: serverurl,
        success: function(response){
          if(debug){
            console.log("Success: " + moodleFunction);
          }
        },
        error: function(response){
          if(debug){
            console.log("Error: " + moodleFunction);
            console.log("Response: " + response);
          }
        }
      }
    );
  }

  function populateSelect(selectId,list,innerHTML,valueHTML,empty){
    var fragment = document.createDocumentFragment();
    var sel = document.getElementById(selectId);

    $('#'+selectId).find('option').remove().end();

    if(list.length > 0){
      list.forEach(function(obj, index) {
          var opt = document.createElement('option');
          opt.innerHTML = obj[innerHTML];
          opt.value = obj[valueHTML];
          fragment.appendChild(opt);
      });
      document.getElementById(selectId).disabled = false;
    }else {
      var opt = document.createElement('option');
      opt.innerHTML = empty.name;
      opt.value = empty.id;
      fragment.appendChild(opt);
      document.getElementById(selectId).disabled = true;
    }
    sel.appendChild(fragment);
  }

  function getUserCourses(user){
    all.userid = user.userid;
    all.courses = [];
    ajaxRequest("core_enrol_get_users_courses",{userid:user.userid}).success(
      function(courses){
        courses.forEach(function(course){
          all.courses.push({id:course.id,fullname:course.fullname,shortname:course.shortname})
        });
        getCourseQuizes();
      }
    );
  }

  function getCourseQuizes(){
    ajaxRequest("mod_quiz_get_quizzes_by_courses",false).success(function(quizzes){
      for (var i = 0; i < all.courses.length; i++) {
        all.courses[i].quizzes = [];
        for (var j = 0; j < quizzes.quizzes.length; j++) {
          if(all.courses[i].id == quizzes.quizzes[j].course){
            all.courses[i].quizzes.push(
              {
                id:quizzes.quizzes[j].id,
                name:quizzes.quizzes[j].name,
                intro:quizzes.quizzes[j].intro
              });
            startQuiz(j,i);
          }
        }
      }
    });
  }

  function startQuiz(idQuiz,idCourse){
    all.courses[idCourse].quizzes[idQuiz].questions = [];
    ajaxRequest("mod_quiz_start_attempt",{quizid:all.courses[idCourse].quizzes[idQuiz].id,forcenew:1}).success(function(quiz){
      getQuestions(idQuiz,idCourse,quiz.attempt.id,0);
    });
  }

  function getQuestions(idQuiz,idCourse,idAttempt,currentPage){
    var text;
    ajaxRequest("mod_quiz_get_attempt_data",{attemptid: idAttempt, page: currentPage}).success(function(response){
      for(var i = 0;i < response.questions.length;i++){
        text = "</br>"
        text += $(response.questions[i].html).find('div.qtext').text() + "</br>";
        text += $(response.questions[i].html).find('div.answer').text().replace(/\n/g,"<br>") + "</br></br>";

        all.courses[idCourse].quizzes[idQuiz].questions.push(
          {
            html:response.questions[i].html,
            page:response.questions[i].page,
            type:response.questions[i].type,
            text:text
          });
      }
      if (response.nextpage > -1){
        getQuestions(idQuiz,idCourse,idAttempt,currentPage+1);
      }else{
        stopQuiz(response.attempt.id);
      }
    });
  }

  function stopQuiz(id){
    ajaxRequest("mod_quiz_process_attempt",{attemptid:id,finishattempt: 1}).success(function(response){
      populateSelect('selectCourses',all.courses,"fullname","id",{id:-1,name:"No course"});
      populateSelect('selectQuizzes',all.courses[0].quizzes,"name","id",{id:-1,name:"No quiz"});
      console.log(all);
    });
  }

  function populateDivQuestions(courseId,quizId){
    var fragment = document.createDocumentFragment();
    var sel = document.getElementById('divQuizQuestion');

    $('#divQuizQuestion').find('.quizQuestion').remove().end();

    var list = all.courses[courseId].quizzes[quizId].questions;
    console.log(list);
    if(list.length > 0){
      list.forEach(function(obj, index) {
          var opt = document.createElement('div');
          opt.className = 'quizQuestion';
          opt.id = index;
          opt.innerHTML = "type: " + obj.type + "\n" + obj.text;
          fragment.appendChild(opt);
      });
    }
    sel.appendChild(fragment);
  }

  document.getElementById('selectCourses').onchange = function(){
    for(var i = 0;i<all.courses.length;i++){
      if(all.courses[i].id == document.getElementById('selectCourses').value){
        populateSelect('selectQuizzes',all.courses[i].quizzes,"name","id",{id:-1,name:"No quiz"});
        return;
      }
    }
  }

  document.getElementById('selectQuizzes').onchange = function(){
    for(var i = 0;i<all.courses.length;i++){
      for (var j = 0; j < all.courses[i].quizzes.length; j++) {
        if(all.courses[i].quizzes[j].id == document.getElementById('selectQuizzes').value){
          populateDivQuestions(i,j);
          return;
        }
      }
    }
  }

  ajaxRequest("core_webservice_get_site_info",false).success(function(response){getUserCourses(response);});
});

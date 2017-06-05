var token = get_moodle_token_session();
//var serverurl = 'http://localhost/~laurent/moodle/webservice/rest/server.php' ;
var serverurl = get_moodle_server_url()+'/webservice/rest/server.php';
console.log('serverurl');
console.log(serverurl);
var debug = false;

/**
 * Retrieve the Moodle token from the PHP $_SESSION variable
 * @returns {t} the moodle token
 */
function get_moodle_token_session(){
    var t = '';
    $.ajax({
        type: 'POST',
        async: false,
        url: 'index.php?action=get_moodle_token&click=true',
        success:function(response){
            t=response;
        }
    });
    return t;
}

function get_moodle_server_url(){
    var servUrl = '';
    $.ajax({
        type: 'POST',
        async: false,
        url: 'index.php?action=get_moodle_servUrl&click=true',
        success:function(response){
            servUrl=response;
        }
    });
    return servUrl;
}

/**
 * Submits the quiz creation form to the server
 * This function replaces an existing quiz.
 * Then refresh the Quiz list
 */
function quiz_form_submit() {
    $.ajax({
        type: 'POST',
        url: 'index.php?action=quiz_add&click=true',
        data: $('#submit_quiz_form').serialize(),
        success: function (response) {
            $('#div_right').html(response);
        }
    });

    player_quiz_form_hide(true);
}

/**
 * Submits the quiz edition form to the server
 * This function replaces an existing quiz.
 * Then refresh the Quiz list
 */
function quiz_edit_form_submit() {
    $.ajax({
        type: 'POST',
        url: 'index.php?action=quiz_add&click=true',
        data: $('#submit_quiz_form_edit').serialize(),
        success: function (response) {
            $('#div_right').html(response);
        }
    });
}

/**
 * This function starts a quiz a retrieve the Quiz attempt
 * The quiz attempt is then used to retrieve the questions
 * @param IdQuiz : id of the quiz to start
 */
function getQuizForVideo(IdQuiz) {
    var questions = [];
    ajaxRequest("mod_quiz_start_attempt", {quizid: IdQuiz, forcenew: 1}).success(function (quiz) {
        getQuestionsForVideo(quiz.attempt.id, 0);
    });
}

/**
 * Function to retrieve the questions of a page of the previously started quiz
 * @param idAttempt : the id of the attempt of the started quiz
 * @param currentPage : the page of the started quiz
 */
function getQuestionsForVideo(idAttempt,currentPage) {
    ajaxRequest("mod_quiz_get_attempt_data", {attemptid: idAttempt, page: currentPage}).success(function (response) {
        for (var i in response.questions) {
            for (var j in quiz_array) {
                if (quiz_array[j].questionId == response.questions[i].slot) {
                    quiz_array[j]['html'] = response.questions[i].html;
                    quiz_array[j]['attemptid'] = idAttempt;
                }
            }
        }

        if (response.nextpage > -1) {
            getQuestionsForVideo(idAttempt, currentPage + 1);
        } else {
            //console.log('stopped');
        }
    });
}

/**
 * Shows/hides more information about the quiz
 * @param {type} elem
 */
function quiz_more_toggle(elem) {
    $('#quiz').toggleClass('active');
    $('#quiz_detail').slideToggle();
    elem.toggleClass('active');

    var millisecondsToWait = 350;
    setTimeout(function () {
        $('.quiz_scroll').scrollTo('#quiz');
        // Whatever you want to do after the wait
    }, millisecondsToWait);
}

/**
 * Prepares the fields of quiz edition form
 * @param {type} title
 * @param {type} description
 * @param {type} quiz_array, the array where all the informations of the quiz are stored
 */
function quiz_edit(title, description,quiz_array) {
    document.getElementById('quiz_title_edit').value = title;
    document.getElementById('quiz_description_edit').value = description;
    quiz_array.forEach(function(value,i){
        document.getElementById('quiz_timecode_edit_Q'+(i+1)).value = value.timecode;
    });
    quiz_edit_form_toggle();
}

/**
 * shows/hides the quiz edition form
 */
function quiz_edit_form_toggle() {
    $('#quiz').toggle();
    $('#quiz_info').toggle();
    $('#edit_quiz').toggle();
    $('#quiz_title_display').toggle();
    $('#quiz_more').toggle();
    $('.quiz_options').toggle();
    $('.question_display').toggle();
}

/**
 * Renders a modal window containing the quiz
 * @param {type} album
 * @param {type} asset
 * @returns {undefined}
 */
function popup_quiz(album, asset, title) {
    $('#div_popup').html('<div style="text-align: center;"><img src="images/loading_white.gif" alt="loading..." /></div>');

    $.ajax({
        type: 'POST',
        url: 'index.php?action=quiz_popup&click=true',
        data: 'album=' + album + '&asset=' + asset + '&title=' + title,
        success: function (response) {
            $('#div_popup').html(response);
        }
    });

    $('#div_popup').reveal($(this).data());
}

/**
 * Sends the quiz to be deleted to the server
 * @param {type} album
 * @param {type} asset
 * @returns {undefined}
 */
function quiz_delete(album, asset) {
    makeRequest('index.php', '?action=quiz_delete' +
        '&album=' + album +
        '&asset=' + asset +
        "&click=true", 'div_right');
    close_popup();
}

/**
 * Load the courses and quizzes for the quiz add form
 */
function quizzes_load() {
    // first close the previous modal (that asks if you want to load the quizzes)
    close_popup();

    $('#div_popup').html('<div style="text-align: center;"><img src="images/loading_white.gif" alt="loading..." /></div>');
    $('#div_popup').reveal($(this).data());

    $.ajax({
        type: 'POST',
        url: 'index.php?action=quizzes_load&click=true',
        success: function (response) {
            $('#quiz_form').html(response);
            close_popup();
            player_quiz_form_toggle();
        }
    });

}

function quiz_redo() {

    $.ajax({
        type: 'POST',
        url: 'index.php?action=quiz_display_question&click=true',
        data: {option:'confirmation'},
        success: function (response) {
            $('#div_popup').html(response);
        }
    });

    $('#div_popup').reveal($(this).data());
}

/**
 * Function to make an Ajax request
 * @param moodleFunction : the web service to request
 * @param dataAdded : data specific to the Moodle webservice
 * @returns {Object} Returns the complete object response
 */
function ajaxRequest(moodleFunction,dataAdded) {
    var dataMerged = {};
    var dataBase = {
        wstoken: token,
        wsfunction: moodleFunction,
        moodlewsrestformat: 'json'
    }

    // Merge the informations used in every requests and the ones that are specific to the moodle webservice
    for (var attrname in dataBase) {
        dataMerged[attrname] = dataBase[attrname];
    }
    if (dataAdded != false) {
        for (var attrname in dataAdded) {
            dataMerged[attrname] = dataAdded[attrname];
        }
    }

    if (debug) {
        console.log(moodleFunction + " : \n" + JSON.stringify(dataMerged, null, 4));
    }

    return $.ajax(
        {
            type: 'POST',
            data: dataMerged,
            url: serverurl,
            success: function (response) {
                if (debug) {
                    console.log("Success: " + moodleFunction);
                }
            },
            error: function (response) {
                if (debug) {
                    console.log("Error: " + moodleFunction);
                    console.log("Response: " + response);
                }
            }
        }
    );
}

/**
 * Generic Function to populate the selects in the quiz add form
 * @param selectId :
 * @param name
 * @param list
 * @param innerHTML
 * @param valueHTML
 * @param empty
 */
function populateSelect(selectId,name,list,innerHTML,valueHTML,empty) {
    var fragment = document.createDocumentFragment();
    var sel = document.getElementById(selectId);

    $('#' + selectId).find('option').remove().end();
    $('#' + selectId).attr('name', name)

    if (list.length > 0) {
        list.forEach(function (obj, index) {
            var opt = document.createElement('option');
            opt.innerHTML = obj[innerHTML];
            opt.value = obj[valueHTML];
            fragment.appendChild(opt);
        });
        if (document.getElementById(selectId)) {
            document.getElementById(selectId).disabled = false;
        }

    } else {
        var opt = document.createElement('option');
        opt.innerHTML = empty.name;
        opt.value = empty.id;
        fragment.appendChild(opt);
        if (document.getElementById(selectId)) {
            document.getElementById(selectId).disabled = false;
        }
    }
    if (document.getElementById(selectId)) {
        sel.appendChild(fragment);
    }
}


$(document).ready(function() {
    var userid;
    var all = {};


    /**
     * (NOT USED ANYMORE BUT MAY BE USEFUL IN THE FUTURE)
     * Get all the courses of a user (Using Using core_enrol_get_users_courses)
     * Then call the function to get the courses' quizzes (for every course)
     * @param $user : Object representing the moodle user logged
     */
    function getUserCourses(user) {
        all.userid = user.userid;
        all.courses = [];
        ajaxRequest("core_enrol_get_users_courses", {userid: user.userid}).success(
            function (courses) {
                courses.forEach(function (course) {
                    all.courses.push({id: course.id, fullname: course.fullname, shortname: course.shortname})
                });
                getCourseQuizes();
            }
        );
    }

    /**
     * (NOT USED ANYMORE BUT MAY BE USEFUL IN THE FUTURE)
     * Get all the quizzes of a course (Using mod_quiz_get_quizzes_by_courses)
     * Then call the function to start quizzes (for every quiz)
     */
    function getCourseQuizes() {
        ajaxRequest("mod_quiz_get_quizzes_by_courses", false).success(function (quizzes) {
            for (var i = 0; i < all.courses.length; i++) {
                all.courses[i].quizzes = [];
                for (var j = 0; j < quizzes.quizzes.length; j++) {
                    if (all.courses[i].id == quizzes.quizzes[j].course) {
                        all.courses[i].quizzes.push(
                            {
                                id: quizzes.quizzes[j].id,
                                name: quizzes.quizzes[j].name,
                                intro: quizzes.quizzes[j].intro
                            });
                        startQuiz(j, i);
                    }
                }
            }
        });
    }

    /**
     * (NOT USED ANYMORE BUT MAY BE USEFUL IN THE FUTURE)
     * Function to start a quiz
     * @param idQuiz : id of the quiz to start
     * @param idCourse : id of the course of the quiz to start (to add it in 'all' datastructure)
     */
    function startQuiz(idQuiz, idCourse) {
        all.courses[idCourse].quizzes[idQuiz].questions = [];
        ajaxRequest("mod_quiz_start_attempt", {
            quizid: all.courses[idCourse].quizzes[idQuiz].id,
            forcenew: 1
        }).success(function (quiz) {
            getQuestions(idQuiz, idCourse, quiz.attempt.id, 0);
        });
    }

    /**
     * (NOT USED ANYMORE BUT MAY BE USEFUL IN THE FUTURE)
     * (Recursive function)
     * Function to get the question of a page of a started quiz
     * @param idQuiz : id of the quiz to started
     * @param idCourse : id of the course of the quiz started
     * @param idAttempt : attempt number of the quiz
     * @param currentPage : page of the started quiz (recurse until page == -1)
     */
    function getQuestions(idQuiz, idCourse, idAttempt, currentPage) {
        var text;
        ajaxRequest("mod_quiz_get_attempt_data", {
            attemptid: idAttempt,
            page: currentPage
        }).success(function (response) {
            for (var i = 0; i < response.questions.length; i++) {
                text = $(response.questions[i].html).find('div.qtext').text() + "<br/>";
                text += $(response.questions[i].html).find('div.answer').text().replace(/\n/g, "<br/>");

                all.courses[idCourse].quizzes[idQuiz].questions.push(
                    {
                        html: response.questions[i].html,
                        page: response.questions[i].page,
                        type: response.questions[i].type,
                        slot: response.questions[i].slot,
                        number: response.questions[i].number,
                        text: text
                    });
            }
            if (response.nextpage > -1) {
                getQuestions(idQuiz, idCourse, idAttempt, currentPage + 1);
            } else {
                stopQuiz(response.attempt.id);
            }
        });
    }

    /**
     * (NOT USED ANYMORE BUT MAY BE USEFUL IN THE FUTURE)
     * Stop the quizzes and populate the selects
     * @param id : attempt number of the started quiz
     */
    function stopQuiz(id) {
        ajaxRequest("mod_quiz_process_attempt", {attemptid: id, finishattempt: 1}).success(function (response) {
            populateSelect('selectCourses', all.courses, "fullname", "id", {id: -1, name: "No course"});
            populateSelect('selectQuizzes', all.courses[0].quizzes, "name", "id", {id: -1, name: "No quiz"});
            if (debug) {
                console.log(all);
            }
        });
    }
});

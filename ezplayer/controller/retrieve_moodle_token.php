<?php

/**
 * Return the Moodle token to retrieve it in Javascript
 */
function index($param = array()) {
    echo $_SESSION['moodle_token'];
}
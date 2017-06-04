<?php

/**
 * Return the Moodle root url to retrieve it in Javascript
 */
function index($param = array()) {
    global  $moodle_basedir;
    echo $moodle_basedir;
}